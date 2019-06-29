@extends('layouts.CompilerApp')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            @if(!Session::has('LibraryReportDiscLocal'))
                @if ($CountLibraryReport > 0)
                <button href="javascript:void(0)" data-toggle="modal"
                        data-target="#ModalCreateLibraryReportFormCenter"
                        class="col-md-12 btn btn-info btn-lg text-white text-center">Создать новую библиографическую справку
                </button>
                @endif
            @else
                <button href="javascript:void(0)"
                        class="col-md-12 btn btn-lg btn-warning text-white text-center" disabled="true">В данный момент создается
                    новая библиографическая справка
                </button>
            @endif
            </div>
        </div>

        @if(count($LibraryReport) > 0)
            <div class="card col-md-12">
                <!-- .left-right-aside-column-->
                <div class="card-title">
                    <h3 class="card-title">Составленные библиографические справки</h3>
                </div>
                <div class="table col-md-12 col-sm-12">
                    <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="8">
                        <thead>
                        <tr class="row text-left">
                            <th class="">Год</th>
                            <th class="col-md-1">Форма</th>
                            <th class="col-md-3">Направление</th>
                            <th class="col-md-3">Дисциплина</th>
                            <th class="col-md-1 text-center">Состояние</th>
                            <th class="col-md-2">Составленна <p></p> Обновлена</th>
                            <td class="col-md-1">Действия</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($LibraryReport as $value)
                            <tr class="row text-left">
                                <td class="">{{ $value->yeared }}</td>
                                <td class="col-md-1">{{ $value->forma }}</td>
                                <td class="col-md-3">{{ $value->speciality }}</td>
                                <td class="col-md-3">{{ $value->discipline }}</td>
                                <td class="col-md-1 text-center">
                                    @if($value->status == 0)
                                        <span class="label label-light-warning">Новая</span>
                                    @elseif($value->status == 2)
                                        <span class="label label-light-primary">Исправлена</span>
                                    @elseif($value->status == 8)
                                        <span class="label label-light-danger">Отклонена библиотекой</span>
                                    @elseif($value->status == 10)
                                        <span class="label label-light-success">Принята библиотекой</span>
                                    @endif
                                </td>
                                <td class="col-md-2">{{ $value->createdate }}<p>{{ $value->updatedate }}</p></td>
                                <td class="col-md-1">
                                    <button type="button" class="btn btn-outline-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Действия
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="alert-info">
                                            <a class="dropdown-item btn btn-outline-info" href="{{ route('Compiler.show') }}?year={{ $value->yeared }}&speciality={{ $value->speciality }}&discipline={{ $value->discipline }}&compiler={{ Session::get('Authenticate.name') }}&createdate={{ $value->createdate }}&forma={{ $value->forma }}"><i class="fa fa-eye"></i> Открыть</a>
                                        </div>
                                        @if (($value->status) == 8)
                                        <div class="alert-warning">
                                            <a class="dropdown-item btn-outline-warning"
                                               href="{{ route('Compiler.edit',['year' => $value->yeared, 'specialitycode' => $value->specialitycode, 'disciplinecode' => $value->disciplinecode, 'forma' => $value->forma])}}" >
                                                <i class="fa fa-pencil"></i> Редактировать</a>
                                        </div>
                                        @endif
                                        @if (($value->status) == 10)
                                            <button class="dropdown-item btn-outline-primary" onclick="printOnlyOneDisc('{{ $value->specialitycode }}', '{{ $value->yeared }}', '{{ $value->disciplinecode }}', '{{ $value->forma }}')"><i class="fa fa-file-word-o"></i> Скачать</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>

                            <td colspan="9">
                                <div class="text-right">
                                    <ul class="pagination"></ul>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @else
            <div class="col-md-12 alert alert-info text-center">
                <p>На данный момент у вас отсутствуют составленные
                библиографические справки</p>
                <p>
                <button href="javascript:void(0)" data-toggle="modal"
                        data-target="#ModalCreateLibraryReportFormCenter"
                        class="col-md-12 btn btn-info btn-lg text-white text-center">Нажмите чтобы создать новую библиографическую справку
                </button>
                </p>
            </div>
        @endif
    </div>

    <script>


    </script>

@endsection
