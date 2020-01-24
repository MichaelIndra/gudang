@extends('index')

@section('content')
    <div class ="panel panel-default">
        {!! Form::open(['route'=>'hargacusts.store', 'class'=>'well form-horizontal']) !!}
            @include('hargacust.form')
        {!! Form::close() !!}
    </div>
@endsection