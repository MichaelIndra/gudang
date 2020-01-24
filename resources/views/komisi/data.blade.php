@extends('index')
@section('content')
    <div class="row-md-1">   
        <table class="display " id="tabledata" style="width:100%">
            <thead>
            <tr>
                <th>No Invoice</th>
                <th>Nama Barang</th>
                <th>Nama Sales</th>
                <th>Nama Customer</th>
                <th>qty</th>
                <th>Komisi</th>
                <th>Check</th>
                <th>Batal</th>
            </tr>
            </thead>
        </table>
    </div>
    <button id="send">Tambah komisi</button>
    <a href="{{route('komisis.index')}}" class="btn btn-info ml-3">Kembali</a>
    <div id="temp"></div>
@endsection

@section('script')
    <script>
        $(function() {
            var tabel =$('#tabledata').DataTable({
               processing: true,
               serverSide: true,
               ajax: "{{ route('komisis.datainvoice') }}",
               columns :[
                     {data : 'id_trans_cust', name: 'id_trans_cust'},
                     {data : 'nama_brg', name : 'nama_brg'},
                     {data : 'nama_sales', name : 'nama_sales'},
                     {data : 'nama_cust', name : 'nama_cust'},                     
                     {data : 'qty', name : 'qty'},
                     {data : 'komisi', name : 'komisi'},
                     {data : 'check', name : 'check', orderable : false},
                     {data : 'cancel', name : 'cancel', orderable : false},
                  ],
                columnDefs: [
                    {
                        targets : 6,
                        checkboxes:{selectRow : true} 
                    }
                ],
                select : {
                    style : 'multi'
                }  
            });
                //brg: tabel.$('input[type="checkbox"]').serialize()
            $("#send").on('click', function(e){
                // e.preventDefault();
                var data=tabel.column(6).checkboxes.selected();
                //console.log(data.join(","));
                $.ajax({
                    url: "{{ route('komisi.inputkomisi') }}",
                    data: {
                         komisi : data.join(","),
                        // komisi :'duit'
                    },
                    cache   : true,
                    dataType: "json",
                    success: function (response) 
                    {
                        // console.log(response);
                        location.reload();
                    },
                    error : function (a,b,c) 
                    {
                        alert(b);
                    }
                });
            });
        });



         
         
    </script>
    
@endsection