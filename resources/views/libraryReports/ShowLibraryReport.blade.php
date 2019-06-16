@extends('layouts.app')
@section('content')
    <div class="col-lg-12">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="CreatingTable" class="table">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
                                <td colspan="8" width="100%">
                                    <div class="col-md-12 text-right">
                                        <div id="compiler_name" class="col-md-12">
                                            <h6>
                                                Составитель: <b class="left">{{ $LibraryReport['Compiler'] }}</b>
                                            </h6>
                                        </div>
                                        <div class="col-md-12">
                                            <h6>
                                                </br> Дата составления: <b>{{ $LibraryReport['CreateDate'] }}</b>
                                            </h6>
                                        </div>
                                        @if(!empty($LibraryReport['UpdateDate']))
                                        <div class="col-md-12">
                                            <h6>
                                                </br> Дата обновления: <b>{{ $LibraryReport['UpdateDate'] }}</b>
                                            </h6>
                                        </div>
                                        @endif
                                        <div class="col-md-12">
                                            <h6>
                                                </br> Состояние: <b>
                                                    @if($LibraryReport['Status'] == 0)
                                                        <span class="label label-light-warning">Новая</span>
                                                    @elseif($LibraryReport['Status'] == 2)
                                                        <span class="label label-light-primary">Исправлена</span>
                                                    @elseif($LibraryReport['Status'] == 8)
                                                        <span class="label label-light-danger">Отклонена библиотекой</span>
                                                    @elseif($LibraryReport['Status'] == 10)
                                                        <span class="label label-light-success">Принята библиотекой</span>
                                                    @else
                                                        <span class="label label-light-dark">Неизвестно</span>
                                                    @endif
                                                </b>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" width="100%"><h6><b>СПРАВКА об обеспеченности
                                            учебно-методической
                                            документацией программы направления
                                            подготовки {{ $LibraryReport['SpecialityCode'] }} {{ $LibraryReport['Speciality'] }}
                                            , {{ $LibraryReport['Yeared'] }} год набора </b></h6>
                                </td>
                            </tr>
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
                                    <td>
                                    <div class="col-md-12">1. {{ $tBook['0']['Book'] }}
                                        @if($tBook[0]['Memory'])
                                            <i class='text-primary'>{Дополнительная}</i>
                                        @endif
                                        </div>
                                        <!--
                                        <div class="col-md-12 alert alert-warning">
                                        <h5 class="text-warning"><i class="fa fa-warning"></i> Данная литература не подходит для составления БС</h5>
                                        </div>
                                        <div class="col-md-12 row">
                                            <div class="col-md-12 row">
                                                <div class="col-md-10">
                                                    <textarea class="form-control" id="textComment_t_0"></textarea>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-outline-warning" onclick='addCommentToLit('t','0', '(document.getElementById("textComment_"+"t"+"_"+"0").value)')>Добавить комментарий</buttons>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                        </td>
                                    <td class="text-center align-middle">{{ $tBook['0']['NumberOfCopies'] }}
                                        из {{ $tBook[0]['Max'] }}</td>
                                    <td class="text-center align-middle"><i
                                                class="text-danger">1</i></td>
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
                                    @if($eBook[0]['Memory'])
                                        <i class='text-primary'>{Дополнительная}</i>
                                    @endif</td>
                                <td class="text-center align-middle">{{ $eBook[0]['NumberOfCopies'] }}
                                    из {{ $eBook[0]['Max'] }}</td>
                                <td class="text-center align-middle"><i class="text-danger">1</i>
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
                                    </tr>
                                @endfor
                            @endif
                            </tbody>
                        </table>
                        @if($Activity != NULL)
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
                                        <td class="col-md-2">Активность</td>
                                        <td class="col-md-5">Комментарий</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($Activity as $Active)
                                    <tr class="row
                                    @if($Active['ActivityStatus'] == 10)
                                            label-light-success
                                    @elseif($Active['ActivityStatus'] == 8)
                                            label-light-danger
                                    @elseif($Active['ActivityStatus'] == 2)
                                            label-light-primary
                                    @elseif($Active['ActivityStatus'] == 0)
                                            label-light-warning
                                    @endif
                                            ">
                                        <td class="col-md-2">{{ $Active['ActivityDate'] }}</td>
                                        <td class="col-md-3">{{ $Active['ActivityPerson'] }}</td>
                                        <td class="col-md-2">
                                            <b>
                                            @if($Active['ActivityStatus'] == 10)
                                                <b class="text-success">Принятие</b>
                                                @elseif($Active['ActivityStatus'] == 8)
                                                <b class="text-danger">Отклонение</b>
                                                @elseif($Active['ActivityStatus'] == 2)
                                                <b class="text-primary"> Исправление</b>
                                                @elseif($Active['ActivityStatus'] == 0)
                                                <b class="text-warning">Создание</b>
                                            @endif
                                            </b>
                                        </td>
                                        <td class="col-md-5">
                                            @if(!empty($Active['ActivityComment']))
                                                {{ $Active['ActivityComment'] }}
                                                @else

                                                @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @if(((Session::get('Authenticate.position')) == 'none') AND ($LibraryReport['Status'] != 2) AND ($LibraryReport['Status'] != 0))
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-info dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    Действия
                                </button>
                                <div class="dropdown-menu">
                                    @if(($LibraryReport['Status'] == 8))
                                        <div class="alert-warning">
                                            <a class="dropdown-item btn-outline-warning"
                                               href="{{ route('Compiler.edit',['year' => $LibraryReport['Yeared'], 'specialitycode' =>$LibraryReport['SpecialityCode'], 'disciplinecode' => $LibraryReport['DisciplineCode']])}}" >
                                                <i class="fa fa-pencil"></i> Редактировать</a>
                                        </div>
                                    @endif
                                    @if($LibraryReport['Status'] == 10)
                                        <div class="alert-primary">
                                            <button class="dropdown-item btn-outline-primary" onclick="printOnlyOneDisc('{{ $LibraryReport['SpecialityCode'] }}', '{{ $LibraryReport['Yeared'] }}', '{{ $LibraryReport['DisciplineCode'] }}')"><i class="fa fa-file-word-o"></i> Скачать</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @if((Session::get('Authenticate.position')) == 'library')
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-info dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    Действия
                                </button>
                                <div class="dropdown-menu">
                                    @if($LibraryReport['Status'] != 10)
                                        @if(Session::get('Authenticate.position') == 'library')
                                            <div class="alert-success">
                                                <button class="dropdown-item btn-outline-success"
                                                        onclick="acceptLibraryReportDiscLibrary('{{ $LibraryReport['Yeared'] }}', '{{ $LibraryReport['SpecialityCode'] }}', '{{ $LibraryReport['DisciplineCode'] }}', '{{ $LibraryReport['Compiler'] }}', '{{ $LibraryReport['CreateDate'] }}', 10, '' )">
                                                    <i class="fa fa-check"></i> Принять
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                    @if(($LibraryReport['Status'] >= 0) AND ($LibraryReport['Status'] != 8))
                                        @if(Session::get('Authenticate.position') == 'library')
                                        <div class="alert-danger">
                                            <button class="dropdown-item btn-outline-danger" data-toggle="modal"
                                                    data-target="#refuseForm"><i class="fa fa-close"></i> Отклонить
                                            </button>
                                        </div>
                                        @endif
                                    @endif
                                    @if($LibraryReport['Status'] == 10)
                                        <div class="alert-primary">
                                            <button class="dropdown-item btn-outline-primary" onclick="printOnlyOneDisc('{{ $LibraryReport['SpecialityCode'] }}', '{{ $LibraryReport['Yeared'] }}', '{{ $LibraryReport['DisciplineCode'] }}')"><i class="fa fa-file-word-o"></i> Скачать</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if(Session::get('Authenticate.position')  == 'library')
                    <div class="card">
                        <div class="card-body col-sm-5">
                            <!-- sample modal content -->
                            <div id="refuseForm" class="modal fade" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Отклонение составленной библиографической спраки
                                            </h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true" id="close_modal">
                                                ×
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <p class="form-group form-control-label">Пожалуйста укажите комментарий
                                                    (причину) отклонение:
                                                </p>
                                                <textarea id="CommentsFromRefuseForm" class="form-control"
                                                          placeholder="Начните писать комментарий" rows="5"
                                                          name="comment" value="" required></textarea>
                                                <small class="label label-warning">Данное сообщение позволит составителю
                                                    быстрее понять и исправить причину отклонения
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit"
                                                    onclick="acceptLibraryReportDiscLibrary('{{ $LibraryReport['Yeared'] }}', '{{ $LibraryReport['SpecialityCode'] }}', '{{ $LibraryReport['DisciplineCode'] }}', '{{ $LibraryReport['Compiler'] }}', '{{ $LibraryReport['CreateDate'] }}', 8, null )"
                                                    class="btn btn-danger col-md-12 waves-effect waves-light">
                                                Подтвердить отклонение
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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

        function acceptLibraryReportDiscLibrary(year, specialitycode, disciplinecode, compiler, createdate, status = null, comment = null) {
            if (status == 8) {
                comment = document.getElementById("CommentsFromRefuseForm").value;
                if (comment.length < 24) exit();
            }
            $.ajax({
                url: "{{ route('LibraryReportDiscLibraryCompiled.updateStatusInLibraryReportDisc') }}",
                type: 'POST',
                data: {
                    Year: year,
                    SpecialityCode: specialitycode,
                    DisciplineCode: disciplinecode,
                    Compiler: compiler,
                    CreateDate: createdate,
                    Status: status,
                    Comment: comment
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                async: true,
                success: function (data) {
                    Notification('Состояние библиографической справки успешно измененено', '', 'success');
                    timer = setTimeout(function () {
                        window.location.reload();
                    }, 500);
                },
                error: function () {
                    Notification('Произошла ошибка удалении литературы из составляемой справки', '', 'error');
                }
            })
        };

        function addCommentToLit()
    </script>
@endsection