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
    <!-- jQuery UI-->
    <link rel="stylesheet" href="{{ asset('/jquery-ui/jquery-ui.min.css') }}">
    <!-- Original -->
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
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

<body id="index" class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="l-header header">
            <h1 class="logo">
                <a href="/">
                </a>
            </h1>

            <div class="sp-bg"></div>
            <nav class="header-nav">
                <div class="nav-inner">
                    <ul class="nav-list">
                        <li>
                            <a id="nav-company" class="header-nav-item" href="/company">企業一覧</a>
                        </li>

                        <li>
                            <a id="nav-matching" class="header-nav-item" href="/matching">案件一覧</a>
                        </li>

                    </ul>
                    <small class="copyright show-medium">© {{config('const.copyright')}}</small>
                </div>
            </nav>
            <div id="menuBtn" class="btn-list show-medium">
                <div class="btn-line"></div>
                <div class="btn-line"></div>
                <div class="btn-line"></div>
            </div>
        </header>

        <!-- Content Wrapper. Contains page content -->
        <div>
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="footer">
            <p id="page-top" class="hide-btn"><a href="#">Page Top</a></p>
            <section class="btm">
                <div class="btm-link">
                    <ul>
                        <li><a class="font15" href="http://www.moriyama-cci.or.jp/foottermenu/personal.html" target="_blank"
                                rel="noopener noreferrer">個人情報の取扱</a>
                        </li>
                        <li><a class="font15" href="http://www.moriyama-cci.or.jp/foottermenu/inquiry.html" target="_blank"
                                rel="noopener noreferrer">お問い合わせ</a>
                        </li>
                    </ul>
                    <ul>
                        <li><a class="font15" href="{{ url('/member') }}/login/">企業管理画面ログイン</a>
                        </li>
                    </ul>
                </div>
                <div class="image">
                    <img src="/images/biwako.png" alt="びわ湖" />
                </div>
                <div class="btm-copy">Copyright {{config('const.copyright')}} <br class="sp-br">All Rights Reserved.</div>
            </section>
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
    <!-- AdminLTE App -->
    <script src="{{ asset('/admin-lte/js/adminlte.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        var success = @json(session('success'));
        var errorMes = @json(session('errorMes'));
        var message = @json(session('message')) ? @json(session('message')) : '';

    </script>
    <script src="{{ asset('js/disp-message.js') }}"></script>
    <script src="{{ asset('/js/front.js') }}"></script>
    @yield('script')
</body>

</html>
