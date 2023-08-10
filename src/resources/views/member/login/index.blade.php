@extends('layouts.member_login')
@section('title', 'ログイン')
@section('content')
    @if (count($errors) > 0 || session('error'))
        <ul class="alert alert-danger list-unstyled">
            @foreach (array_unique($errors->all()) as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    {!! Form::open(['url' => '/member/login/', 'method' => 'post']) !!}
    {{ Form::considerRequest(true) }}
    <div class="input-group mb-3">
        {{ Form::text('login_id', old('login_id'), ['class' => 'form-control', 'placeholder' => 'ID']) }}
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'パスワード']) }}
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div>
        <button type="submit" class="btn btn-primary btn-block mb-3">ログイン</button>
        <div class="text-center mb-3">
            <a href="{{ url('/') }}/member/login/reminder">パスワードをお忘れの方</a>
        </div>
    </div>

    {!! Form::close() !!}
@stop
