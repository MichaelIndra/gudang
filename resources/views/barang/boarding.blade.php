@extends('index')

@section('head')
    <a href="{{route('barangs.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Data Barang</a>    
@endsection

@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Supplier</th>
                <th>Nama Barang</th>
                <th>Keterangan</th>
                
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
               ajax: "{{ route('barangs.data') }}",
               columns :[
                     {data : 'nama_supp', name: 'nama_supp'},
                     {data : 'nama_brg', name : 'nama_brg'},
                     {data : 'keterangan', name : 'keterangan'},
                     
                     {data: 'action', name : 'action', orderable : false}
                  ]
            });
         });
    </script>
    
@endsection