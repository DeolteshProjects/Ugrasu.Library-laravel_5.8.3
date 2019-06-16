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
                    <div class="text-center">
                        <b>
                            <p>Данные аутентификации не получены.</p>
                            <p>Выполнените вход через систему <b><a class="alert-link" href="https://elios.ugrasu.ru/">"ELIOS"</a><b></p>
                        </b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                        <div class="row">
                            <div class="col-sm-12 pull-right">
                                <a class="col-sm-3 btn btn-primary" data-toggle="tooltip" title="Преподаватель"
                                   href="{{ route('home') }}?auth_name=Сафонов Егор Иванович"><i aria-hidden="true" class="fa fa-user"></i>
                                </a>
                                <button class="col-sm-3 btn btn-dark" data-toggle="tooltip"
                                        title="Руководитель ОПОП" onclick="fastRucopopAuth()"><i aria-hidden="true"
                                                                                                 class="fa fa-user-secret"></i>
                                </button>
                                <a class="col-sm-3 btn btn-success" data-toggle="tooltip" title="Библиотека"
                                   href="{{ route('home') }}?auth_name=Кутлуахметова Салима Тухватовна"><i aria-hidden="true" class="fa fa-book"></i>
                                </a>
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