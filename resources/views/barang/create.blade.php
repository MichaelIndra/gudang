@extends('index')

@section('content')
    <div class ="panel panel-default">
        {!! Form::open(['route'=>'barangs.store', 'class'=>'well form-horizontal']) !!}
            @include('barang.form')
        {!! Form::close() !!}
    </div>
@endsection