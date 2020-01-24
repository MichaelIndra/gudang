<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TransaksiCustGlb;
use App\TransaksiCustDet;
use App\Retur;
use App\Stok;
use App\Komisi;
use App\Harga_cust;
use DB;
use yajra\Datatables\Datatables;

class ReturController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    public function index()
    {
        return view('retur.boarding', ['title'=>'RETUR CUSTOMER']);
    }

    public function add(){
        return view('retur.add', ['title'=>'RETUR CUSTOMER']);
    }

    public function dataretur(Datatables $datatables){
        $builder = DB::select("SELECT returs.id_trans_cust, nama_cust, nama_sales, qty, harga_custs.harga, (qty*harga_custs.harga) totalretur 
                            from returs 
                            inner join transaksi_cust_glbs on returs.id_trans_cust = transaksi_cust_glbs.id_trans_cust 
                            inner join customers on transaksi_cust_glbs.id_cust = customers.id_cust 
                            inner join sales on transaksi_cust_glbs.id_sales = sales.id_sales 
                            inner join harga_custs on returs.id_brg = harga_custs.id_brg 
                            where transaksi_cust_glbs.id_cust = harga_custs.id_cust")
            ;

        return $datatables->of($builder)
            ->make(true);
    }

    public function getnama(Request $request){
        if ($request->has('q')){
            $nama = $request->q;
            $query = TransaksiCustGlb::join('customers', 'transaksi_cust_glbs.id_cust', '=', 'customers.id_cust')
                ->where('transaksi_cust_glbs.status', 'INV')
                ->where('customers.nama_cust', 'LIKE', "%{$nama}%")
                ->groupBy('transaksi_cust_glbs.id_cust', 'customers.nama_cust')
                ->select('transaksi_cust_glbs.id_cust', 'customers.nama_cust')
                ->get();
            
            return response()->json($query);     
        }
    }
    public function getbrg(Request $request){
        if ($request->has('q')){
            $brg = $request->q;
            $idcust = $request->idcust;
            // $query = TransaksiCustDet::join('barangs', 'transaksi_cust_dets.id_brg', '=', 'barangs.id_brg')
            //     ->where('transaksi_cust_dets.id_trans_cust', "{$inv}")
            //     ->where('barangs.nama_brg', 'LIKE', "%{$brg}%")
            //     ->get();
            $query = DB::select("SELECT sum(test.qty) AS qty, test.nama_brg, test.id_trans_cust, test.id_brg FROM (
                SELECT (qty), nama_brg, transaksi_cust_glbs.id_trans_cust, barangs.id_brg FROM transaksi_cust_dets
                INNER JOIN barangs ON transaksi_cust_dets.id_brg = barangs.id_brg 
                INNER JOIN transaksi_cust_glbs ON transaksi_cust_dets.id_trans_cust = transaksi_cust_glbs.id_trans_cust
                INNER JOIN customers ON transaksi_cust_glbs.id_cust = customers.id_cust
                WHERE customers.id_cust = '{$idcust}'
                UNION
                SELECT (qty*-1), barangs.nama_brg, id_trans_cust, barangs.id_brg from returs inner join barangs ON returs.id_brg = barangs.id_brg 
                WHERE returs.status = 'KRGKOMISI') AS test
                WHERE test.nama_brg LIKE '%{$brg}%'
                GROUP by test.nama_brg, test.id_trans_cust, test.id_brg
                ORDER BY test.id_trans_cust DESC
                "
            );    
            
            return response()->json($query);     
        }
    }
    public function saveretur(Request $request){
        $retur = $request->all();
        
        $det = TransaksiCustDet::join('transaksi_cust_glbs', 'transaksi_cust_dets.id_trans_cust', '=', 'transaksi_cust_glbs.id_trans_cust')
            ->where('transaksi_cust_dets.id_brg', $retur['id_brg'])
            ->where('transaksi_cust_dets.qty', $retur['qtybl'])
            ->where('transaksi_cust_glbs.id_cust', $retur['idcust'])
            ->orderBy('transaksi_cust_glbs.id_cust', 'desc')
            ->first();
        $retur['id_trans_cust'] = $det->id_trans_cust;
        // return response()->json($retur);
        Retur::create($retur);

        if($retur['status'] == "KRGKOMISI"){
            $stk ['qty'] = $retur['qty'];
            $stk ['id_brg'] =$retur['id_brg'];
            $stk ['transaksi'] = $det->id_trans_cust;
            $stk ['action'] = 'RETUR';
            Stok::create($stk);
            
            $komisi = Harga_cust::where('id_brg', $retur['id_brg'])->where('id_cust', $det->id_cust)->first();
            $d['id_sales'] = $det->id_sales;
            $d['id_trans_cust'] = '-';
            $d['id_brg'] = $retur['id_brg'];
            $d['komisi'] = ($komisi->komisi * $retur['qty']) * -1;
            $d['action'] = 'RETUR';
            komisi::create($d);
            
        }
        $url = route('retur.index');
        return response()->json(array('successs'=>true, 'data'=>$url));
    }
}
