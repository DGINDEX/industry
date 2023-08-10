@extends('layouts.admin_login')
@section('title', 'ログイン')
@section('content')
<div class="login-box-body">
    <p class="login-box-msg">パスワード再設定が完了しました</p>
    <a href="{{url('/')}}/admin/login/">
        <button class="btn btn-primary btn-block mb-3">ログイン画面へ</button>
    </a>
</div>
@stop