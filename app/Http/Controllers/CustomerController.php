<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use yajra\Datatables\Datatables;

class CustomerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    private $rules = [
        'id_cust' => 'required',
        'nama_cust'=> 'required',
        'alamat'=> 'required',
        'telp'=> 'required',
        'term' => ['required', 'numeric'],
    ];

    private $rulesedit = [
        'nama_cust'=> 'required',
        'alamat'=> 'required',
        'telp'=> 'required',
        'term' => ['required', 'numeric'],
    ];

    public function index()
    {
        return view('customer.boarding', ['title'=>'CUSTOMER']);
    }

    public function create()
    {
        return view('customer.create', ['title'=>'CUSTOMER']);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $this->hurufBesar($request);
        $data = $request->all();
        Customer::create($data);
        return redirect('customers')->with('message', 'Master customer tersimpan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $cust = Customer::findOrFail($id);
        return view('customer.edit', compact('cust'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rulesedit);
        $request['id_cust'] = strtoupper($id);
        $cust = Customer::findOrFail($id);

        $this->hurufBesar($request);
        $data = $request->all();

        $cust->fill($data)->save();
        return redirect('customers')->with('message', 'Master customer diganti');
    }

    private function hurufBesar($request){
        $request['id_cust'] = strtoupper($request->id_cust);
        $request['nama_cust'] = strtoupper($request->nama_cust);
        $request['alamat'] = strtoupper($request->alamat);       
    }

    public function data(Datatables $datatables){
        
        $builder = Customer::query()
            ->select('id_cust', 'nama_cust', 'alamat', 'telp', 'term');

        return $datatables->eloquent($builder)
            ->addColumn('action', 'customer/action')
            ->rawColumns(['action'])
            ->make();
    }

    public function cekid(Request $request){
        if($request->has('id_cust')){
            $idcust = $request->id_cust;
            if($idcust == '')
            {
                return "TIDAK BOLEH KOSONG";
            }
            if(Customer::where('id_cust', 'LIKE', "{$idcust}")->exists()){
                return 'SUDAH ADA';
            }
            return "TIDAK ADA";
        }
        
       
    } 
    
}
