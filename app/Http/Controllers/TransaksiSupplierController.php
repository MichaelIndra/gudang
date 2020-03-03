<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use App\Counter;
use Cart;
use App\TransaksiSuppDet;
use App\TransaksiSuppGlb;
use App\Stok;
use App\Barang;
use yajra\Datatables\Datatables;

class TransaksiSupplierController extends Controller
{
    private $sessionkey ='CUST';
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    public function index()
    {
        // return view('transaksi.customer.boarding', ['title'=>'TRANSAKSI CUSTOMER', 'tgl'=>$now, 'inv'=>$inv, 'sessionkey'=>$this->sessionkey]);
        return view('transaksi.supplier.transaksi', ['title'=>'TRANSAKSI SUPPLIER']);
    }

    public function create()
    {
        $c = Counter::find("INV-SUPP");
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

        return view('transaksi.supplier.boarding', ['title'=>'TRANSAKSI SUPPLIER', 'tgl'=>$now, 'inv'=>$inv, 'sessionkey'=>$this->sessionkey]);
    }

    public function data(Datatables $datatables){
        // join('transaksi_supp_dets', 'transaksi_supp_glbs.id_trans_supp', '=', 'transaksi_supp_dets.id_trans_supp')
            
        $builder = TransaksiSuppGlb::join('suppliers', 'transaksi_supp_glbs.id_supp', '=', 'suppliers.id_supp')
            ->select('transaksi_supp_glbs.id_trans_supp', 'transaksi_supp_glbs.total_harga', 'transaksi_supp_glbs.diskon',
                    'transaksi_supp_glbs.created_at',
                    'suppliers.nama_supp');
            

        return $datatables->of($builder)
            ->addColumn('detail', function($builder){
                return "<button onclick=show('$builder->id_trans_supp'); type='button' class='btn btn-circle btn-info '>detail</button>";
                
            })
            ->rawColumns(['detail'])
            ->make(true);
            //<i class="fa fa-print></i>&nbsp;
    }

    public function detail(Request $request){
        $inv = $request->get("id");
        $data = TransaksiSuppDet::join('barangs', 'transaksi_supp_dets.id_brg', '=', 'barangs.id_brg')
                        ->select('barangs.nama_brg', 'transaksi_supp_dets.qty', 'transaksi_supp_dets.harga_satuan',
                        'transaksi_supp_dets.harga_total')
                        ->where('transaksi_supp_dets.id_trans_supp', $inv)
            ->get();
        return response()->json(array('successs'=>true, 'data'=>$data));
    }

    private function getNoInvoice()
    {
        $count = Counter::find("INV-SUPP")->counter;
        $now = Carbon::now()->format('dmY');
        return 'INVSUP-'.$count .'-'.$now;
    }

    public function carisupp(Request $request){
        if ($request->has('q')){
            $nama = $request->q;
            $query = DB::table('suppliers')
                ->where('nama_supp', 'LIKE', "%{$nama}%")
                ->get();
            
            return response()->json($query);     
        }
    }

    public function caribrg(Request $request){
        if ($request->has('q')){
            $nama = $request->q;
            $idsupp = $request->session()->get('supp');
            $query = DB::table('barangs')
                ->where('id_supp', '=', "{$idsupp}")
                ->where('nama_brg', 'LIKE', "%{$nama}%")
                ->get();
            
            return response()->json($query);     
        }
    }

    public function carihrg(Request $request){
        if ($request->has('q')){
            $id_brg = $request->q;
            $query = DB::table('harga_supps')
                ->where('id_brg', 'LIKE', "%{$id_brg}%")
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
        return redirect('transaksisuppliers')->with('message', 'Berhasil hapus keranjang');
    }

    private function getIdSuppbyNameBrg(){
        $id_supp = '';
        foreach(Cart::getContent() as $data){
            $id_supp = Barang::find($data->id)->id_supp;
        }
        return $id_supp;
    }

    public function savesupp(Request $request){
        if($request->has('idsupp')){
            $idsupp = $request->idsupp;
            $request->session()->put('supp', $idsupp);
            Cart::session($this->sessionkey)->clear();
        }
    }

    public function addtransaksisupp(Request $request){
        $now = Carbon::now();
        $count = Counter::find("INV-SUPP")->counter;
        $upcount = $count + 1;

        $nota_supp = $request->input('notasupp');
        $diskon = (int) $request->input('diskon');
        $inv = $this->getNoInvoice();
        $id_supp = $request->session()->get('supp');
        
        $glb ['id_trans_supp'] = $inv;
        $glb ['total_harga'] =Cart::session($this->sessionkey)->getTotal();
        $glb ['diskon'] =$diskon;
        $glb ['nota_supp']=$nota_supp;
        $glb ['id_supp']=$request->session()->get('supp');
        TransaksiSuppGlb::create($glb);
        foreach(Cart::session($this->sessionkey)->getContent() as $data){
            $dt['id_brg'] = $data->id;
            $dt['qty'] = $data->quantity;
            $dt['harga_satuan'] = $data->price;
            $dt['harga_total'] = $data->price * $data->quantity;
            $dt['id_trans_supp'] = $inv;
            $stk['id_brg'] = $data->id;
            $stk['qty'] = $data->quantity;
            $stk['transaksi'] = $inv;
            $stk['action'] = 'IN';
            TransaksiSuppDet::create($dt);
            Stok::create($stk);

        }
        
        $cnt = Counter::find('INV-SUPP');
        $cnt->counter = $upcount;
        $cnt->save();
        Cart::session($this->sessionkey)->clear();
        $request->session()->forget(['supp']);
        //$request->session()->flush();
        return response()->json(['success'=>true,'url'=> route('transaksisupplier.index')]);
        // return redirect('transaksisuppliers')->with('message', 'Berhasil transaksi stok');
    }

    
}
