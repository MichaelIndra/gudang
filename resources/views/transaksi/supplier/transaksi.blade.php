@extends('index')

@section('content')
<a href="{{route('transaksisupplier.create')}}" class="btn btn-info ml-3" id="create-new-user">Buat Transaksi</a>
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Nama Supplier</th>
                <th>Total Belanja</th>
                <th>Tanggal Transaksi</th>
                <th>Detail</th>>
            </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                
                <div class="modal-body">
                    <table id="detailsupp" class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Nama Barang</td>
                                <td>QTY</td>
                                <td>Harga Satuan</td>
                                <td>Total Harga</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    
                </div>
                
            </div>   
        </div>    
@endsection

@section('script')
    <script>
        function formatRupiah(angka){
            var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
		}


         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: "{{ route('transaksisupplier.data') }}",
               columns :[
                     {data : 'id_trans_supp', name: 'id_trans_supp'},
                     {data : 'nama_supp', name : 'nama_supp'},
                     {data : 'total_harga', name : 'total_harga', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     {data: 'created_at', name : 'created_at'},
                     {data: 'detail', name : 'detail', orderable : false},
                     
                  ],
                 columnDefs : [
                    {targets : [2], className : 'dt-right'    },
                ]  
            });
         });

         function show(id){
            $('#detail').modal('show');
            $('#myModalLabel').text(id);
            $.ajax({
                url : "{{ route('transaksisupplier.detail') }}",
                method : 'GET',
                data : {
                    id : id,
                    _token : "{{ csrf_token() }}"
                },
                success: function(response){
                console.log(response);
                   $('#detailsupp tbody > tr').remove(); 
                   var obj = JSON.parse(JSON.stringify(response));
                   var trhtml = '';
                   $.each(obj['data'], function(i, item){
                       trhtml += '<tr><td>'+item.nama_brg+'</td><td>'+item.qty+'</td><td> <div align="right">'+formatRupiah(item.harga_satuan)+'</div></td><td><div align="right">'+formatRupiah(item.harga_total)+'</div></td></tr>'
                   });
                   $('#detailsupp tbody').append(trhtml);
                    
                }
            });
                
        }
    </script>

@endsection