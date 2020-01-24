@extends('index')

@section('content')
    <div class="col-md-7     panel panel-default">
        <div class="row">
            <div class="col-md-3">
                Nama Customer
            </div>
            <div class="col-md-3">
                <select  class="nm_cust form-control" id="nm_cust" style="width:150px;" name="nm_cust"></select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                Barang
            </div>
            <div class="col-md-3">
                <select  class="idbrg form-control" id="idbrg" style="width:150px;" name="idbrg"></select>
                
            </div>
            <div class="col-md-3">
                <input type="text" id="qty" disabled/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                Jenis Retur
            </div>
            <div class="col-md-3">
                <input type ="radio" name ="status" id="status" value="KMBLIRSK" checked/>KEMBALI RUSAK<br>
                <input type ="radio" name ="status" id="status" value="KRGKOMISI" />KURANG KOMISI<br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                Total Retur
            </div>
            <div class="col-md-3">
                <input type ="number" name ="total" id="total" class="total" />
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
               
            </div>
            <div class="col-md-3">
                <input type ="button" name ="save" id="save" class="save" value="SIMPAN"/>
                
            </div>
            <div class="col-md-3">
                <a href="{{route('retur.index')}}" class="btn btn-info" >Kembali</a>
                
            </div>
            
        </div>
    </div>


@endsection

@section('script')
    <script>
        $('.nm_cust').select2({
            placeholder: 'Nama Customer ...',
            ajax: {
                url: "{{ route('retur.getnama') }}",
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

        $('.idbrg').select2({
            placeholder: 'Barang ...',
            ajax: {
                url: "{{ route('retur.getbrg') }}",
                dataType: 'json',
                delay: 250,
                data : function (params){
                    return {
                        q : params.term,
                        idcust : $('#nm_cust').val(),
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

        $('.idbrg').on('select2:select', function (e){
            var id_brg = e.params.data.text;
            
            $.ajax({
                url: "{{ route('retur.getbrg') }}",
                data        : { 
                    q : id_brg,
                    idcust : $('#nm_cust').val(),
                },
                datatype    : 'JSON',
                success     : function(dt){
                    $('#qty').val(dt[0].qty);
                    $('#total').attr({
                        "max" : dt[0].qty,
                        'min' : 1
                    });
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

        $("#save").click(function(){
            if( parseInt($('#total').val()) > parseInt($('#qty').val()) ){
                alert('Total retur lebih besar dari pembelian. '+ $('#total').val() + ' vs '+$('#qty').val());
                return;
            } else if( $('#total').val() <= 0){
                alert('Total retur tidak boleh kurang/sama dengan 0');
                return;
            }
            $.ajax({
                type: "GET",
                url: "{{ route('retur.saveretur') }}",
                data: {
                    qtybl : $('#qty').val(),
                    idcust : $("#nm_cust").val(),
                    qty : $("#total").val(),
                    id_brg : $("#idbrg").val(),
                    status : $("input[name='status']:checked").val(),
                },
                dataType: "json",
                success: function (response) 
                {
                    
                    if (response.successs)
                    {
                        location.href=response.data;
                    }
                },
                error : function (a,b,c) 
                {
                    alert(b);
                }
            });
            
        });
    </script>    

@endsection