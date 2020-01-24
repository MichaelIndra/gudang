@extends('index')

@section('head')
<a href="{{route('customers.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Data Customer</a>
@endsection


@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Customer</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Term</th>
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
               ajax: "{{ route('customers.data') }}",
               columns :[
                     {data : 'nama_cust', name: 'nama_cust'},
                     {data : 'alamat', name : 'alamat'},
                     {data : 'telp', name : 'telp'},
                     {data : 'term', name : 'term'},
                     {data: 'action', name : 'action', orderable : false}
                  ]
            });
         });
    </script>
    
@endsection