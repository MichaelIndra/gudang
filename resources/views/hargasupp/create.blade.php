@extends('index')

@section('content')
    <div class ="panel panel-default">
        {!! Form::open(['route'=>'hargasupps.store', 'class'=>'well form-horizontal']) !!}
            @include('hargasupp.form')
        {!! Form::close() !!}
    </div>
@endsection