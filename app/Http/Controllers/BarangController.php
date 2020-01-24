<?php

namespace App\Http\Controllers;
use App\Supplier;
use App\Barang;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;
use DB;

class BarangController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    private $rules = [
        'id_supp' => 'required',
        'id_brg' => 'required',
        'nama_brg'=> 'required',
        'keterangan'=> 'required',
        
    ];

    private $rulesedit = [
        'id_supp' => 'required',
        'nama_brg'=> 'required',
        'keterangan'=> 'required',
        
    ];

    public function index()
    {
        return view('barang.boarding', ['title'=>'BARANG']);
    }

    
    public function create()
    {
        $namasupp = Supplier::orderBy('nama_supp')
            ->pluck('nama_supp','id_supp');
        return view('barang.create')->with(['supp' => $namasupp, 'title'=>'BARANG']);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $this->hurufBesar($request);
        $data = $request->all();
        Barang::create($data);
        return redirect('barangs')->with('message', 'Master barang tersimpan');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $supp = Supplier::orderBy('nama_supp')
            ->pluck('nama_supp','id_supp');
        return view('barang.edit', compact('barang', 'supp'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rulesedit);
        $request['id_brg'] = strtoupper($id);
        $barang = Barang::findOrFail($id);

        $this->hurufBesar($request);
        $data = $request->all();

        $barang->fill($data)->save();
        return redirect('barangs')->with('message', 'Master barang diganti');
    }

    private function hurufBesar($request){
        $request['id_supp'] = strtoupper($request->id_supp);
        $request['id_brg'] = strtoupper($request->id_brg);
        $request['nama_brg'] = strtoupper($request->nama_brg);
        $request['keterangan'] = strtoupper($request->keterangan);
    }

    public function data(Datatables $datatables){
        
        $builder= Barang::join('suppliers', 'barangs.id_supp', '=', 'suppliers.id_supp')
                ->select('suppliers.nama_supp', 'barangs.id_supp', 'barangs.nama_brg', 
                    'barangs.keterangan','barangs.id_brg')
                ->get();
                

        return $datatables->of($builder)
            ->addColumn('action', 'barang/action')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function cekid(Request $request){
        if($request->has('id_brg')){
            $idbrg = $request->id_brg;
            if($idbrg == '')
            {
                return "TIDAK BOLEH KOSONG";
            }
            if(Barang::where('id_brg', 'LIKE', "{$idbrg}")->exists()){
                return 'SUDAH ADA';
            }
            return "TIDAK ADA";
        }
        
       
    } 

}
