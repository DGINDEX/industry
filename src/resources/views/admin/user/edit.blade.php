@extends('layouts.admin')
@section('title', 'ユーザー管理')
@section('page_category', 'ユーザー管理')
@section('page_detail', '詳細')
@section('active_menu_parent', 'user')
@section('active_menu_child', 'list')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">詳細情報</h3>
        </div>
        <!-- /.card-header -->
        {{ Form::open(['url' => '/admin/user/update', 'method' => 'post', 'id' => 'form', 'name' => 'form']) }}
        {{ Form::considerRequest(true) }}
        {{ Form::hidden('id', $user->id) }}
        <div class="card-body">
            <table class='table table-bordered tbl-detail'>
                <tr>
                    <th>メールアドレス(ログインID)</th>
                    <td>
                        @if ($user->id)
                            {{ $user->login_id }}
                            {{ Form::hidden('login_id', $user->login_id) }}
                        @else
                            {{ Form::text('login_id', $user->login_id, ['class' => 'form-control pull-right', 'placeholder' => 'メールアドレス']) }}
                        @endif
                    </td>
                    <th>パスワード</th>
                    <td>
                        {{ Form::text('plain_login_password', $user->password ? $user->plain_login_password : '', ['class' => 'form-control pull-right', 'placeholder' => 'パスワード']) }}
                    </td>
                </tr>
                <tr>
                    <th>氏名</th>
                    <td>
                        {{ Form::text('name', $user->administrator_name, ['class' => 'form-control pull-right', 'placeholder' => '氏名']) }}
                    </td>
                    <th>氏名カナ</th>
                    <td>
                        {{ Form::text('name_kana', $user->administrator_name_kana, ['class' => 'form-control pull-right', 'placeholder' => '氏名カナ']) }}
                    </td>
                </tr>
                <tr>
                    <th>ステータス</th>
                    <td colspan="3">
                        {{ Form::select('status', config('const.status_name'), $user->status, ['class' => 'form-control']) }}
                    </td>
                </tr>
            </table>
            <!-- /.table -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            @if ($user->id)
                <button type="button" class="btn btn-danger float-left delete"
                    onclick="dataDelete(event, '{{ url('/admin') }}/user/delete/{{ $user->id }}', '#form', 'post');">削除</button>
            @endif
            <button id="save-button" type="submit" class="btn btn-primary float-right">保存</button>
            <a href="{{ url('/admin') }}/user" class="btn btn-secondary float-right mr-2">戻る</a>
        </div>
        {{ Form::close() }}
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->

@stop
