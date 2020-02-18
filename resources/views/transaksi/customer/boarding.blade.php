@extends('index')

@section('content')

<div class="form-group">
    <div class ="panel-group">
        <div class="row panel panelatas">
            <div class="col-md-4 panel panel-default">
                    <div class="row">
                        <div class="col-md-3">
                            No Nota
                        </div>
                        <div class="col-md-3">
                            <input type="text" value="{{$inv}}" class="form-control" style="width:190px;" disabled/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Tanggal
                        </div>
                        <div class="col-md-3">
                            <input type="text" value="{{$tgl}}" class="form-control" style="width:150px;" disabled/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Sales
                        </div>
                        <div class="col-md-3">
                            <select  class="sales form-control" id="sales" style="width:150px;" name="sales"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Customer
                        </div>
                        <div class="col-md-3">
                            <select  class="customer form-control" id="customer" style="width:150px;" name="sales"></select>
                        </div>
                    </div>
                    
                    </br>    
            </div>
            <div class="col-md-8 panel panel-default">
                @if(session('cust'))
                    <h2>{{App\Customer::find(session('cust'))->nama_cust}}</h2>
                @endif
                @if(session('sales'))
                    <h3>{{App\Sales::find(session('sales'))->nama_sales}}</h3>
                @endif
                Total Harga
                <h2>Rp. {{ number_format(Cart::session($sessionkey)->getTotal(),2,',','.') }}</h2>
            </div>
            
        </div>
        
    </div>
    <input type="hidden" id="id_supp"/>
    <input type="hidden" id="id_brg"/>
    <input type="hidden" id="nm_brg"/>

    <div class ="panel-group " >
        <div class="row panel panelatas">
            <div class="col-md-12 panel ">
                <div class="row">
                    <div class="col-md-2">Nama Barang</div>
                    <div class="col-md-2">Harga Satuan</div>
                    <div class="col-md-2">Stok</div>
                    <div class="col-md-2">Total Beli</div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2"><select  class="nama_brg form-control" id="nama_brg" style="width:150px;" name="nama_brg"></select></div>
                    <div class="col-md-2"><input type="text" id="harga" value='0' class="harga form-control" disabled/></div>
                    <div class="col-md-2"><input type="text" id="stok" value='0' class="stok form-control" disabled/></div>
                    <div class="col-md-2"><input type="number" id="qty" class="stokbeli form-control" /></div>
                    <div class="col-md-2"><button id="addCart" class="addCart" disabled="disabled">Add</button></div>
                </div> 
                
            </div>
        </div>
    </div>

    <div class ="panel-group">
        <div class="row panel"> 
            <div class="col-md-12 panel panel-default">   
                <div class="table-responsive-sm">
                    <table class="display table-bordered table-striped table-sm" id="table" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga Satuan</th>
                                <th>Total Beli</th>
                                <th>Total Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Cart::session($sessionkey)->getContent() as $data)
                                @php 
                                    $tempTot = $data->price * $data->quantity
                                @endphp   
                                <tr>
                                    <td>{{$data->name}}</td>
                                    <td>{{number_format($data->price, 2, ',', '.')}}</td>
                                    <td>{{$data->quantity}}</td>
                                    <td>{{number_format($tempTot,2,',','.')}}</td>
                                    <td>{!! Form::open(['method'=>'DELETE', 'route'=>['transaksicustomer.destroy', $data->id]]) !!}
                                            <button onclick="return confirm('Yakin hapus keranjang?');" type="submit" class="btn btn-circle btn-danger ">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                x
                                            </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row panel-default">
            <div class="col-md-6 panel panel-default">
                
                <div class="row">
                        <div class="col-md-4">Diskon (dalam %)</div>
                        <div class="col-md-4"><input type="number" id="diskon" min="0" max="100" style="width:150px;" class="form-control"/></div>
                        <div class="col-md-2"><input type="text" style="width:150px;" id="totdiskon" class="totdiskon form-control" disabled/></div>
                </div>
                <div class="row">
                    <div class="col-md-4">Total Harga</div>
                    <div class="col-md-4"><input type="text" style="width:150px;" value ="{{ number_format(Cart::session($sessionkey)->getTotal(),2,',','.') }}" id="totbayar" class="totbayar form-control" disabled/></div>
                </div>
                <div class="row">
                        <div class="col-md-4">Bayar</div>
                        <div class="col-md-4"><select id="metode" style="width:150px;" class="metode form-control">
                            <option value="CASH">CASH</option>
                            <option value="TERM">TERM</option>
                        </select>
                        <div id="buktitrf"></div>
                        </div>
                        
                </div>
                
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button id="save">Simpan</button></div>
                    <a href="{{route('transaksicustomer.index')}}" class="btn btn-info ml-3" id="create-new-user">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection

