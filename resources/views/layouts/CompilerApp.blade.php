<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('node_modules/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Loader CSS -->
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('css/colors/default.css') }}" id="theme" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{ asset('node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- TagsInput -->
    <link href="{{ asset('node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet"/>
    <!-- Contacts CSS -->
    <link href="{{ asset('css/pages/contact-app-page.css') }}" rel="stylesheet">
    <!-- Footable CSS -->
    <link href="{{ asset('node_modules/footable/css/footable.core.css') }}" rel="stylesheet">
    <link href="{{ asset('node_modules/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet"/>
    <!-- page css -->
    <link href="{{ asset('css/pages/footable-page.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="fix-header card-no-border fix-sidebar">

<div id="toastjs"></div>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">{{ config('app.name', 'Laravel') }}</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <!-- Logo icon --><b>
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="{{ asset('images/logo-icon.png') }}" alt="homepage" class="dark-logo"/>
                        <!-- Light Logo icon -->
                        <img src="{{ asset('images/logo-light-icon.png') }}" alt="homepage" class="light-logo"/>
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="{{ asset('images/logo-text.png') }}" alt="homepage" class="dark-logo"/>
                        <!-- Light Logo text -->
                         <img src="{{ asset('images/logo-light-text.png') }}" class="light-logo" alt="homepage"/></span>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto">
                    <!-- This is  -->
                    <li class="nav-item"><a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark"
                                            href="javascript:void(0)"><i class="sl-icon-menu"></i></a></li>
                    <li class="nav-item"><a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark"
                                            href="javascript:void(0)"><i class="sl-icon-menu"></i></a></li>
                    <!-- ============================================================== -->
                </ul>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <ul class="navbar-nav my-lg-0">
                    <!-- ============================================================== -->
                    <!-- Profile -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="hidden-md-down">{{ \Illuminate\Support\Facades\Session::get('Authenticate.name') }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animated flipInY">
                            <ul class="dropdown-user">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-text">
                                            <h4>{{ \Illuminate\Support\Facades\Session::get('Authenticate.name') }}</h4>
                                            <p class="text-muted">{{ \Illuminate\Support\Facades\Session::get('Authenticate.department') }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Выйти
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li><a href="{{ route('home') }}" aria-expanded="false"><i class="fa fa-home"></i><span
                                    class="hide-menu">Главная страница</span></a></li>


                    <li class="label label-light-info"
                        @if (!Session::has('LibraryReportDiscLocal.Creating')) hidden @endif
                        id="linkLibraryReportsSeed"><a id="compilingLink" class="waves-effect"
                                                       @if (!Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfLiterature'))
                                                       data-toggle="modal" data-target="#ModalBookSearchForm">Добавить
                            литературу в
                            @if(Session::get('LibraryReportDiscLocal.Edit'))
                                редактируемую
                            @else
                                составляемую
                            @endif
                            справку</a>
                        @else
                            href="{{ route('Compiler.get') }}">Перейти к
                            @if(Session::get('LibraryReportDiscLocal.Edit'))
                                редактируемой
                            @else
                                составляемой
                            @endif
                            справке</a>
                        @endif
                    </li>

                    <li><a data-toggle="modal"
                           data-target="#ModalBookSearchForm" class="waves-effect" aria-expanded="false"><i
                                    class="fa fa-book"></i><span class="hide-menu">Поиск литературы</span></a></li>

                    @if(!Session::has('LibraryReportDiscLocal'))
                        <li><a data-toggle="modal"
                               data-target="#ModalCreateLibraryReportFormCenter" class="waves-effect"
                               aria-expanded="false"><i class="fa fa-plus-square-o"></i><span class="hide-menu">Создать новую</span></a>
                        </li>
                    @endif

                    @if (Session::has('LibraryReportDiscLocal.Creating'))
                        <li class="label label-light-danger"><a onclick="DeleteCreatingLibraryReport()"
                                                                aria-expanded="false"><span class="waves-effect">Отменить
                                    @if(Session::get('LibraryReportDiscLocal.Edit'))
                                        редактирование
                                    @else
                                        составление
                                    @endif
                                        библиографической справки</span></a></li>
                    @endif
                    <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="waves-effect" aria-expanded="false"><i class="fa fa-sign-out"></i><span
                                    class="hide-menu">Выход из системы</span></a></li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

        @yield('content')

        <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
            © {{ date("Y") }} Denis Shilenkov for VKR
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>


<div class="modal fade " id="ModalCreateLibraryReportFormCenter" tabindex="1" role="dialog"
     aria-labelledby="ModalCreateLibraryReportFormTitle" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalCreateLibraryReportFormLongTitle">Выберите необходимые
                    параметры для
                    составления библиографичесских справок</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <label class="control-label">Год набора</label>
                                    <select class="form-control custom-select"
                                            style="text-align-last: center" id="selectedYear"
                                            name="selectedYear"
                                            type="number" onchange="changeYear()" required>
                                        <option value="" selected>Выберите год набора</option>
                                    </select>
                                </div>
                            </div>
                            <!--/span-->
                            <!--/span-->
                            <div class="col-md-12" id="selectedSpecBlock" hidden>
                                <div class="form-group text-center">
                                    <label class="control-label">Направление подготовки</label>
                                    <select class="form-control custom-select"
                                            style="text-align-last: center" id="selectedSpec"
                                            name="selectedSpec"
                                            type="text" onchange="changeSpec()" disabled required>
                                        <option value="" selected>Выберите направление обучения
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!--/span-->
                            <!--/span-->
                            <div class="col-md-12" id="selectedDiscBlock" hidden>
                                <div class="form-group text-center">
                                    <label class="control-label">Дисциплина</label>
                                    <select class="form-control custom-select"
                                            style="text-align-last: center" id="selectedDisc"
                                            name="selectedDisc"
                                            type="text" onchange="changeDisc()" disabled required>
                                        <option value="" selected>Выберите дисциплину</option>
                                    </select>
                                </div>
                            </div>

                            <!--/span-->
                            <div class="col-md-12" id="selectedFGOSBlock" hidden>
                                <div class="form-group text-center">
                                    <label class="control-label">ФГОС</label>
                                    <select class="form-control custom-select"
                                            style="text-align-last: center" id="selectedFGOS"
                                            name="selectedFGOS"
                                            type="text" onchange="changeFGOS()" disabled required>
                                        <option value="" selected>Выберите ФГОС</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12" id="loader" hidden>
                                <div class="form-group row">
                                    <div class="col-md-12 text-center text-info">
                                        <div class="loader">
                                            <div class="loader__figure"></div>
                                            <p class="loader__label">Выполняется загрузка</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-danger" data-dismiss="modal">Отменить
                </button>
                <button type="button" onclick="saveCreatingLibraryReport()" id="btn-select-all"
                        class="btn btn-outline-success" data-dismiss="modal" hidden>Приступить
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="ModalBookSearchForm" tabindex="2" role="dialog"
     aria-labelledby="ModalBookSearchFormTitle" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalBookSearchFormLongTitle">Введите необходимые
                    параметры для поиска литературы</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('bookSearch.result') }}" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <label class="control-label">Автор</label>
                                    <input class="form-control"
                                           style="text-align-last: center" id="bookAuthor"
                                           name="bookAuthor"
                                           type="text" placeholder="Укажите автора...">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <label class="control-label">Заглавие</label>
                                    <input class="form-control"
                                           style="text-align-last: center" id="bookTitle"
                                           name="bookTitle"
                                           type="text" placeholder="Введите заглавие...">
                                </div>
                            </div>
                            <!--/span-->
                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <label class="control-label"><b><b class="text-success">Ключевые</b></b>
                                        слова</label>
                                    <input class="form-control"
                                           style="text-align-last: center" id="bookKeyWord"
                                           name="bookKeyWord"
                                           type="text" placeholder="Введите ключевые слова...">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <label class="control-label"><b><b class="text-danger">Стоп</b></b> слова</label>
                                    <input class="form-control"
                                           style="text-align-last: center" id="bookStopWord"
                                           name="bookStopWord"
                                           type="text" placeholder="Введите СТОП слова...">
                                    <small>Из найденной литературы будут исключены результаты содержащие в описании СТОП
                                        слова
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-12" id="loader" tabindex="1" hidden>
                                <div class="form-group row">
                                    <div class="col-md-12 text-center text-info">
                                        <div class="loader">
                                            <div class="loader__figure"></div>
                                            <p class="loader__label">Выполняется загрузка</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="col-md-12 btn  btn-outline-info" id="bookSearch"
                                onclick="bookSearchButtonClick()">Поиск
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->

<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('node_modules/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('node_modules/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('node_modules/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('node_modules/ps/perfect-scrollbar.jquery.min.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<!--stickey kit -->
<script src="{{ asset('node_modules/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('node_modules/sparkline/jquery.sparkline.min.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('js/custom.min.js') }}"></script>
<!--Custom JavaScript -->
<!-- <script src="{{ asset('js/my/reports.js') }}"></script> -->
<script src="{{ asset('node_modules/toast-master/js/jquery.toast.js') }}"></script>
<script src="{{ asset('js/my/notify.js') }}"></script>

<!-- Data tables-->
<!-- This is data table -->
<script src="{{ asset('node_modules/datatables/jquery.dataTables.min.js') }}"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->
<script>

    function bookSearchButtonClick() {
        document.getElementById("bookSearch").innerText = "Выполняется поиск";
    }

    //Завершение составления библиографической справки и удаление ее из сессии
    function DeleteCreatingLibraryReport() {
        $.ajax({
            url: '{{ route( 'Compiler.delete') }}',
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

    function reset_selects(select) {
        switch (select) {
            case 1:
                document.getElementById('selectedSpecBlock').hidden = true;
                document.getElementById('selectedDiscBlock').hidden = true;
                document.getElementById('selectedFGOSBlock').hidden = true;
                document.getElementById("selectedSpec").options.length = 1;
                document.getElementById("selectedSpec").disabled = true;
                document.getElementById("btn-select-all").hidden = true;
                break;
            case 2:
                document.getElementById('selectedDiscBlock').hidden = true;
                document.getElementById('selectedFGOSBlock').hidden = true;
                document.getElementById('selectedFGOS').disabled = true;
                document.getElementById("selectedDisc").options.length = 1;
                document.getElementById("selectedDisc").disabled = true;
                document.getElementById("btn-select-all").hidden = true;
                break;
            case 3:
                document.getElementById('selectedFGOSBlock').hidden = true;
                document.getElementById('selectedFGOS').disabled = true;
                document.getElementById("selectedFGOS").options.length = 1;
                break;
            default:
                break;
        }
    }

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

    /**
     * Далее все функции идут примерно по хронологии действий
     */

    //Получаем года для списка
    function writeSelectYear() {
        //Инициализируем список годов поступления
        var yearsSelect = document.getElementById("selectedYear");
        //Берем текущий год в js
        var currentDate = new Date();
        var year;
        //Если ранее июня, то берем еще за предыдущий год (календарный)
        currentDate.getMonth() < 5 ? year = currentDate.getFullYear() - 1 : year = currentDate.getFullYear();
        //Добавляем 1 год назад и 4 года вперед
        for ($i = 1; $i <= 8; $i++) {
            yearsSelect.options[$i] = new Option(($i + year - 6) + " - " + ($i + year - 5), ($i + year - 6));
        }
    }

    writeSelectYear();

    //Выбор года набора и загрузка направлений
    function changeYear() {
        //Отключаем и сбрасываем все последующие селекты
        reset_selects(1);
        var year = document.getElementById("selectedYear").value;
        if (year == "") exit();
        document.getElementById('loader').hidden = false;
        //Запрос на загрузку направлений по году
        $.ajax({
            url: '{{ route( 'WorkProgram.getSpeciality') }}',
            type: 'POST',
            async: true,
            data: {
                year: year
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (!data)
                    $('#selectedSpec').append("value='NULL'>На выбранный год отсутсвует список направлений</option>");
                else {
                    var result = JSON.parse(data);
                    if (Object.keys(result).length > 0) {
                        for (i in result) {
                            $('#selectedSpec').append('<option value="' + result[i]['fspecialitycode'] + ' | ' + result[i]['speciality'] + '">' + result[i]['fspecialitycode'] + ' | ' + result[i]['speciality'] + '</option>');
                            i++;
                        }
                        document.getElementById('selectedSpecBlock').hidden = false;
                        document.getElementById("selectedSpec").disabled = false;
                        Notification('Направления обучения успешно загружены', '', 'success');
                    } else {
                        Notification('Направления на выбранный год набора не найдены', '', 'error');
                    }
                    document.getElementById('loader').hidden = true;
                }
            },
            error: function () {
                Notification('Произошла ошибка при загрузке направлений', '', 'error');
            }
        })
    }

    //Выбор направления и загрузка дисциплин
    function changeSpec() {
        //Отключаем и сбрасываем все последующие селекты
        reset_selects(2);
        //Запрос на загрузку направлений по году
        var year = document.getElementById("selectedYear").value;
        var speciality = document.getElementById("selectedSpec").value;
        if (speciality == "") exit();
        document.getElementById('loader').hidden = false;
        $.ajax({
            url: '{{ route( 'WorkProgram.getDisciplines') }}',
            type: 'POST',
            async: true,
            data: {
                year: year, speciality: speciality
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (!data)
                    $('#selectedDisc').append("value='NULL'>На выбранный год отсутсвует список направлений</option>");
                else {
                    var result = JSON.parse(data);
                    if (Object.keys(result).length > 0) {
                        for (i in result) {
                            $('#selectedDisc').append('<option value="' + result[i]['discode'] + ' | ' + result[i]['discipline'] + '">' + result[i]['discipline'] + '</option>');
                            i++;
                        }
                        document.getElementById('selectedDiscBlock').hidden = false;
                        document.getElementById("selectedDisc").disabled = false;
                        Notification('Дисциплины загружены', '', 'success');
                    } else {
                        Notification('Дисциплины на выбранный год набора и направление не найденны', '', 'error');
                    }
                    document.getElementById('loader').hidden = true;
                }
            },
            error: function () {
                Notification('Произошла ошибка при загрузке дисциплин', '', 'error');
            }
        })
    }

    //Отображение клопки завершений
    function changeDisc() {
        //Отключаем и сбрасываем все последующие селекты
        reset_selects(3);
        var speciality = document.getElementById("selectedSpec").value;
        if (speciality == "") exit();
        document.getElementById('loader').hidden = false;
        //Запрос на загрузку направлений по году
        var speciality = document.getElementById("selectedSpec").value;
        $.ajax({
            url: '{{ route( 'WorkProgram.getFGOS') }}',
            type: 'POST',
            async: true,
            data: {
                speciality: speciality
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var result = JSON.parse(data);
                if (Object.keys(result).length > 0) {
                    for (i in result) {
                        if (result[i]['fgos3_pp'] !== null) {
                            $('#selectedFGOS').append('<option value="' + result[i]['fgos3_p'] + '">' + result[i]['fgos3_p'] + ' | ' + result[i]['fgos3_pp'] + '</option>');
                        } else {
                            $('#selectedFGOS').append('<option value="' + result[i]['fgos3_p'] + '">' + result[i]['fgos3_p'] + '</option>');
                        }
                        i++;
                    }
                    document.getElementById('selectedFGOSBlock').hidden = false;
                    document.getElementById("selectedFGOS").disabled = false;
                    Notification('ФГОС загружены', '', 'success');
                } else {
                    document.getElementById("btn-select-all").hidden = false;
                    Notification("ФГОС по направлению не найденны", '', "warning");
                }
                document.getElementById('loader').hidden = true;
            },
            error: function () {
                Notification("Произошла ошибка при выборе создании библиографической справки", '', "error");
            }
        })
    }

    function changeFGOS() {
        var FGOS = document.getElementById("selectedFGOS").value;
        if (FGOS == "") exit();
        document.getElementById("btn-select-all").hidden = false;
    }

    //Подтверждение заполнения формы
    function saveCreatingLibraryReport() {
        var year = document.getElementById("selectedYear").value;
        var speciality = document.getElementById("selectedSpec").value;
        var discipline = document.getElementById("selectedDisc").value;
        var fgos = document.getElementById("selectedFGOS").value;
        $.ajax({
            url: '{{ route( 'Compiler.create') }}',
            type: 'POST',
            async: true,
            data: {
                year: year, speciality: speciality, discipline: discipline, fgos: fgos
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var result = JSON.parse(data);
                if (Object.keys(result).length > 0) {
                    Notification(result['message'], '', result['code']);
                }
                if (result['code'] == "success") {
                    timer = setTimeout(function () {
                        window.location.reload();
                    }, 500);
                }
            },
            error: function () {
                Notification("Произошла ошибка создании библиографической справки", '', "error");
            }
        })
    }

    function printOnlyOneDisc(specilitycode, year, disciplinecode) {
        $.ajax({
            url: '{{ route( 'PrintDisc') }}',
            type: 'POST',
            async: true,
            data: {
                Year: year, SpecialityCode: specilitycode, DisciplineCode: disciplinecode
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var result = JSON.parse(data);
                if (result['code'] == "success") {
                    Notification(result['message'], '', result['code']);

                    //Сохранение
                    var link = document.createElement('a');
                    link.setAttribute('href', result['url']);
                    link.setAttribute('download', result['name']);
                    //link.attr('target','_blank');
                    link.click();
                }
            },
            error: function () {
                Notification("Произошла ошибка попытке скачивания библиографической справки", '', "error");
            }
        })
    }
</script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->

<script src="{{ asset('node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('node_modules/styleswitcher/jQuery.style.switcher.js') }}"></script>


<!-- Footable -->
<script src="{{ asset('node_modules/footable/js/footable.all.min.js') }}"></script>
<!--FooTable init-->
<script src="{{ asset('js/footable-init.js') }}"></script>


</body>

</html>
