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
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">{{ config('app.name', "Laravel") }}</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
    <div class="login-register" style="background-image:url({{ asset('images/background/login-register.jpg') }});">
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h3 class="box-title m-b-20">{{ __('Login') }}</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                   value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required
                                   autofocus></div>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" placeholder="{{ __('Password') }}" required></div>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12 p-b-20">
                            <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit"> {{ __('Login') }}</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                            <div class="row">
                                <div class="col-sm-12 pull-right">
                                    <button class="col-sm-3 btn btn-primary" data-toggle="tooltip" title="Преподаватель"
                                            onclick="fastTeacherAuth()"><i aria-hidden="true" class="fa fa-user"></i>
                                    </button>
                                    <button class="col-sm-3 btn btn-dark" data-toggle="tooltip"
                                            title="Руководитель ОПОП" onclick="fastRucopopAuth()"><i aria-hidden="true"
                                                                                                     class="fa fa-user-secret"></i>
                                    </button>
                                    <button class="col-sm-3 btn btn-success" data-toggle="tooltip" title="Библиотека"
                                            onclick="fastLibraryAuth()"><i aria-hidden="true" class="fa fa-book"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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