@extends('index')

@section('content')
    <div class ="panel panel-default">

        {!! Form::model($supplier, [
            'method' => 'PATCH',
            'route' => ['suppliers.update', $supplier->id_supp],
            'class'=>'well form-horizontal'
        ]) !!}
        @include('supplier.form')
        {!! Form::close() !!} 
    </div>
@endsection