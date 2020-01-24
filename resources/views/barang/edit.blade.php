@extends('index')

@section('content')
    <div class ="panel panel-default">

        {!! Form::model($barang, [
            'method' => 'PATCH',
            'route' => ['barangs.update', $barang->id_brg],
            'class'=>'well form-horizontal'
        ]) !!}
        @include('barang.form')
        {!! Form::close() !!} 
    </div>
@endsection