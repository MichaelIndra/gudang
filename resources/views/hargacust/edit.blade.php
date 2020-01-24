@extends('index')

@section('content')
    <div class ="panel panel-default">

        {!! Form::model($hargacust, [
            'method' => 'PATCH',
            'route' => ['hargacusts.update', $hargacust->id_brg],
            'class'=>'well form-horizontal'
        ]) !!}
        @include('hargacust.form')
        {!! Form::close() !!} 
    </div>
@endsection