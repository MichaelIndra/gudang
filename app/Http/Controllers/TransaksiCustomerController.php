<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use App\Counter;
use Cart;
use App\Sales;
use App\Customer;
use App\TransaksiCustGlb;
use App\TransaksiCustDet;
use App\TransaksiCustbyr;
use App\Stok;
use App\Barang;
use yajra\Datatables\Datatables;
use PDF;
use App\Harga_Cust;
use App\Komisi;
use Illuminate\Support\Facades\Auth;

class TransaksiCustomerController extends Controller
{
    

    private $sessionkey ='CUST';
    private $rulesedit = [
        'bayar'=> ['required', 'numeric'],
    
    ];

    public function __construct(){
        // $this->middleware('auth');
    }
    public function index()
    {
        // return view('transaksi.customer.boarding', ['title'=>'TRANSAKSI CUSTOMER', 'tgl'=>$now, 'inv'=>$inv, 'sessionkey'=>$this->sessionkey]);
        return view('transaksi.customer.transaksi', ['title'=>'TRANSAKSI CUSTOMER']);
    }

    public function create(){
        $c = Counter::find("INV-CUST");
        $blnUpdate = Carbon::parse($c->updated_at)->format('M Y');
        $blnNow = Carbon::now()->format('M Y');
        $now = Carbon::now()->format('d/m/Y');

        if ($blnUpdate != $blnNow)
        {
            $nw = Carbon::now()->toDateTimeString();
            $c->counter     =1;
            $c->updated_at  =$nw;
            $c->save();
        }
        $inv = $this->getNoInvoice();
        return view('transaksi.customer.boarding', ['title'=>'TRANSAKSI CUSTOMER', 'tgl'=>$now, 'inv'=>$inv, 'sessionkey'=>$this->sessionkey]);
    }

    private function getNoInvoice()
    {
        $count = Counter::find("INV-CUST")->counter;
        $now = Carbon::now()->format('dmY');
        return 'INVCUS-'.$count .'-'.$now;
    }

    public function carisales(Request $request){
        if ($request->has('q')){
            $nama = $request->q;
            $query = DB::table('sales')
                ->where('nama_sales', 'LIKE', "%{$nama}%")
                ->get();
            
            return response()->json($query);     
        }
    }

    public function savesales(Request $request){
        if($request->has('idsales')){
            $idsales = $request->idsales;
            $request->session()->put('sales', $idsales);
        }
    }

    public function getsales(Request $request)
    {
        if($request->session()->has('sales')){
            return Sales::find($request->session()->get('sales'))->nama_sales;
        }
    }

    public function caricust(Request $request){
        if ($request->has('q')){
            $nama = $request->q;
            $query = DB::table('customers')
                ->where('nama_cust', 'LIKE', "%{$nama}%")
                ->get();
            
            return response()->json($query);     
        }
    }

    public function savecust(Request $request){
        if($request->has('idcust')){
            $idcust = $request->idcust;
            $request->session()->put('cust', $idcust);
        }
    }

    public function getcust(Request $request)
    {
        // if($request->session()->has('cust')){
        //     return Customer::find($request->session()->get('cust'))->nama_cust;
        // }
        $request->session()->forget(['cust', 'sales']);
        $request->session()->flush();
    }

    public function caribrg(Request $request){
        if ($request->has('q')){
            $nama = $request->q;
            $query = DB::table('barangs')
                ->join('harga_custs', 'barangs.id_brg', '=', 'harga_custs.id_brg')
                ->join('stoks', 'harga_custs.id_brg', '=', 'stoks.id_brg')
                ->where('nama_brg', 'LIKE', "%{$nama}%")
                ->where('harga_custs.id_cust',$request->session()->get('cust'))
                ->groupBy('barangs.id_brg','barangs.nama_brg' )
                ->select('barangs.id_brg', 'barangs.nama_brg')
                ->get();
            
            return response()->json($query);     
        }
    }

    public function carihrg(Request $request){
        if ($request->has('idbrg')){
            $id = $request->idbrg;
            $query = DB::table('barangs')
                ->join('harga_custs', 'barangs.id_brg', '=', 'harga_custs.id_brg')
                ->join('stoks', 'barangs.id_brg', '=', 'stoks.id_brg')
                ->where('barangs.id_brg', '=', "{$id}")
                ->where('harga_custs.id_cust',$request->session()->get('cust'))
                ->groupBy('barangs.id_brg', 'barangs.nama_brg', 'harga_custs.harga' )
                ->select('barangs.nama_brg', 'harga_custs.harga', 'barangs.id_brg', DB::raw('SUM(stoks.qty) AS qty'))
                ->get();
            
            return response()->json($query);     
        }
    }

