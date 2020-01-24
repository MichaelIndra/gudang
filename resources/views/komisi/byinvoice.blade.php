@extends('index')

@section('head')
<a href="{{route('komisis.index')}}" class="btn btn-info ml-3" id="create-new-user">Kembali</a>
@endsection

@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Sales</th>
                <th>No Invoice</th>
                <th>Komisi</th>
                <th>Detail</th>
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
                    <table id="detkomisi" class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Nama Barang</td>
                                <td>Komisi</td>
                                <td>Status</td>
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

    </div>
@endsection

@section('script')
    <script>
         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: "{{ route('komisis.data') }}",
               columns :[
                     {data : 'nama_sales', name: 'nama_sales'},
                     {data : 'id_trans_cust', name : 'id_trans_cust'},
                     {data : 'komisi', name : 'komisi', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     {data : 'detail', name : 'detail', orderable : false},
                     
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
                url : "{{ route('komisi.getkomisi') }}",
                method : 'GET',
                data : {
                    id : id,
                    _token : "{{ csrf_token() }}"
                },
                success: function(response){
                console.log(response);
                   $('#detkomisi tbody > tr').remove(); 
                   var obj = JSON.parse(JSON.stringify(response));
                   var trhtml = '';
                   $.each(obj['data'], function(i, item){
                       trhtml += '<tr><td>'+item.nama_brg+'</td><td>'+item.komisi+'</td><td>'+item.action+'</td></tr>'
                   });
                   $('#detkomisi tbody').append(trhtml);
                    
                }
            });
                
        }
    </script>
    
@endsection