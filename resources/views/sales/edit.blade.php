@extends('index')

@section('content')
    <div class ="panel panel-default">

        {!! Form::model($sales, [
            'method' => 'PATCH',
            'route' => ['sales.update', $sales->id_sales],
            'class'=>'well form-horizontal'
        ]) !!}
        @include('sales.form')
        {!! Form::close() !!} 
    </div>
@endsection