<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\Customer;
use App\Barang;
use App\Harga_cust;
use App\Harga_Cust_Hist;
use yajra\Datatables\Datatables;
use DB;


class HargaCustController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    private $rules = [
        'id_brg' => 'required',
        'harga'=> ['required', 'numeric'],
        'id_cust' => 'required',
        'komisi' => ['required', 'numeric'],
    ];

    private $rulesedit = [
        'harga'=> ['required', 'numeric'],
        'id_cust' => 'required',
        'komisi' => ['required', 'numeric'],
    ];
    
    public function index()
    {
        return view('hargacust.boarding', ['title'=>'HARGA CUSTOMER']);
    }

   
    public function create()
    {
        $data = Supplier::all();
        $cust = Customer::all();        
        return view('hargacust.create')->with(['supp_list' => $data, 'cust_list' =>$cust, 'title'=>'HARGA CUSTOMER']);        
    }

    
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $data = $request->except('supp');
        // dd ($data) ;
        Harga_cust::create($data);
        $data['keterangan'] = 'BARU';
        Harga_cust_Hist::create($data);
        return redirect('hargacusts')->with('message', 'Master harga customer tersimpan');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id, $idcust)
    {
        $hargacust = DB::table('harga_custs')
                ->join('barangs', 'harga_custs.id_brg', '=', 'barangs.id_brg')
                ->join('suppliers', 'suppliers.id_supp', '=', 'barangs.id_supp')
                ->join('customers', 'harga_custs.id_cust', '=', 'customers.id_cust')
                ->select(array('suppliers.nama_supp', 'barangs.id_brg', 'customers.id_cust',
                                'barangs.nama_brg', 'harga_custs.harga', 'customers.nama_cust', 'harga_custs.komisi'))
                ->where ('barangs.id_brg',$id)
                ->where ('customers.id_cust', $idcust)
                ->first();              

        //return $hargacust->id_brg;
        return view('hargacust.edit', compact('hargacust'));
    }

   
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rulesedit);
        $idcust = $request->get('id_cust');
        $hist['keterangan'] = 'GANTI';
        $hist['id_brg'] = $id;
        $hist['harga'] =$request->get('harga');
        $hist['id_cust'] = $idcust;
        $hist['komisi'] = $request->get('komisi');
        
        
        Harga_Cust::where('id_brg', $id)
            ->where('id_cust', $idcust)
            ->update(['komisi'=>$request->get('komisi'), 'harga'=>$request->get('harga')]);
        Harga_cust_Hist::create($hist);

        return redirect('hargacusts')->with('message', 'Master harga customer tersimpan');
    }

    public function data(Datatables $datatables){
        $builder = DB::table('harga_custs')
                ->join('barangs', 'harga_custs.id_brg', '=', 'barangs.id_brg')
                ->join('suppliers', 'suppliers.id_supp', '=', 'barangs.id_supp')
                ->join('customers', 'harga_custs.id_cust', '=', 'customers.id_cust')
                ->select(array('suppliers.nama_supp', 'barangs.id_brg', 'customers.id_cust',
                                'barangs.nama_brg', 'harga_custs.harga', 
                                'harga_custs.komisi', 'customers.nama_cust'))
                                ->get();
        
        return $datatables->of($builder)
        ->addColumn('action', 'hargacust/action')
        ->rawColumns(['action'])
        ->make(true);                        
    }

    public function fetch(Request $request){
        $value = $request->get('value');
        $data = Barang::where('id_supp', $value)->get();
        $output = '';
        foreach($data as $row)
        {
            $output .='<option value="'.$row->id_brg.'">'.$row->nama_brg.'</option>';
        }
        echo $output;    
    }

    
}
