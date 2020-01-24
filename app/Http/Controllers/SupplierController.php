<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Supplier;
use yajra\Datatables\Datatables;

class SupplierController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    private $rules = [
        'id_supp' => 'required',
        'nama_supp'=> 'required',
        'alamat'=> 'required',
        'telp'=> 'required',
    ];

    private $rulesedit = [
        'nama_supp'=> 'required',
        'alamat'=> 'required',
        'telp'=> 'required',
    ];

   
    public function index()
    {
        return view('supplier.boarding', ['title'=>'SUPPLIER']);
    }

    
    public function create()
    {
        return view('supplier.create', ['title'=>'SUPPLIER']);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $this->hurufBesar($request);
        $data = $request->all();
        Supplier::create($data);
        return redirect('suppliers')->with('message', 'Master supplier tersimpan');
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rulesedit);
        $request['id_supp'] = strtoupper($id);
        $supplier = Supplier::findOrFail($id);

        $this->hurufBesar($request);
        $data = $request->all();

        $supplier->fill($data)->save();
        return redirect('suppliers')->with('message', 'Master supplier diganti');

    }

    private function hurufBesar($request){
        $request['id_supp'] = strtoupper($request->id_supp);
        $request['nama_supp'] = strtoupper($request->nama_supp);
        $request['alamat'] = strtoupper($request->alamat);       
    }

    public function data(Datatables $datatables){
        
        $builder = Supplier::query()
            ->select('id_supp', 'nama_supp', 'alamat', 'telp');

        return $datatables->eloquent($builder)
            ->addColumn('action', 'supplier/action')
            ->rawColumns(['action'])
            ->make();
    }

    public function cekid(Request $request){
        if($request->has('id_supp')){
            $id_supp = $request->id_supp;
            if($id_supp == '')
            {
                return "TIDAK BOLEH KOSONG";
            }
            if(Supplier::where('id_supp', 'LIKE', "{$id_supp}")->exists()){
                return 'SUDAH ADA';
            }
            return "TIDAK ADA";
        }
        
       
    } 
}