    public function addcart(Request $request){
        $qty = (int) $request->input('qty');
        $harga = (int) $request->input('harga'); 
        $totharga = $qty * $harga;
        $nama = $request->input('nama');
        $data = array(
            'id' => $request->input('id'),
            'price' => $harga,
            'hargasatuan' => $harga,
            'name' => $nama,
            'quantity' => $qty
        );
        Cart::session($this->sessionkey)->add($data);
        return response()->json($data, 200);
    }

    public function destroy($rowid){
        Cart::session($this->sessionkey)->remove($rowid);
        return redirect('transaksicustomers')->with('message', 'Berhasil hapus keranjang');
    }

    public function addtransaksicust(Request $request){
        $sales = $request->session()->get('sales');
        $cust = $request->session()->get('cust');
        $user = Auth::user()->name;
        $keterangan = '-';
        $idtranssup = $this->getNoInvoice();
        $diskon = $request->input('diskon');
        $totdiskon = 
        $bayar = $request->input('bayar');
        $metode = $request->input('metode');
        $term = '-';
        if($metode == 'TERM'){
            $term = Customer::find($request->session()->get('cust'))->term;
        }
        
        $totharga = Cart::session($this->sessionkey)->getTotal();
        $totdiskon = $totharga * ($diskon/100);

        $status = $totharga > $bayar ? 'PIUTANG' : 'LUNAS';
        $statglb = 'TAW';
        // if($status == 'LUNAS'){
        //     $statglb = 'INV';
        // }else{
        //     $statglb = 'TAW';
        // }

        $transcustglb ['id_trans_cust'] = $idtranssup;
        $transcustglb ['total_harga'] = $totharga;
        $transcustglb ['diskon'] = $totdiskon;
        $transcustglb ['keterangan'] = $keterangan;
        $transcustglb ['status'] = $statglb;
        $transcustglb ['id_sales'] = $sales;
        $transcustglb ['id_cust'] = $cust;
        $transcustglb ['id_user'] = $user;
        TransaksiCustGlb::create($transcustglb);

        
        

        $transcustbyr ['bayar'] = $bayar;
        $transcustbyr ['status'] = $status;
        $transcustbyr ['metode'] = $metode;
        $transcustbyr ['term'] = $term;
        $transcustbyr ['id_cust'] = $cust;
        $transcustbyr ['id_trans_cust'] = $idtranssup;
        TransaksiCustbyr::create($transcustbyr);

        foreach(Cart::session($this->sessionkey)->getContent() as $data){
            $komisi = Harga_Cust::where('id_brg', $data->id)->where('id_cust', $cust)->first()->komisi;
            $dt['id_brg'] = $data->id;
            $dt['qty'] = $data->quantity;
            $dt['harga_satuan'] = $data->price;
            $dt['harga_total'] = $data->price * $data->quantity;
            $dt['id_trans_cust'] = $idtranssup;
            $dt['komisi'] = $data->quantity * $komisi;
            $dt['statuskomisi'] ='B';
            $stk['id_brg'] = $data->id;
            $stk['qty'] = ($data->quantity)*-1;
            $stk['transaksi'] = $idtranssup;
            $stk['action'] = 'OUT';
            TransaksiCustDet::create($dt);
            Stok::create($stk);
        }
        $cnt =Counter::find("INV-CUST");
        $count = $cnt->counter;
        $cnt->counter = $count + 1;
        $cnt->save();
        Cart::session($this->sessionkey)->clear();
        $request->session()->forget(['cust', 'sales']);
        // $request->session()->flush();
        return response()->json(['success'=>true,'url'=> route('transaksicustomer.index')]);
    }

