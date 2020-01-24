@extends('index')

@section('head')
<a href="{{route('sales.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Data Sales</a>
@endsection

@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Sales</th>
                <th>Alamat</th>
                <th>Telepon</th>
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
               ajax: "{{ route('sales.data') }}",
               columns :[
                     {data : 'nama_sales', name: 'nama_sales'},
                     {data : 'alamat', name : 'alamat'},
                     {data : 'telp', name : 'telp'},
                     {data: 'action', name : 'action', orderable : false}
                  ]
            });
         });
    </script>
    
@endsection