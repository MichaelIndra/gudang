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
                    <label for="id_cust" class="control-label col-md-3">ID Customer</label>
                    <div class="col-md-8 inputGroupContainer">
                        
                            @if (empty($cust->id_cust))
                                {!! Form::text('id_cust', null, ['id'=>'id_cust','class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
                            @else
                                {!! Form::text('id_cust', null, ['class'=>'form-control', 'disabled' => 'disabled', 'style' =>'text-transform: uppercase;']) !!}
                            @endif
                            <span id="check-id-cust"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_customer" class="control-label col-md-3">Nama Customer</label>
                    <div class="col-md-8">
                        {!! Form::text('nama_cust', null, ['class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
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
                <div class="form-group">
                    <label for="term" class="control-label col-md-3">Term</label>
                    <div class="col-md-8">
                        {!! Form::number('term', null, ['class'=>'form-control']) !!}
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
                    <button type="submit" class="btn btn-primary">{{ !empty($cust->id_cust) ? "Update" : "Save" }}</button>
                    <a href="{{route('customers.index')}}" class="btn btn-default">Cancel</a>
                </div> 
            </div>
        </div>
    </div>
</div>


@section('script')
<script>

        $("#id_cust").blur(function(){
            var id_cust = $('#id_cust').val();
            // alert (idbrg);
            $.ajax({
                method: "GET",
                url : "{{ route('customers.cekid') }}",
                data : {id_cust : id_cust},
                success: function(data){
                    $('#check-id-cust').text(data);
                }
            });
        });

    
</script>

@endsection