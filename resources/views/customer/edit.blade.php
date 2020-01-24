@extends('index')

@section('content')
    <div class ="panel panel-default">

        {!! Form::model($cust, [
            'method' => 'PATCH',
            'route' => ['customers.update', $cust->id_cust],
            'class'=>'well form-horizontal'
        ]) !!}
        @include('customer.form')
        {!! Form::close() !!} 
    </div>
@endsection