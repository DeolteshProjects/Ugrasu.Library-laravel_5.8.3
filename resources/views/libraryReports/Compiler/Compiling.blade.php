@extends('layouts.CompilerApp')
@section('content')
    <div class="col-lg-12">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <br id="CreatingTable" class="table">
                    @if(Session::has('LibraryReportDiscLocal.Edit'))
                        <div class="alert alert-warning text-center">
                            <h3><b><b class="text-warning"></b>Редактирование</b></h3>
                        </div>
                    @endif
                        @if((Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature')) AND (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature')) )
                            @php
                            $full_complect = true;
                            @endphp
                        @else
                            <div class="alert alert-warning text-center">
                                <p>Для отправки составляемой библиографической справки добавьте хотябы одну <b><b class="text-danger">
                            @if(!Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature'))
                                основную
                            @endif
                                @if((!Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature')) AND (!Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature')))
                                    и
                                @endif
                                @if(!Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature'))
                                дополнительную
                            @endif
                            </b></b>литературу:</p>
                                <button class="btn btn-outline-danger" data-toggle="modal" data-target="#ModalBookSearchForm">Добавить литературу</button>
                             @php
                                $full_complect = false;
                             @endphp
                        </div>
                        @endif
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
                                <td colspan="8" width="100%"><h6><b>СПРАВКА об обеспеченности
                                            учебно-методической
                                            документацией программы направления
                                            подготовки {{ $LibraryReport['SpecialityCode'] }} {{ $LibraryReport['Speciality'] }}
                                            , {{ $LibraryReport['Yeared'] }} год набора </b></h6></td>
                            </tr>
                            @if($AmountOfLiterature == 0)
                                <!-- Надо вырезать
                                <tr class="alert alert-danger">
                                    <td colspan="7">
                                        <p>
                                            <b><h3 class="text text-danger">На данных момент вы не добавили
                                                    литературу в библиографическую справку</h3></b>
                                        </p>
                                        <p>
                                            <button
                                               class="btn btn-lg btn-outline-danger" data-toggle="modal" data-target="#ModalBookSearchForm">Добавить литературу</button>
                                        </p>
                                    <td>
                                </tr>
                                -->
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        @else
                            <tr>
                                <td width="5%"><p>№</p>
                                    <p>П/П</p></td>
                                <td>Наименование дисциплины</td>
                                <td colspan="2">Наименование печатных и (или) электронных учебных
                                    изданий,
                                    методические издания, периодические издания по всем входящим
                                    в реализуемую образовательную программу учебным предметам,
                                    курсам, дисциплинам (модулям) в соответствии с рабочими программами
                                    дисциплин, модулей, практик
                                </td>
                                <td>Количество экземпляров</td>
                                <td>Cтудентов учебной литературой (экземпляров на одного студента)</td>
                                <td>Действия</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center align-middle"
                                    rowspan="{{ $AmountOfLiterature }}"> 1
                                </td>
                                <td class="text-center align-middle"
                                    rowspan="{{ $AmountOfLiterature }}">{{ $LibraryReport['Discipline'] }}</td>
                                @if ( $AmountOftBookLiterature > 0)
                                    <td class="text-center align-middle"
                                        rowspan="{{ $AmountOftBookLiterature }}">Печатные
                                        учебные издания
                                    </td>
                                    <td>1. {{ $tBook['0']['Book'] }}
                                    @if($tBook['0']['Memory'])
                                        <i class='text-primary'>{Дополнительная}</i>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">{{ $tBook['0']['NumberOfCopies'] }}
                                        из
                                        {{ $tBook['0']['Max'] }}
                                    <td class="text-center align-middle"><i
                                                class="text-danger">1</i></td>
                                    <td сlass="row">
                                        <button class="col-md-12 btn btn-xs btn-outline-primary"
                                                data-toggle="tooltip" onclick="deleteBookFromLibraryReport('0','t')"
                                                title="Удалить из справки">Удалить из справки
                                        </button>
                                    </td>
                            </tr>
                            @endif
                            @if ($AmountOftBookLiterature > 1)
                                @for ($i = 1; $i < $AmountOftBookLiterature; $i++)
                                    <tr>
                                        <td>{{ $i+1 }}. {{ $tBook[$i]['Book'] }}
                                            @if($tBook[$i]['Memory'])
                                                <i class='text-primary'>{Дополнительная}</i>
                                                @endif
                                            </td>
                                        <td class="text-center align-middle">{{ $tBook[$i]['NumberOfCopies'] }}
                                            из {{ $tBook[$i]['Max'] }}</td>
                                        <td class="text-center align-middle"><i class="text-danger">1</i>
                                        </td>
                                        <td сlass="row">
                                            <button class="col-md-12 btn btn-xs btn-outline-primary"
                                                    data-toggle="tooltip"
                                                    onclick="deleteBookFromLibraryReport('{{ $i }}', 't')"
                                                    title="Удалить из справки">Удалить из справки
                                            </button>
                                        </td>
                                    </tr>
                                @endfor
                            @endif
                            @if ($AmountOfeBookLiterature > 0)
                                <td class="text-center align-middle"
                                    rowspan="{{ $AmountOfeBookLiterature }}">Электронные
                                    учебные издания, имеющиеся в электронном каталоге
                                    электронно-библиотечной системы
                                </td>
                                <td>1. {{ $eBook[0]['Book'] }}
                                    @if($eBook['0']['Memory'])
                                        <i class='text-primary'>{Дополнительная}</i>
                                    @endif</td>
                                <td class="text-center align-middle">{{ $eBook[0]['NumberOfCopies'] }}
                                    из {{ $eBook[0]['Max'] }}</td>
                                <td class="text-center align-middle"><i class="text-danger">1</i>
                                </td>
                                <td сlass="row">
                                    <button class="col-md-12 btn btn-xs btn-outline-primary"
                                            data-toggle="tooltip" onclick="deleteBookFromLibraryReport(0,'e')"
                                            title="Удалить из справки">Удалить из справки
                                    </button>
                                </td>
                                </tr>
                            @endif
                            @if ($AmountOfeBookLiterature > 1)
                                @for ($i = 1; $i < $AmountOfeBookLiterature; $i++)
                                    <tr>
                                        <td>{{ $i+1 }}
                                            . {{ $eBook[$i]['Book'] }}
                                            @if($eBook[$i]['Memory'])
                                                <i class='text-primary'>{Дополнительная}</i>
                                            @endif</td>
                                        <td class="text-center align-middle">{{ $eBook[$i]['NumberOfCopies'] }}
                                            из {{ $eBook[$i]['Max'] }}</td>
                                        <td class="text-center align-middle"><i class="text-danger">1</i>
                                        </td>
                                        <td сlass="row">
                                            <button class="col-md-12 btn btn-xs btn-outline-primary"
                                                    data-toggle="tooltip"
                                                    onclick="deleteBookFromLibraryReport( '{{ $i }}', 'e')"
                                                    title="Удалить из справки">Удалить из справки
                                            </button>
                                        </td>
                                    </tr>
                                @endfor
                            @endif
                            </tbody>
                            </table>
                        @if((isset($Activity)) AND ($Activity != NULL))
                            <div id="activity">
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <div class="card-header text-center">
                                                <span class="card-title">Активность справки</span>
                                            </div>
                                        </tr>
                                        <tr class="row">
                                            <td class="col-md-2">Дата</td>
                                            <td class="col-md-3">Оператор</td>
                                            <td class="col-md-1">Активность</td>
                                            <td class="col-md-6">Комментарий</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Activity as $Active)
                                            <tr class="row
                                    @if($Active['ActivityStatus'] == 10)
                                                    label-light-success
