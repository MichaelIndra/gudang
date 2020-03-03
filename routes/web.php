<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', ['uses'=>'BoardingController@index', 'as'=>'boarding.index']);

Route::get('suppliers/data', ['uses'=>'SupplierController@data', 'as'=>'suppliers.data']);
Route::get('suppliers/cekid', ['uses'=>'SupplierController@cekid', 'as'=>'suppliers.cekid']);
Route::get('barangs/data', ['uses'=>'BarangController@data', 'as'=>'barangs.data']);
Route::get('barangs/cekid', ['uses'=>'BarangController@cekid', 'as'=>'barangs.cekid']);
Route::get('sales/data', ['uses'=>'SalesController@data', 'as'=>'sales.data']);
Route::get('sales/cekid', ['uses'=>'SalesController@cekid', 'as'=>'sales.cekid']);
Route::get('hargacusts/data', ['uses'=>'HargaCustController@data', 'as'=>'hargacusts.data']);
Route::get('hargasupps/data', ['uses'=>'HargaSuppController@data', 'as'=>'hargasupps.data']);
Route::get('customers/data', ['uses'=>'CustomerController@data', 'as'=>'customers.data']);
Route::get('customers/cekid', ['uses'=>'CustomerController@cekid', 'as'=>'customers.cekid']);
Route::get('transaksicustomers/data', ['uses'=>'TransaksiCustomerController@data', 'as'=>'transaksicustomers.data']);
Route::get('komisis/data', ['uses'=>'KomisiController@data', 'as'=>'komisis.data']);
Route::get('komisis/datainvoice', ['uses'=>'KomisiController@dataInvoice', 'as'=>'komisis.datainvoice']);


Route::post('hargacusts/fetch',['uses'=>'HargaCustController@fetch', 'as'=>'hargacusts.fetch']);
Route::post('hargasupps/fetch',['uses'=>'HargaSuppController@fetch', 'as'=>'hargasupps.fetch']);


Route::resource('suppliers', 'SupplierController')->except(['destroy']);
Route::resource('barangs', 'BarangController')->except(['destroy']);
Route::resource('sales', 'SalesController')->except(['destroy']);
Route::resource('hargacusts', 'HargaCustController')->except(['destroy', 'edit']);
Route::resource('hargasupps', 'HargaSuppController')->except(['destroy']);
Route::resource('customers', 'CustomerController')->except(['destroy']);
Route::resource('komisis', 'KomisiController')->except(['destroy', 'store', 'update', 'edit', 'show']);

Route::get('hargacusts/{id}/idcust/{idcust}', ['as' => 'hargacusts.edit', 'uses' => 'HargaCustController@edit']);

Route::group(['prefix'=>'transaksisuppliers'], function(){
    Route::get('/', ['uses'=>'TransaksiSupplierController@index', 'as'=>'transaksisupplier.index']);
    Route::get('/carisupp', ['uses'=>'TransaksiSupplierController@carisupp', 'as'=>'transaksisupplier.carisupp']);
    Route::get('/caribrg', ['uses'=>'TransaksiSupplierController@caribrg', 'as'=>'transaksisupplier.caribrg']);
    Route::get('/carihrg', ['uses'=>'TransaksiSupplierController@carihrg', 'as'=>'transaksisupplier.carihrg']);
    Route::get('/addcart', ['uses'=>'TransaksiSupplierController@addcart', 'as'=>'transaksisupplier.addcart']);
    Route::delete('/{transaksisupplier}/destroy', ['uses'=>'TransaksiSupplierController@destroy', 'as'=>'transaksisupplier.destroy']);
    Route::get('/addtransaksisupp', ['uses'=>'TransaksiSupplierController@addtransaksisupp', 'as'=>'transaksisupplier.addtransaksisupp']);
    // Route::post('/', ['uses'=>'TransaksiSupplierController@addtransaksisupp', 'as'=>'transaksisupplier.addtransaksisupp']);
    Route::get('/create', ['uses'=>'TransaksiSupplierController@create', 'as'=>'transaksisupplier.create']);
    Route::get('/data', ['uses'=>'TransaksiSupplierController@data', 'as'=>'transaksisupplier.data']);
    Route::get('/detail', ['uses'=>'TransaksiSupplierController@detail', 'as'=>'transaksisupplier.detail']);
});


