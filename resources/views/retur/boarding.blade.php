@extends('index')

@section('head')
<a href="{{route('retur.add')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Retur</a>
@endsection

@section('content')
      <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>No Invoice</th>
                <th>Nama Customer</th>
                <th>QTY Retur</th>
                <th>Harga Barang</th>
                <th>Nilai Retur</th>
                <th>Nama Sales</th>
                
            </tr>
            </thead>
        </table>
    </div>

@endsection

@section('script')
    <script>
         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: "{{ route('retur.dataretur') }}",
               columns :[
                     {data : 'id_trans_cust', name: 'id_trans_cust'},
                     {data : 'nama_cust', name : 'nama_cust'},
                     {data : 'qty', name : 'qty'},
                     {data : 'harga', name : 'harga', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     {data : 'totalretur', name : 'totalretur', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     {data : 'nama_sales', name : 'nama_sales'},
                     
                     
                  ],
                  columnDefs : [
                    {targets : [3,4], className : 'dt-right'    },
                ] 
            });
         });
    </script>
    
@endsection