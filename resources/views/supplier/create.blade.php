@extends('index')

@section('content')
    <div class ="panel panel-default">
        {!! Form::open(['route'=>'suppliers.store', 'class'=>'well form-horizontal']) !!}
            @include('supplier.form')
        {!! Form::close() !!}
    </div>
@endsection