@elseif($Active['ActivityStatus'] == 8)
                                                    label-light-danger
@elseif($Active['ActivityStatus'] == 0)
                                                    label-light-warning
@endif
                                                    ">
                                                <td class="col-md-2">{{ $Active['ActivityDate'] }}</td>
                                                <td class="col-md-3">{{ $Active['ActivityPerson'] }}</td>
                                                <td class="col-md-1">
                                                    <b>
                                                        @if($Active['ActivityStatus'] == 10)
                                                            <b class="text-success">Принятие</b>
                                                        @elseif($Active['ActivityStatus'] == 8)
                                                            <b class="text-danger">Отклонение</b>
                                                        @elseif($Active['ActivityStatus'] == 0)
                                                            <b class="text-warning">Создание</b>
                                                        @endif
                                                    </b>
                                                </td>
                                                <td class="col-md-6">
                                                    @if(!empty($Active['ActivityComment']))
                                                        {{ $Active['ActivityComment'] }}
                                                    @else
                                                        Отсутствует
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Действия
                                    </button>
                                    <div class="dropdown-menu">
                                        @if($full_complect)
                                        <div class="alert-success">
                                            <button class="dropdown-item btn-outline-success"
                                                    onclick="FinishAndSaveLibraryReport()">Отправить в
                                                библиотеку
                                            </button>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        @endif
                                        <div class="alert-danger">
                                            <button class="dropdown-item btn-outline-danger"
                                                    onclick="CleanCreatingLibraryReport()">Очистить справку
                                            </button>
                                            <button class="dropdown-item btn-outline-red"
                                                    onclick="DeleteCreatingLibraryReport()">Отменить составление
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12" id="loader" hidden>
                        <div class="form-group row">
                            <div class="col-md-12 text-center text-info">
                                <div class="loader">
                                    <div class="loader__figure"></div>
                                    <p class="loader__label">Выполнение операции</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        //Функция вывода уведомлений
        function Notification(title, description, status) {
            var bg;
            switch (status) {
                case "success":
                    bg = "#06d79c";
                    break;
                case "info":
                    bg = "#398bf7";
                    break;
                case "warning":
                    bg = "#ffb22b";
                    break;
                case "error":
                    bg = "#ef5350";
                    break;
            }
            $.toast({
                heading: '' + title + '', //Заголовок
                text: '' + description + '', //Описание
                position: 'top-right',  //Расположение
                bgColor: bg,    //Фон
                textColor: 'white', //Текст
                loaderBg: '#ff6849', //Фон лоадера
                icon: status,   //Иконка
                //hideAfter: 0,    //Таймер
                stack: 1,   //Максимальное количество
                showHideTransition: 'fade',   //Эффект
                allowToastClose: false, //Кнопка закрытия
            });
        }


        @if($full_complect)

        //Завершение составления библиографической справки и сохранение ее в БД
        function FinishAndSaveLibraryReport() {
            document.getElementById("loader").hidden = false;
            //Запрос на сохранение библиографической справки в БД
            $.ajax({
                url: '{{ route( 'Compiler.save') }}',
                type: 'POST',
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    Notification('Библиографическая справка успешно создана', 'Вы можете наблюдать за ее состоянием на <a href="{{ route('home') }}">главной странице</a>', 'success');
                    document.getElementById("loader").hidden = true;
                    timer = setTimeout(function () {
                        DeleteCreatingLibraryReport();
                    }, 500);
                },
                error: function () {
                    Notification('Произошла ошибка при сохранении библиографической справки', '', 'error');
                }
            });
            document.getElementById("loader").hidden = true;
        }

        @endif

        function CleanCreatingLibraryReport() {
            $.ajax({
                url: '{{ route( 'Compiler.clean') }}',
                type: 'POST',
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    Notification('Библиографическая справка успешно очиценна', '', 'success');
                    document.getElementById("loader").hidden = true;
                    timer = setTimeout(function () {
                        window.location.replace('{{ route('home') }}');
                    }, 500);
                },
                error: function () {
                    Notification('Произошла ошибка очистке справки от литературы', '', 'error');
                }
            })
        }

        function deleteBookFromLibraryReport(id, view) {
            $.ajax({
                url: '{{ route( 'Compiler.deleteBook') }}',
                type: 'POST',
                data: {
                    Id: id,
                    View: view
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                async: true,
                success: function (data) {
                    Notification('Литература удалена из составляемой библиографической справки', '', 'success');
                    document.getElementById("loader").hidden = true;
                    timer = setTimeout(function(){ window.location.reload(); }, 100);
                },
                error: function () {
                    Notification('Произошла ошибка удалении литературы из составляемой справки', '', 'error');
                }
            })
        }

    </script>
@endsection