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

                @if (empty($hargacust->id_brg))
                    <div class="form-group">
                        <label for="nama_supp" class="control-label col-md-3">Nama Supplier</label>
                        <div class="col-md-8">
                            <select name="supp" id="supp" class="form-control input-lg dynamic" data-dependent="brg">
                                <option value="">Pilih Supplier</option>
                                @foreach($supp_list as $supp)
                                    <option value="{{$supp->id_supp}}">{{$supp->nama_supp}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_brg" class="control-label col-md-3">Nama Barang</label>
                        <div class="col-md-8">
                            <select name="id_brg" id="brg" class="form-control input-lg">
                                <option value="">Pilih Barang</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_supp" class="control-label col-md-3">Nama Customer</label>
                        <div class="col-md-8">
                            <select name="id_cust" id="id_cust" class="form-control input-lg dynamic">
                                <option value="">Pilih Customer</option>
                                @foreach($cust_list as $cust)
                                    <option value="{{$cust->id_cust}}">{{$cust->nama_cust}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                {!! Form::hidden('id_cust', $hargacust->id_cust) !!}
                <div class="form-group">
                        <label for="nama_supp" class="control-label col-md-3">Nama Supplier</label>
                        <div class="col-md-8">
                            {!!$hargacust->nama_supp!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_brg" class="control-label col-md-3">Nama Barang</label>
                        <div class="col-md-8">
                        {!!$hargacust->nama_brg!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_brg" class="control-label col-md-3">Nama Customer</label>
                        <div class="col-md-8">
                        {!!$hargacust->nama_cust!!}
                        </div>
                    </div>    
                @endif    

                <div class="form-group">
                    <label for="hargacust" class="control-label col-md-3">Harga Customer</label>
                    <div class="col-md-8">
                        {!! Form::number('harga', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="komisi" class="control-label col-md-3">Komisi</label>
                    <div class="col-md-8">
                        {!! Form::number('komisi', null, ['class'=>'form-control']) !!}
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
                    <button type="submit" class="btn btn-primary">{{ !empty($hargacust->id_brg) ? "Update" : "Save" }}</button>
                    <a href="{{route('hargacusts.index')}}" class="btn btn-default">Cancel</a>
                </div> 
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        $(document).ready(function(){
            $('.dynamic').change(function(){
                if($(this).val() != ''){
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url : "{{route('hargacusts.fetch')}}",
                        method : "POST",
                        data: {select : select, value: value, _token:_token, dependent:dependent},
                        success:function(result){
                            $('#'+dependent).html(result);
                        }
                    });
                }
            });

            $('#supp').change(function(){
                $('#brg').val('');
            });
        });
    </script>
@endsection