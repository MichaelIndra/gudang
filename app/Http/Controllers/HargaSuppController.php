<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Supplier;
use App\Barang;
use App\HargaSupp;
use App\HargaSuppHist;
use yajra\Datatables\Datatables;
use DB;

class HargaSuppController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    private $rules = [
        'id_brg' => 'required',
        'harga'=> ['required', 'numeric'],
    ];

    private $rulesedit = [
        'harga'=> ['required', 'numeric'],
    ];
    public function index()
    {
        return view('hargasupp.boarding', ['title'=>'HARGA SUPPLIER']);
    }

    public function create()
    {
        $data = Supplier::all();        
        return view('hargasupp.create')->with(['supp_list' => $data, 'title'=>'HARGA SUPPLIER']);
    }

    public function store(Request $request)
    {
        $message ="";
        $this->validate($request, $this->rules);
        $data = $request->except('supp');
        $cek = HargaSupp::where('id_brg', $request->id_brg)->get();

        if($cek->count() != 0)
        {
            $message = 'Master harga sudah pernah tersimpan';
        }else{
            HargaSupp::create($data);
            $data['keterangan'] = 'BARU';
            HargaSuppHist::create($data);
            $message = 'Master harga supplier tersimpan';
        }

       
        return redirect('hargasupps')->with('message', $message.'-'.$cek->count());
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $hargasupp = DB::table('harga_supps')
                ->join('barangs', 'harga_supps.id_brg', '=', 'barangs.id_brg')
                ->join('suppliers', 'suppliers.id_supp', '=', 'barangs.id_supp')
                ->select(array('suppliers.nama_supp', 'barangs.id_brg', 
                                'barangs.nama_brg', 'harga_supps.harga'))
                ->where ('barangs.id_brg',$id)->first();               
        return view('hargasupp.edit', compact('hargasupp'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rulesedit);
        $data = $request->only('harga');
        $hist['keterangan'] = 'GANTI';
        $hist['id_brg'] = $id;
        $hist['harga'] =$request->get('harga');
        
        
        HargaSupp::find($id)->fill($data)->save();
        HargaSuppHist::create($hist);

        return redirect('hargasupps')->with('message', 'Master harga supplier tersimpan');
    }

    public function data(Datatables $datatables){
        $builder = HargaSupp::join('barangs', 'harga_supps.id_brg', '=', 'barangs.id_brg')
                ->join('suppliers', 'suppliers.id_supp', '=', 'barangs.id_supp')
                ->select(array('suppliers.nama_supp', 'barangs.id_brg', 
                                'barangs.nama_brg', 'harga_supps.harga'))
                ->get();
        
        return $datatables->of($builder)
        ->addColumn('action', 'hargasupp/action')
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
