<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use yajra\Datatables\Datatables;
use App\Komisi;
use DB;
use App\TransaksiCustGlb;
use App\TransaksiCustDet;
use Carbon\Carbon;

class KomisiController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('komisi.boarding', ['title'=>'KOMISI SALES']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('komisi.data', ['title'=>'KOMISI SALES']);
    }


    public function dataperinvoice(){
        return view('komisi.byinvoice', ['title'=>'KOMISI SALES']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 'hai';
        // $komisi = $request->input('komisi');
        // dd($komisi);
        // $dta = explode(",", $komisi);
        // return $dta;
        
    }

    public function inputkomisi(Request $request){
        $data= explode(",", $request->komisi);
        foreach($data as $a)
        {
            $inv = explode("|", $a);
            $transglb = TransaksiCustGlb::find($inv[1]);
            $d['id_sales'] = $transglb->id_sales;
            $d['id_trans_cust'] = $inv[1];
            $d['id_brg'] = $inv[0];
            $d['komisi'] = $inv[2];
            $d['action'] = 'IN';
            komisi::create($d);
            $transdet = TransaksiCustDet::where('id_trans_cust', $inv[1])
                ->where('id_brg', $inv[0])->first();
            $transdet->statuskomisi='S';
            $transdet->save();
        }
        
        return response()->json($d);
    }

    public function batalkomisi(Request $request){

        $transdet = TransaksiCustDet::where('id_trans_cust', $request->get('invoice'))
                ->where('id_brg', $request->get('idbrg'))->first();
            $transdet->statuskomisi='C';
            $transdet->save();
            return redirect('komisis');
    }

    public function data(Datatables $datatables){
        $builder = Komisi::join('sales', 'komisis.id_sales', '=', 'sales.id_sales')
                ->join('transaksi_cust_glbs', 'komisis.id_trans_cust', '=', 'transaksi_cust_glbs.id_trans_cust')
                ->groupBy('komisis.id_trans_cust', 'sales.nama_sales')
                ->select(DB::raw('sum(komisis.komisi) komisi'), 'sales.nama_sales', 'komisis.id_trans_cust');
        
        return $datatables->of($builder)
        ->addColumn('detail', function($builder){
            // return '<input  type="checkbox" value="'.$builder->id_brg.'/'.$builder->id_trans_cust.'"/>';
            return "<button onclick=show('$builder->id_trans_cust'); type='button' class='btn btn-circle btn-info '>detail</button>";
        })
        ->rawColumns(['detail'])
        ->make(true);                        
    }
    public function dataInvoice(Datatables $datatables){
        $builder = TransaksiCustGlb::join('transaksi_cust_dets', 'transaksi_cust_glbs.id_trans_cust', '=', 'transaksi_cust_dets.id_trans_cust')
            ->join('sales', 'transaksi_cust_glbs.id_sales', '=', 'sales.id_sales')
            ->join('barangs', 'transaksi_cust_dets.id_brg', '=', 'barangs.id_brg')
            ->join('customers', 'transaksi_cust_glbs.id_cust', '=', 'customers.id_cust')
            ->where('transaksi_cust_glbs.status', 'INV')
            ->where('transaksi_cust_dets.statuskomisi', 'B')
            ->select('sales.nama_sales', 'transaksi_cust_glbs.id_trans_cust',
                    'barangs.nama_brg', 'transaksi_cust_dets.qty', 
                    'transaksi_cust_dets.komisi', 'transaksi_cust_dets.id_brg', 'customers.nama_cust');   
        return $datatables->of($builder)
            ->addColumn('check', function($builder){
                // return '<input  type="checkbox" value="'.$builder->id_brg.'/'.$builder->id_trans_cust.'"/>';
                return $builder->id_brg.'|'.$builder->id_trans_cust.'|'.$builder->komisi;
            })
            ->addColumn('cancel', function($builder){
                return    '<a  class="btn btn-danger btn-sm" href="'.route('komisi.batalkomisi', ['invoice'=>$builder->id_trans_cust, 'idbrg'=>$builder->id_brg]).'">BATAL</a>';
            })
            ->rawColumns(['check', 'cancel'])
            ->make(true);    
    }
    public function dataGlobal(Datatables $datatables, Request $request){
        $bulan = Carbon::today()->month;
        $tahun = Carbon::now()->year;
        if(!empty($request->get('bulan'))){
            $time = explode('-',$request->get('bulan'));
            $tahun = $time[1];
            $bulan = $time[0];
        }    
        $builder = Komisi::join('sales', 'komisis.id_sales', '=','sales.id_sales')
            ->groupBy('komisis.id_sales', 'nama_sales')
            ->select('nama_sales', DB::raw('sum(komisi) total_komisi'), 'komisis.id_sales')
            ->whereYear('komisis.created_at', $tahun)
            ->whereMonth('komisis.created_at', $bulan);
        
        return $datatables->of($builder)
            ->make(true);
    }

    public function getKomisi(Request $request){
        $inv = $request->get("id");
        $data = Komisi::join('barangs', 'komisis.id_brg', '=', 'barangs.id_brg')
            ->where('id_trans_cust', $inv)
            ->get();
        return response()->json(array('successs'=>true, 'data'=>$data));
    }
}
