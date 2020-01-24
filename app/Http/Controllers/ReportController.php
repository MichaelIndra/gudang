<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TransaksiCustGlb;
use App\TransaksiCustDet;
use Carbon\Carbon;
use yajra\Datatables\Datatables;
use App\Komisi;
use DB;

class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    public function index()
    {
        $bulan = Carbon::today()->month;
        return view('report.invoice', ['title'=>'REPORT INVOICE']);
    }

    public function data(Datatables $datatables , Request $request){
        $bulan = Carbon::today()->month;
        $tahun = Carbon::now()->year;
        if(!empty($request->get('bulan'))){
            $time = explode('-',$request->get('bulan'));
            $tahun = $time[1];
            $bulan = $time[0];
        }
        $binding = [
            'tahun' =>$tahun,
            'bulan' =>$bulan
        ];    
        $builder = DB::select("SELECT transaksi_cust_glbs.total_harga totalcust, test.totalsupp, sum(komisis.komisi) komisi, transaksi_cust_glbs.id_trans_cust, (total_harga - (totalsupp+komisi)) cuan
            FROM transaksi_cust_glbs
            join 
                (SELECT sum((transaksi_cust_dets.qty * harga_supps.harga)) totalsupp, transaksi_cust_dets.id_trans_cust
                from transaksi_cust_dets
                join harga_supps on transaksi_cust_dets.id_brg = harga_supps.id_brg
                GROUP BY transaksi_cust_dets.id_trans_cust) test 
            on transaksi_cust_glbs.id_trans_cust = test.id_trans_cust
            join komisis on transaksi_cust_glbs.id_trans_cust = komisis.id_trans_cust
            WHERE transaksi_cust_glbs.status = 'INV' AND YEAR(transaksi_cust_glbs.created_at) = :tahun AND MONTH(transaksi_cust_glbs.created_at) = :bulan
            GROUP BY transaksi_cust_glbs.id_trans_cust"
            
            , $binding);
        
        return $datatables->of($builder)
        ->make(true);                        
    }
}
