<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/vendor/fontawesome/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/Ionicons/css/ionicons.min.css') }}">
    <!-- select2-->
    <link rel="stylesheet" href="{{ asset('/vendor/select2/css/select2.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/admin-lte/css/adminlte.min.css') }}">
    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ asset('/sweetalert2/dist/sweetalert2.min.css') }}">
    <!-- jQuery UI-->
    <link rel="stylesheet" href="{{ asset('/jquery-ui/jquery-ui.min.css') }}">
    <!-- date picker -->
    <link rel="stylesheet" href="{{ asset('/bootstrap-datepicker/css/bootstrap-datepicker.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- Original -->
    <link rel="stylesheet" href="{{ asset('/css/admin.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header>

            <!-- Header Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                @section('header')
                    @include('member.header')
                @show
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="brand-link">
                <span class="brand-text text-sm font-weight-light">{{ config('const.system_name') }}</span>
            </div>
            @section('side')
                @include('member.side')
            @show
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>
                                @yield('page_category')
                                <small>@yield('page_detail')</small>
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ul class="breadcrumb float-sm-right">
                                <?php $uri = explode('/', Route::current()->uri); ?>
                                <?php $uri[0] == 'member' && count($uri) != 1 ? ($url = $uri[0] . '/' .
                                $uri[1]) : ($url = $uri[0]); ?>
                                <li class="breadcrumb-item"><a href="<?= url($url) ?>">@yield('page_category')</a></li>
                                <li class="breadcrumb-item active">@yield('page_detail')</li>
                            </ul>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                @if (session('status'))
                    <div class="alert alert-success" role="alert" onclick="this.classList.add('hidden')">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert" onclick="this.classList.add('hidden')">
                        {{ session('error') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <ul  class="alert alert-danger list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">

            </div>
            <!-- Default to the left -->
            <strong>
                {{config('const.copyright')}}
            </strong>
            All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->
    <script src="{{ asset('/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <!-- date-picker -->
    <script src="{{ asset('/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/bootstrap-datepicker/locales/bootstrap-datepicker.ja.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/moment/locale/ja.js') }}"></script>
    <script src="{{ asset('/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/admin-lte/js/adminlte.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('/select2/js/select2.min.js') }}"></script>
    <script>
        var success = @json(session('success'));
        var errorMes = @json(session('errorMes'));
        var message = @json(session('message')) ? @json(session('message')) : '';

    </script>
    <script src="{{ asset('js/disp-message.js') }}"></script>
    <!-- original -->
    <script src="{{ asset('/js/date-picker.js') }}"></script>
    <script src="{{ asset('/js/date-range.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>
    <script>
        /**
         * セレクト2ボックスの初期設定
         */
        $('.pillbox').select2({
            multiple: "multiple",
            width: '100%',
            placeholder: "選択してください",
            allowClear: true,
            closeOnSelect: false
        });
    </script>
    @yield('script')
</body>

</html>
