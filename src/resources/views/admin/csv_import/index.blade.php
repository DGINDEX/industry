<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CSV取込 | {{ config('app.name') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/vendor/fontawesome/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/admin-lte/css/adminlte.min.css') }}">
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

<body class="hold-transition skin-red login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>{{ config('app.name') }}</b><br />
        </div>
        <div class="card">
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
                <div class="card-body login-card-body">
                    {!! Form::open(array('url' => '/admin/csv-import/import', 'method' => 'post', 'id'=>'form', 'files' => true)) !!}
                    {!! Form::considerRequest(true) !!}
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">企業情報CSV取込</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="p-20">
                                {{Form::file('csv', ['class'=>'', 'accept' => '.csv'])}}
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">アップロード</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    {!! Form::close() !!}
                </div>
            <!-- /.login-box-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="{{ asset('/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- iCheck -->
    <script src="https://adminlte.io/themes/AdminLTE/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });

    </script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script>
    var success = <?php echo json_encode(session('success')); ?>;    if (success) {
        $(function() {
            Swal.fire(success, '', 'success');
        });
    }
    var error = <?php echo json_encode(session('error')); ?>;    if (error) {
        $(function() {
            Swal.fire(error, '', 'error');
        });
    }
</script>
</body>

</html>
