@extends('index')
@section('head')
<a href="{{route('hargacusts.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Harga Customer</a>
@endsection
@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Supplier</th>
                <th>Nama Barang</th>
                <th>Harga Customer</th>
                <th>Nama Customer</th>
                <th>Komisi</th>
                <th>Action</th>
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
               ajax: "{{ route('hargacusts.data') }}",
               columns :[
                     {data : 'nama_supp', name: 'nama_supp'},
                     {data : 'nama_brg', name : 'nama_brg'},
                     {data : 'harga', name : 'harga', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     {data : 'nama_cust', name : 'nama_cust'},
                     {data : 'komisi', name : 'komisi', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     {data: 'action', name : 'action', orderable : false}
                  ],
                 columnDefs : [
                    {targets : [2,4], className : 'dt-right'    },
                ]  
            });
         });
    </script>
    
@endsection