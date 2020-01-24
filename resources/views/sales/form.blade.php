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
                    <label for="id_sales" class="control-label col-md-3">ID Sales</label>
                    <div class="col-md-8 inputGroupContainer">
                        
                            @if (empty($sales->id_sales))
                                {!! Form::text('id_sales', null, ['id'=>'id_sales', 'class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
                            @else
                                {!! Form::text('id_sales', null, ['class'=>'form-control', 'disabled' => 'disabled', 'style' =>'text-transform: uppercase;']) !!}
                            @endif
                            <span id="check-id-sales"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_sales" class="control-label col-md-3">Nama Sales</label>
                    <div class="col-md-8">
                        {!! Form::text('nama_sales', null, ['class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat" class="control-label col-md-3">Alamat</label>
                    <div class="col-md-8">
                        {!! Form::text('alamat', null, ['class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="telp" class="control-label col-md-3">Telepon</label>
                    <div class="col-md-8">
                        {!! Form::text('telp', null, ['class'=>'form-control']) !!}
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
                    <button type="submit" class="btn btn-primary">{{ !empty($sales->id_sales) ? "Update" : "Save" }}</button>
                    <a href="{{route('sales.index')}}" class="btn btn-default">Cancel</a>
                </div> 
            </div>
        </div>
    </div>
</div>

@section('script')
<script>

        $("#id_sales").blur(function(){
            var id_sales = $('#id_sales').val();
            // alert (idbrg);
            $.ajax({
                method: "GET",
                url : "{{ route('sales.cekid') }}",
                data : {id_sales : id_sales},
                success: function(data){
                    $('#check-id-sales').text(data);
                }
            });
        });

    
</script>

@endsection