    public function data(Datatables $datatables){
        
        $builder = DB::table('transaksi_cust_glbs')
            ->join('transaksi_cust_byrs', 'transaksi_cust_byrs.id_trans_cust', '=', 'transaksi_cust_glbs.id_trans_cust')
            ->join('customers', 'transaksi_cust_glbs.id_cust', '=', 'customers.id_cust')
            ->join('sales', 'transaksi_cust_glbs.id_sales', '=', 'sales.id_sales')
            ->where('transaksi_cust_byrs.status','PIUTANG')
            ->where('transaksi_cust_glbs.status','<>','CNL')
            ->select('transaksi_cust_glbs.id_trans_cust', 'transaksi_cust_glbs.total_harga', 'transaksi_cust_glbs.diskon',
                    'transaksi_cust_glbs.created_at', 'transaksi_cust_byrs.bayar',
                    'customers.nama_cust', 'sales.nama_sales', 'transaksi_cust_byrs.metode', 'transaksi_cust_byrs.status',                    
                    DB::raw('transaksi_cust_glbs.status statusinv'),
                    DB::raw('transaksi_cust_glbs.total_harga - transaksi_cust_glbs.diskon AS bersih'))
            ->get();

        return $datatables->of($builder)
            ->addColumn('print', function($builder){
                if($builder->statusinv == 'TAW'){
                    return    '<a class="btn btn-success btn-sm" href="'.route('transaksicustomer.printinvoice', ['invoice'=>$builder->id_trans_cust]).'">
                    PRINT</a>';
                }else{
                    return    '<a class="btn disabled btn-sm" href="">
                    PRINT</a>';
                }
                // return    '<a class="btn btn-success btn-sm" href="'.route('transaksicustomer.printinvoice', ['invoice'=>$builder->id_trans_cust]).'">
                // PRINT</a>';
                    
            })
            ->addColumn('bayarbut', function($builder){
                if($builder->statusinv == 'INV'){
                    return '<button class="btn btn-info"  disabled>BAYAR</button>';
                }else{
                    return '<button class="btn btn-info" data-mycustomer="'.$builder->nama_cust.'" 
                    data-myidtrans ="'.$builder->id_trans_cust.'" data-bayar="'.$builder->total_harga.'" data-toggle ="modal" data-target="#bayar">BAYAR</button>';
                }
                
            })
            ->addColumn('cancel', function($builder){
                if($builder->statusinv == 'TAW'){
                    return    '<a class="btn btn-danger btn-sm" href="'.route('transaksicustomer.cancel', ['invoice'=>$builder->id_trans_cust]).'">
                    CANCEL</a>';
                }else{
                    return    '<a class="btn disabled btn-sm" href="">
                    CANCEL</a>';
                }
                    
            })
            ->rawColumns(['print', 'bayarbut', 'cancel'])
            ->make(true);
            //<i class="fa fa-print></i>&nbsp;
    }

    public function cancel(Request $request){
        $invoice= $request->get('invoice');
        $updatestatus = TransaksiCustGlb::find($invoice);
        $updatestatus->status = 'CNL';
        $updatestatus->save();
        return redirect('transaksicustomers');
    }

    public function printinvoice(Request $request){
        $invoice= $request->get('invoice');
        $now = Carbon::now()->format('d/m/Y');
        $glb = DB::table('transaksi_cust_glbs')
            ->join('transaksi_cust_byrs', 'transaksi_cust_byrs.id_trans_cust', '=', 'transaksi_cust_glbs.id_trans_cust')
            ->join('customers', 'transaksi_cust_glbs.id_cust', '=', 'customers.id_cust')
            ->join('sales', 'transaksi_cust_glbs.id_sales', '=', 'sales.id_sales')
            ->where('transaksi_cust_glbs.id_trans_cust', $invoice)
            ->select('transaksi_cust_glbs.id_trans_cust', 'transaksi_cust_glbs.total_harga', 'transaksi_cust_glbs.created_at', 'transaksi_cust_glbs.diskon',
                    'transaksi_cust_glbs.created_at', 'customers.term',
                    'customers.nama_cust', 'customers.alamat', 'sales.nama_sales', 'transaksi_cust_byrs.metode', 'transaksi_cust_byrs.bayar', 
                    'transaksi_cust_byrs.status',
                    DB::raw('transaksi_cust_glbs.status statusinv'))
            ->first();

        $det = TransaksiCustDet::join('barangs', 'transaksi_cust_dets.id_brg', '=', 'barangs.id_brg')
            ->where('transaksi_cust_dets.id_trans_cust', $invoice)
            ->get();
        $summ = TransaksiCustDet::where('id_trans_cust', $invoice);
        $totsum['qty'] = $summ->sum('qty');
        $totsum['harga_satuan'] = $summ->sum('harga_satuan');
        $totsum['harga_total'] = $summ->sum('harga_total');
        
        $stat ='CTK';
        if($glb->status == 'LUNAS'){
            $stat ='INV';
        }    
        // pake Carbon::parse(created_at)
        // $pdf = PDF::loadview('transaksi.customer.invoice',['Attachment'=>false, 'glb'=>$glb, 'det'=>$det, 'now'=>$now, 'summ'=>$totsum])->setPaper('a4', 'landscape');
           
        $updatestatus = TransaksiCustGlb::find($invoice);
        $updatestatus->status = $stat;
        $updatestatus->save();
        // return $pdf->stream('invoice.pdf');
        return view('transaksi.customer.invoice',['glb'=>$glb, 'det'=>$det, 'now'=>$now, 'summ'=>$totsum]);
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $id = $request->get('myidtrans');
        $bayar = $request->get('bayar');
        $glb = TransaksiCustGlb::where('id_trans_cust', $id)->first();
        $byr = TransaksiCustbyr::where('id_trans_cust', $id)->first();
        $totbyr = $bayar + $byr->bayar;
        if($totbyr == $glb->total_harga)
        {
            $glb->status = 'INV';
            $glb->save();
            $byr->status = 'LUNAS';
            Komisi::where('id_sales', $glb->id_sales)
                        ->where('id_trans_cust', '-')
                        ->update(['id_trans_cust' => $id]);        
        }
        
        $byr->bayar =$totbyr;
        $byr->save();
        return redirect('transaksicustomers');
    }
}
