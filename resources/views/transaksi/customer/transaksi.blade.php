@extends('index')

@section('content')
<a href="{{route('transaksicustomer.create')}}" class="btn btn-info ml-3" id="create-new-user">Buat Transaksi</a>
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>No Invoice</th>
                <th>Nama Customer</th>
                <th>Total Belanja</th>
                <th>Total Bayar</th>
                <th>Status Bayar</th>
                <th>Metode Bayar</th>
                <th>Status Transaksi</th>
                <th>Nama Sales</th>
                <th>Tanggal Transaksi</th>
                <th>Print</th>
                <th>Bayar</th>
                <th>CANCEL</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="bayar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <form action="{{route('transaksicustomer.update', 'aws')}}" method="post">
                    {{method_field('patch')}}
                    {{csrf_field()}}
                    <div class="modal-body">
                        
                        <input type="hidden" name="myidtrans" id="myidtrans" value=""/>
                        <input type="text" name="bayar" id="bayar" value="" disabled/>
                        <div class="form-group">
                            <label for="bayar">Bayar</label>
                            <input type="number" class="form-control" name="bayar" id="bayar">
                        </div>    
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Change</button>
                    </div>
                </form>        
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
               ajax: "{{ route('transaksicustomers.data') }}",
               columns :[
                     {data : 'id_trans_cust', name: 'id_trans_cust'},
                     {data : 'nama_cust', name : 'nama_cust'},
                     {data : 'total_harga', name : 'total_harga', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     {data : 'bayar', name : 'bayar', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     {data: 'status', name : 'status'},
                     {data: 'metode', name : 'metode'},
                     {data: 'statusinv', name : 'statusinv'},
                     {data: 'nama_sales', name : 'nama_sales'},
                     {data: 'created_at', name : 'created_at'},
                     {data: 'print', name : 'print', orderable : false},
                     {data: 'bayarbut', name : 'bayarbut', orderable : false},
                     {data: 'cancel', name : 'cancel', orderable : false},
                  ],
                 columnDefs : [
                    {targets : [2,3], className : 'dt-right'    },
                ]  
            });
         });

         $('#bayar').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget)
            var idtrans = button.data('myidtrans')
            var nama = button.data('mycustomer')
            var byr = button.data('bayar')
            var modal = $(this)

            modal.find('.modal-body #myidtrans').val(idtrans)
            modal.find('.modal-header #myModalLabel').text(nama)
            modal.find('.modal-body #bayar').val(byr)
         });
    </script>

@endsection