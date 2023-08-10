@extends('layouts.admin_login')
@section('title', 'エラー')
@section('content')

    <div class="text-center mb-5">
        <p class="text-bold text-danger" style="font-size: x-large;">エラーが発生しました</p>
        <span style="font-size: x-large;">{{ isset($errorCode) ? $errorCode : '' }}</span>
        <span style="font-size: x-large;">{{ isset($errorMessage) ? $errorMessage : '' }}</span>
    </div>
@stop
