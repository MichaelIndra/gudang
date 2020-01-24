@extends('index')

@section('content')
    <div class ="panel panel-default">
        {!! Form::open(['route'=>'sales.store', 'class'=>'well form-horizontal']) !!}
            @include('sales.form')
        {!! Form::close() !!}
    </div>
@endsection