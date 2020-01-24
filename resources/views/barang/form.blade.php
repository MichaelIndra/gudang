<div class="panel-body">
    <div class="well form-horizontal">
        <div class="row">
            <div class="col-md-8">
                @if (count($errors)) 
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="id_brg" class="control-label col-md-3">ID Barang</label>
                    <div class="col-md-8 inputGroupContainer">
                        
                            @if (empty($barang->id_brg))
                                {!! Form::text('id_brg', null, ['id'=>'id_brg', 'class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
                            @else
                                {!! Form::text('id_brg', null, ['class'=>'form-control', 'disabled' => 'disabled', 'style' =>'text-transform: uppercase;']) !!}
                            @endif
                            <span id="check-id-brg"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_supp" class="control-label col-md-3">Nama Supplier</label>
                    <div class="col-md-8">
                    {!! Form::select('id_supp', $supp, null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_brg" class="control-label col-md-3">Nama Barang</label>
                    <div class="col-md-8">
                        {!! Form::text('nama_brg', null, ['class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="keterangan" class="control-label col-md-3">Keterangan</label>
                    <div class="col-md-8">
                        {!! Form::text('keterangan', null, ['class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
                    </div>
                </div>

                              
            </div>
        </div>
    </div>
</div>

<div class ="panel-footer">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" class="btn btn-primary">{{ !empty($barang->id_barang) ? "Update" : "Save" }}</button>
                    <a href="{{route('barangs.index')}}" class="btn btn-default">Cancel</a>
                </div> 
            </div>
        </div>
    </div>
</div>
@section('script')
<script>

        $("#id_brg").blur(function(){
            var idbrg = $('#id_brg').val();
            // alert (idbrg);
            $.ajax({
                method: "GET",
                url : "{{ route('barangs.cekid') }}",
                data : {id_brg : idbrg},
                success: function(data){
                    $('#check-id-brg').text(data);
                }
            });
        });

    
</script>

@endsection