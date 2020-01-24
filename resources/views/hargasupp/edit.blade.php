@extends('index')

@section('content')
    <div class ="panel panel-default">

        {!! Form::model($hargasupp, [
            'method' => 'PATCH',
            'route' => ['hargasupps.update', $hargasupp->id_brg],
            'class'=>'well form-horizontal'
        ]) !!}
        @include('hargasupp.form')
        {!! Form::close() !!} 
    </div>
@endsection