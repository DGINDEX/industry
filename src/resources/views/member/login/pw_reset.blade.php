@extends('layouts.member_login')
@section('title', 'ログイン')
@section('content')
    <p class="login-box-msg">パスワードを再設定します</p>
    @if (session('error'))
        <div class="alert alert-danger" role="alert" onclick="this.classList.add('hidden')">{{ session('error') }}</div>
    @endif
    @if (count($errors) > 0)
        <ul class="alert alert-danger list-unstyled">
            @foreach (array_unique($errors->all()) as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {!! Form::open(['url' => '/member/login/pw-update/', 'method' => 'post']) !!}
    {{ Form::considerRequest(true) }}
    {{ Form::hidden('login_id', $login_id) }}
    {{ Form::hidden('authKey', $authKey) }}
    <div class="input-group mb-3">
        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'パスワード']) }}
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        {{ Form::password('password-confirm', ['class' => 'form-control', 'placeholder' => '確認用パスワード']) }}
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-block mb-3">パスワード再設定</button>
    {!! Form::close() !!}
@stop