Route::group(['prefix'=>'transaksicustomers'], function(){
    Route::get('/', ['uses'=>'TransaksiCustomerController@index', 'as'=>'transaksicustomer.index']);
    Route::get('/carisales', ['uses'=>'TransaksiCustomerController@carisales', 'as'=>'transaksicustomer.carisales']);
    Route::get('/caricust', ['uses'=>'TransaksiCustomerController@caricust', 'as'=>'transaksicustomer.caricust']);
    Route::get('/caribrg', ['uses'=>'TransaksiCustomerController@caribrg', 'as'=>'transaksicustomer.caribrg']);
    Route::get('/carihrg', ['uses'=>'TransaksiCustomerController@carihrg', 'as'=>'transaksicustomer.carihrg']);
    Route::get('/addcart', ['uses'=>'TransaksiCustomerController@addcart', 'as'=>'transaksicustomer.addcart']);
    Route::delete('/{transaksicustomer}/destroy', ['uses'=>'TransaksiCustomerController@destroy', 'as'=>'transaksicustomer.destroy']);
    Route::get('/addtransaksicust', ['uses'=>'TransaksiCustomerController@addtransaksicust', 'as'=>'transaksicustomer.addtransaksicust']);
    Route::get('/printinvoice', ['uses'=>'TransaksiCustomerController@printinvoice', 'as'=>'transaksicustomer.printinvoice']);
    Route::match(['put','patch'],'/update/{transaksicustomer}', ['uses'=>'TransaksiCustomerController@update', 'as'=>'transaksicustomer.update']);
    Route::get('/cancel', ['uses'=>'TransaksiCustomerController@cancel', 'as'=>'transaksicustomer.cancel']);
    Route::get('/create', ['uses'=>'TransaksiCustomerController@create', 'as'=>'transaksicustomer.create']);

});

Route::group(['prefix' => 'session'], function(){
    Route::get('/savesales', ['uses'=>'TransaksiCustomerController@savesales', 'as'=>'transaksicustomer.savesales']);
    Route::get('/getsales', ['uses'=>'TransaksiCustomerController@getsales', 'as'=>'transaksicustomer.getsales']);
    Route::get('/savecust', ['uses'=>'TransaksiCustomerController@savecust', 'as'=>'transaksicustomer.savecust']);
    Route::get('/getcust', ['uses'=>'TransaksiCustomerController@getcust', 'as'=>'transaksicustomer.getcust']);
    Route::get('/savesupp', ['uses'=>'TransaksiSupplierController@savesupp', 'as'=>'transaksisupplier.savesupp']);
});

Route::group(['prefix' => 'komisi'], function(){
    Route::get('/inputkomisi', ['uses'=>'KomisiController@inputkomisi', 'as'=>'komisi.inputkomisi']);
    Route::get('/batalkomisi', ['uses'=>'KomisiController@batalkomisi', 'as'=>'komisi.batalkomisi']);
    Route::get('/getkomisi', ['uses'=>'KomisiController@getKomisi', 'as'=>'komisi.getkomisi']);
    Route::get('/byinvoice', ['uses'=>'KomisiController@dataperinvoice', 'as'=>'komisi.byinvoice']);
    Route::get('/dataglobal', ['uses'=>'KomisiController@dataGlobal', 'as'=>'komisi.dataglobal']);
});

Route::group(['prefix' => 'retur'], function(){
    Route::get('/', ['uses'=>'ReturController@index', 'as'=>'retur.index']);
    Route::get('/data', ['uses'=>'ReturController@inputkomisi', 'as'=>'retur.data']);
    Route::get('/tambahretur', ['uses'=>'ReturController@tambahretur', 'as'=>'retur.tambahretur']);
    Route::get('/getnama', ['uses'=>'ReturController@getnama', 'as'=>'retur.getnama']);
    Route::get('/getbrg', ['uses'=>'ReturController@getbrg', 'as'=>'retur.getbrg']);
    Route::get('/saveretur', ['uses'=>'ReturController@saveretur', 'as'=>'retur.saveretur']);
    Route::get('/add', ['uses'=>'ReturController@add', 'as'=>'retur.add']);
    Route::get('/dataretur', ['uses'=>'ReturController@dataretur', 'as'=>'retur.dataretur']);
});

Route::group(['prefix' => 'stoks'], function(){
    Route::get('/', ['uses'=>'StokController@index', 'as'=>'stoks.index']);
    Route::get('/data', ['uses'=>'StokController@data', 'as'=>'stoks.data']);
    Route::post('/', ['uses'=>'StokController@adjust', 'as'=>'stoks.adjust']);
    
});

Route::group(['prefix' => 'reports'], function(){
    Route::get('/', ['uses'=>'ReportController@index', 'as'=>'reports.index']);
    Route::get('/data', ['uses'=>'ReportController@data', 'as'=>'reports.data']);
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pageError', function(){
    return view('khususerror');
});