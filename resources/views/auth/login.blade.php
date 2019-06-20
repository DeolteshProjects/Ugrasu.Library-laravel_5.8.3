<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Автоматизированная система составлениня библиотечных справок</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('node_modules/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- page css -->
    <link href="{{ asset('css/pages/login-register-lock.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- You can change the theme colors from here -->
    <link href="{{ asset('css/colors/default.css') }}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="card-no-border">
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
    <div class="login-register" style="background-image:url({{ asset('images/background/login-register.jpg') }});">
        <div class="login-box card">
            <div class="card-body">
                <div class="form-group text-center">
                    <div class="alert alert-danger text-center text-danger">
                        <b>
                            <p>Данные аутентификации не получены.</p>
                            <p>Выполнените вход через систему <b><a class="alert-link" href="https://elios.ugrasu.ru/">"ELIOS"</a><b>
                            </p>
                        </b>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="row text-white text-center">
                            <div class="col-md-12 text-center">
                                <h3 class="text-title">Вы можете войти как:</h3>
                            </div>
                            <div class="alert alert-warning">
                                <small>Данный блок установлен только на период разработки и тестирования системы</small>
                            </div>
                            <div class="container">
                            <div class="row">
                            <div class="col-md-12">
                                <!--
                                    <i aria-hidden="true" class="fa fa-user"></i>
                                 -->
                                <a class="btn btn-primary col-md-auto" data-toggle="tooltip" title="Преподаватель"
                                   href="{{ route('login',['auth_name'=>"Сафонов Егор Иванович"])}}">
                                    <span class="text-center">Сафонов Е.И.</span></a>
                                    
                                <a class="btn btn-primary col-md-auto" data-toggle="tooltip" title="Преподаватель"
                                   href="{{ route('login',['auth_name'=>"Усманов Руслан Талгатович"])}}"<i aria-hidden="true"
                                                                                                        class="fa fa-user"></i>
                                    <span class="text-center">Усманов Р. Т.</span></a>
                                    </p>
                                <a class="btn btn-primary col-md-auto" data-toggle="tooltip" title="Преподаватель"
                                   href="{{ route('login',['auth_name'=>"Шицелов Анатолий Вячеславович"])}}"<i aria-hidden="true"
                                                                                                        class="fa fa-user"></i>
                                    <span class="text-center">Шицелов А. В.</span></a>
                                <a class="btn btn-primary col-md-auto" data-toggle="tooltip" title="Преподаватель"
                                   href="{{ route('login',['auth_name'=>"Яворук Олег Анатольевич"])}}"<i aria-hidden="true"
                                                                                                        class="fa fa-user"></i>
                                    <span class="text-center">Яворук О. А.</span></a>
                                    </p>
                                <a class="btn btn-primary col-md-auto" data-toggle="tooltip" title="Преподаватель"
                                   href="{{ route('login',['auth_name'=>"Русанов Михаил Александрович"])}}">
                                    <span class="text-center">Русанов М. А.</span></a>
                                <a class="btn btn-primary col-md-auto" data-toggle="tooltip" title="Преподаватель"
                                   href="{{ route('login',['auth_name'=>"Годовников Евгений Александрович"])}}">
                                    <span class="text-center">Годовников Е. А.</span></a>
                                    </p>
                                <a class="btn btn-primary col-md-auto" data-toggle="tooltip" title="Преподаватель"
                                   href="{{ route('login',['auth_name'=>"Семенов Сергей Петрович"])}}">
                                    <span class="text-center">Семенов С. П.</span></a>
                                <a class="btn btn-outline-success col-md-auto" data-toggle="tooltip" title="Преподаватель"
                                   href="{{ route('login',['auth_name'=>"Алексеев Валерий Иванович"])}}">
                                    <span class="text-center">Алексеев В. И.</span></a>
                                    </p>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-12">
                                <a class="btn btn-success col-md-12" data-toggle="tooltip" title="Библиотека"
                                   href="{{ route('login',['auth_name'=>"Кутлуахметова Салима Тухватовна"])}}"><i
                                            aria-hidden="true" class="fa fa-book"></i>
                                    <span class="text-center">Сотрудник библиотеки</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
<!--Custom JavaScript -->
<script type="text/javascript">
    $(function () {
        $(".preloader").fadeOut();
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
<script src="{{ asset('js/fast_auth.js') }}"></script>

</body>

</html>