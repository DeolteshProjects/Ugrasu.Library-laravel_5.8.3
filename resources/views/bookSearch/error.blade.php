@extends('layouts.app')

@section('content')
    <div class="card-body">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <p><h3 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Ошибка!</h3> Произошла ошибка при работе с сервером библиотеки.</p>
            <p class="text-danger">Сообщение ошибки: <b>{{ $error_code }} </b> {{ $error_text }}</p>
        </div>
    </div>
@endsection