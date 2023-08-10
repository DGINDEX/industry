@extends('layouts.admin_login')
@section('title', 'ログイン')
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert" onclick="this.classList.add('hidden')">{{ session('status') }}</div>
    @else
        <p class="login-box-msg">パスワード再設定用URLを送付します</p>
    @endif
    @if (count($errors) > 0)
        <ul class="alert alert-danger list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    @if (session('error'))
        <ul class="alert alert-danger list-unstyled" role="alert" onclick="this.classList.add('hidden')">
            <li>{{ session('error') }}</li>
        </ul>
    @endif

    {!! Form::open(['url' => '/admin/login/send-mail/', 'method' => 'post']) !!}
    {{ Form::considerRequest(true) }}
    <div class="input-group mb-3">
        {{ Form::text('login_id', old('login_id'), ['class' => 'form-control', 'placeholder' => 'ログインID']) }}
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>
    <div class="form-group has-feedback">
        {{ Form::email('send_mail', old('mail'), ['class' => 'form-control', 'placeholder' => 'メール送信用のメールアドレス']) }}
    </div>
    <!-- 管理ログイン以外にはリマインダーをつける-->
    <button type="submit" class="btn btn-primary btn-block mb-3">パスワード再設定申請</button>
    <div class="text-center mb-3">
        <a href="{{ url('/') }}/admin/login">戻る</a>
    </div>
    {!! Form::close() !!}
@stop
