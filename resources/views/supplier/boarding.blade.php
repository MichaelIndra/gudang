@extends('index')

@section('head')
<a href="{{route('suppliers.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Data Supplier</a>
@endsection

@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Supplier</th>
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
               ajax: "{{ route('suppliers.data') }}",
               columns :[
                     {data : 'nama_supp', name: 'nama_supp'},
                     {data : 'alamat', name : 'alamat'},
                     {data : 'telp', name : 'telp'},
                     {data: 'action', name : 'action', orderable : false}
                  ]
            });
         });
    </script>
    
@endsection