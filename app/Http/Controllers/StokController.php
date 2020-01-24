<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stok;
use yajra\Datatables\Datatables;
use DB;

class StokController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('rule:OWN');
    }

    public function index(){
       

        return view('stok.boarding', ['title'=>'STOK']);
    }

    public function adjust(Request $request)
    {
        $data['id_brg'] = $request->post('myidbrg');
        $data['qty'] = $request->post('qty') *-1;
        $data['transaksi'] = 'ADJUST';
        $data['action'] = 'ADJ';
        Stok::create($data);
        return view('stok.boarding', ['title'=>'STOK']);
    }

    public function data(Datatables $datatables){
        $builder = Stok::join('barangs', 'stoks.id_brg', '=', 'barangs.id_brg')
            ->join('suppliers', 'barangs.id_supp', '=', 'suppliers.id_supp')
            ->select(DB::raw('sum(stoks.qty) stok'), 'barangs.nama_brg', 'suppliers.nama_supp', 'stoks.id_brg')
            ->groupBy('stoks.id_brg', 'barangs.nama_brg', 'suppliers.nama_supp')
            ->get();
        return $datatables->of($builder)
            ->addColumn('adjust', function($builder){
                return '<button class="btn btn-info" data-mysupp="'.$builder->nama_brg.'" 
                    data-myidbrg ="'.$builder->id_brg.'" data-mybrg="'.$builder->nama_supp.'" data-toggle ="modal" data-target="#adjust">ADJUST</button>';
                    
            })
            ->rawColumns(['adjust'])
            ->make(true);    
    }
}
