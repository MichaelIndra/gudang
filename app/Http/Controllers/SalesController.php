<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use yajra\Datatables\Datatables;

class SalesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    private $rules = [
        'id_sales' => 'required',
        'nama_sales'=> 'required',
        'alamat'=> 'required',
        'telp'=> 'required',
    ];

    private $rulesedit = [
        'nama_sales'=> 'required',
        'alamat'=> 'required',
        'telp'=> 'required',
    ];

    public function index()
    {
        return view('sales.boarding', ['title'=>'SALES']);
    }

    
    public function create()
    {
        return view('sales.create', ['title'=>'SALES']);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $this->hurufBesar($request);
        $data = $request->all();
        Sales::create($data);
        return redirect('sales')->with('message', 'Master sales tersimpan');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $sales = Sales::findOrFail($id);
        return view('sales.edit', compact('sales'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rulesedit);
        $request['id_sales'] = strtoupper($id);
        $sales = Sales::findOrFail($id);

        $this->hurufBesar($request);
        $data = $request->all();

        $sales->fill($data)->save();
        return redirect('sales')->with('message', 'Master sales diganti');
    }

    private function hurufBesar($request){
        $request['id_sales'] = strtoupper($request->id_sales);
        $request['nama_sales'] = strtoupper($request->nama_sales);
        $request['alamat'] = strtoupper($request->alamat);       
    }

    public function data(Datatables $datatables){
        
        $builder = Sales::query()
            ->select('id_sales', 'nama_sales', 'alamat', 'telp');

        return $datatables->eloquent($builder)
            ->addColumn('action', 'sales/action')
            ->rawColumns(['action'])
            ->make();
    }
    public function cekid(Request $request){
        if($request->has('id_sales')){
            $id_sales = $request->id_sales;
            if($id_sales == '')
            {
                return "TIDAK BOLEH KOSONG";
            }
            if(Sales::where('id_sales', 'LIKE', "{$id_sales}")->exists()){
                return 'SUDAH ADA';
            }
            return "TIDAK ADA";
        }
        
       
    } 
    
}
