@extends('index')

@section('head')

@endsection

@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Supplier</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Adjust</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="adjust" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                
                {!! Form::open(['route'=>'stoks.adjust', 'class'=>'well form-horizontal']) !!}
                    
                    {{csrf_field()}}
                    <div class="modal-body">
                        <h4 id="barang"></h4>
                        <input type="hidden" name="myidbrg" id="myidbrg" value=""/>
                        <div class="form-group">
                            <label for="bayar">QTY</label>
                            <input type="number" class="form-control" name="qty" id="qty">
                        </div>    
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Change</button>
                    </div>
                    {!! Form::close() !!}        
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
               ajax: "{{ route('stoks.data') }}",
               columns :[
                     {data : 'nama_supp', name: 'nama_supp'},
                     {data : 'nama_brg', name : 'nama_brg'},
                     {data : 'stok', name : 'stok'},
                     {data: 'adjust', name : 'adjust', orderable : false}
                  ]
            });
         });

         $('#adjust').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget)
            var idbrg = button.data('myidbrg')
            var supp = button.data('mysupp')
            var brg = button.data('mybrg')
            var modal = $(this)

            modal.find('.modal-body #myidbrg').val(idbrg)
            modal.find('.modal-body #barang').text(brg)
            modal.find('.modal-header #myModalLabel').text(supp)
         });
    </script>
    
@endsection