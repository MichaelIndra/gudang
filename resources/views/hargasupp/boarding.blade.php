@extends('index')

@section('head')
<a href="{{route('hargasupps.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Harga Supplier</a>
@endsection

@section('content')
    <div class="row-md-1">   
        <table class="display cell-border compact stripe" id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Supplier</th>
                <th>Nama Barang</th>
                <th>Harga Supplier</th>
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
               ajax: "{{ route('hargasupps.data') }}",
               columns :[
                     {data : 'nama_supp', name: 'nama_supp'},
                     {data : 'nama_brg', name : 'nama_brg'},
                     {data : 'harga', name : 'harga', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     {data: 'action', name : 'action', orderable : false}
                  ],
                 columnDefs : [
                    {targets : 2, className : 'dt-right'    },
                ]  
            });
         });
    </script>
    
@endsection