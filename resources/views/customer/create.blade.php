@extends('index')

@section('content')
    <div class ="panel panel-default">
        {!! Form::open(['route'=>'customers.store', 'class'=>'well form-horizontal']) !!}
            @include('customer.form')
        {!! Form::close() !!}
    </div>
@endsection