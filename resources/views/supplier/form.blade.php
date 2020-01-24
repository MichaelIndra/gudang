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
                    <label for="id_supp" class="control-label col-md-3">ID Supplier</label>
                    <div class="col-md-8 inputGroupContainer">
                        
                            @if (empty($supplier->id_supp))
                                {!! Form::text('id_supp', null, ['id'=>'id_supp', 'class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
                            @else
                                {!! Form::text('id_supp', null, ['class'=>'form-control', 'disabled' => 'disabled', 'style' =>'text-transform: uppercase;']) !!}
                            @endif
                            <span id="check-id-supp"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_supp" class="control-label col-md-3">Nama Supplier</label>
                    <div class="col-md-8">
                        {!! Form::text('nama_supp', null, ['class'=>'form-control', 'style' =>'text-transform: uppercase;']) !!}
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
                    <button type="submit" class="btn btn-primary">{{ !empty($supplier->id_supp) ? "Update" : "Save" }}</button>
                    <a href="{{route('suppliers.index')}}" class="btn btn-default">Cancel</a>
                </div> 
            </div>
        </div>
    </div>
</div>

@section('script')
<script>

        $("#id_supp").blur(function(){
            var id_supp = $('#id_supp').val();
            // alert (idbrg);
            $.ajax({
                method: "GET",
                url : "{{ route('suppliers.cekid') }}",
                data : {id_supp : id_supp},
                success: function(data){
                    $('#check-id-supp').text(data);
                }
            });
        });

    
</script>

@endsection