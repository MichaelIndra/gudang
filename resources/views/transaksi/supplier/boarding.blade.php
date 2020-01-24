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
                            Supplier
                        </div>
                        <div class="col-md-3">
                            <select  class="supp form-control" id="supp" style="width:150px;" name="supp"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Nota Supplier
                        </div>
                        <div class="col-md-3">
                        <input type="text" id="notasupp" class="form-control" style="width:350px;" />
                        </div>
                    </div>
                    </br>    
            </div>
            <div class="col-md-8 panel panel-default">
                @if(session('supp'))
                    <h2>{{App\Supplier::find(session('supp'))->nama_supp}}</h2>
                @endif
                Total Bayar
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
                    <div class="col-md-2">Total Beli</div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2"><select  class="nama_brg form-control" id="nama_brg" style="width:150px;" name="nama_brg"></select></div>
                    <div class="col-md-2"><input type="text" id="harga" value='0' class="harga form-control" disabled/></div>
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
                                    <td>{!! Form::open(['method'=>'DELETE', 'route'=>['transaksisupplier.destroy', $data->id]]) !!}
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
            <div class="col-md-4 panel panel-default">
                <div class="row">
                    <div class="col-md-4">Total Harga</div>
                    <div class="col-md-4"><input type="text" style="width:150px;" value ="{{ number_format(Cart::session($sessionkey)->getTotal(),2,',','.') }}" id="totbayar" class="totbayar form-control" disabled/></div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-4">Diskon</div>
                    <div class="col-md-4"><input type="number" id="diskon" style="width:150px;" class="form-control"/></div>
                </div> -->
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button id="save">Simpan</button></div>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection


@section('script')
    <script>
        $('.supp').select2({
            placeholder: 'Nama Supplier...',
            ajax: {
                url: "{{ route('transaksisupplier.carisupp') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                            text: item.nama_supp,
                            id: item.id_supp
                            }
                        })
                    };
            },
            cache: true
            }
        });
 
        $('.supp').on('select2:select', function (e){
            var id = e.params.data.id;
            $("#id_supp").val(id);   
            $('#nama_brg').select2('val', ""); 

            if($("#id_supp").val() != '{{session('supp')}}'){
                if(confirm('Ganti Supplier? Data belanja supplier akan dihapus')){
                    $.ajax({
                        url     : "{{ route('transaksisupplier.savesupp') }}",
                        data    : { idsupp : id},
                        cache   : true,
                        success: function (response) 
                            {
                                location.reload();
                            },
                    });
                }
            }else{
                $.ajax({
                    url     : "{{ route('transaksisupplier.savesupp') }}",
                    data    : { idsupp : id},
                    cache   : true,
                    success: function (response) 
                        {
                            location.reload();
                        },
                });
            }

            
        });

        $('#nama_brg').select2({
            placeholder: 'Nama Barang...',
            allowClear : true,
            ajax: {
                url: "{{ route('transaksisupplier.caribrg') }}",
                dataType: 'json',
                delay: 250,
                data : function(params){
                    return {
                        q:$.trim(params.term),
                        
                        };
                },
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

        $('#nama_brg').on('select2:select', function (e){
            var id = e.params.data.id;
            var text =e.params.data.text;
            $.ajax({
                type : "GET",
                url : "{{ route('transaksisupplier.carihrg') }}",
                data : { q:id },
                datatype : 'JSON',
                success : function(dt){
                    if(dt.length == 1){
                        $('#harga').val(dt[0].harga);
                        $('#addCart').prop('disabled',false);
                        $("#id_brg").val(id);
                        $("#nm_brg").val(text);
                    }else{
                        alert('Harga '+text+' tidak tersedia');
                        $('#harga').val('0');
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
                    url: "{{ route('transaksisupplier.addcart') }}",
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

        $("#save").click(function(){
            if (confirm('Input data transaksi??')){
                $.ajax({
                    type    : "GET",
                    url     : "{{ route('transaksisupplier.addtransaksisupp') }}",
                    headers : {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    data    : {
                                // diskon : $("#diskon").val(),
                                diskon : 0,
                                nota_supp : $("#notasupp").val(),
                                id_supp : $("#id_supp").val(),
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