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
                    <li><a href="{{ route('home') }}" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Главная страница</span></a></li>
                    <li><a href="{{ route('Library.getSuccessSpec') }}" aria-expanded="false"><span class="hide-menu"><i class="fa fa-tasks"></i>Составляемые</span></a>
                    </li>
                    <li class=""><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="icon-Box-Full"></i><span class="hide-menu">Дисциплины</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li class="label-light-info"><a href="{{ route('Library.getAll') }}" aria-expanded="false"><span class="hide-menu">Все</span></a></li>
                            <li class="label-light-warning"><a href="{{ route('Library.getAllOnlyNew') }}">На проверке</a></li>
                            <li class="label-light-success"><a href="{{ route('Library.getAllOnlySuccess') }}">Принятые</a></li>
                            <li class="label-light-danger"><a href="{{ route('Library.getAllOnlyDanger') }}">Отклоненные</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="waves-effect" aria-expanded="false"><i class="fa fa-sign-out"></i><span class="hide-menu">Выход из системы</span></a></li>
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

    function printOnlyOneSpecial(specilitycode, year) {
        $.ajax({
            url: '{{ route( 'PrintSpecial') }}',
            type: 'POST',
            async: true,
            data: {
                Year: year, SpecialityCode: specilitycode
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