@section('script')
    <script>
        $('.sales').select2({
            placeholder: 'Nama Sales...',
            ajax: {
                url: "{{ route('transaksicustomer.carisales') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                            text: item.nama_sales,
                            id: item.id_sales
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('.sales').on('select2:select', function (e){
            var id_sales = e.params.data.id;
            $.ajax({
                url     : "{{ route('transaksicustomer.savesales') }}",
                data    : { idsales : id_sales},
                cache   : true,
                success: function (response) 
                {
                    location.reload();
                },
            });
        });

        $('.customer').select2({
            placeholder: 'Nama Customer...',
            ajax: {
                url: "{{ route('transaksicustomer.caricust') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                            text: item.nama_cust,
                            id: item.id_cust
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('.customer').on('select2:select', function (e){
            var id_cust = e.params.data.id;
            $.ajax({
                url     : "{{ route('transaksicustomer.savecust') }}",
                data    : { idcust : id_cust},
                cache   : true,
                success: function (response) 
                {
                    location.reload();
                },
            });
        });

        $('.nama_brg').select2({
            placeholder: 'Nama Barang...',
            ajax: {
                url: "{{ route('transaksicustomer.caribrg') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                            text: item.nama_brg,
                            id: item.id_brg
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('.nama_brg').on('select2:select', function (e){
            var id_brg = e.params.data.id;
            var text = e.params.data.text;
            $.ajax({
                url         : "{{ route('transaksicustomer.carihrg') }}",
                data        : { idbrg : id_brg},
                datatype    : 'JSON',
                success     : function(dt){
                    console.log(dt);
                    if(dt.length == 1){
                        $('#harga').val(dt[0].harga);
                        $('#stok').val(dt[0].qty);
                        $('#addCart').prop('disabled',false);
                        $("#id_brg").val(id_brg);
                        $("#nm_brg").val(text);
                    }else{
                        alert('Harga '+text+' tidak tersedia');
                        $('#harga').val('0');
                        $('#stok').val('0');
                        $('#addCart').prop('disabled',true);
                    }
                },
                error: function(jqXHR, exception) {
                    if (jqXHR.status === 0) {
                        alert('Not connect.\n Verify Network.');
                    } else if (jqXHR.status == 404) {
                        alert('Requested page not found. [404]');
                    } else if (jqXHR.status == 500) {
                        alert('Internal Server Error [500].');
                    } else if (exception === 'parsererror') {
                        alert('Requested JSON parse failed.');
                    } else if (exception === 'timeout') {
                        alert('Time out error.');
                    } else if (exception === 'abort') {
                        alert('Ajax request aborted.');
                    } else {
                        alert('Uncaught Error.\n' + jqXHR.responseText);
                    }
                }  
            });
        });


        $("#addCart").click(function(){
            if ( $("#qty").val().length === 0 || $("#qty").val() == 0 )
            {
                alert('Masukan jumlah stok' );
            }else{
                $.ajax({
                    type: "GET",
                    url: "{{ route('transaksicustomer.addcart') }}",
                    data: {
                        id : $("#id_brg").val(),
                        qty : $("#qty").val(),
                        harga : $("#harga").val(),
                        nama : $('#nm_brg').val(),
                    },
                    dataType: "json",
                    success: function (response) 
                    {
                        location.reload();
                    },
                    error : function (a,b,c) 
                    {
                        alert(b);
                    }
                });
                
            }
        });
        $("#diskon").keyup(function(){
            
            
            var diskon = parseInt($("#diskon").val());
            var harga = parseInt({{Cart::session($sessionkey)->getTotal() }});
            var totdiskon = harga * (diskon/100);
            var totbayar = harga - totdiskon;
            $("#totdiskon").val(totdiskon);
            $("#totbayar").val(totbayar);
            
            // if($("#diskon").val()  ){
            //     alert('nan');
            // }else{
            //     alert('ora');
            // }
        });

        $("#save").click(function(){
            var no_byr;
            if($("#bukti").length){
                no_byr = $("#bukti").val();
            }else{
                no_byr='-';
            }
            if (confirm('Input data transaksi??')){
                $.ajax({
                    type    : "GET",
                    url     : "{{ route('transaksicustomer.addtransaksicust') }}",
                    data    : {
                                diskon : $("#diskon").val(),
                                bayar : 0,
                                metode : $("#metode").val(),
                                _token : "{{csrf_token()}}"
                                
                            },
                    
                    success : function (response) 
                    {
                        if(response.success){
                            window.location = response.url
                        }
                    },
                    error   : function (a,b,c) 
                    {
                        alert(b);
                    }        
                });
            }
        });

        $(document).ready(function(){
            var countCart = {{Cart::session($sessionkey)->getContent()->count()}};
            if(countCart == 0){
                $("#save").prop('disabled', true);
            }else{
                $("#save").prop('disabled', false);
            }
        });
    </script>
@endsection