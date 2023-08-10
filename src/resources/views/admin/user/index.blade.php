@extends('layouts.admin')
@section('title', 'ユーザー管理')
@section('page_category', 'ユーザー管理')
@section('page_detail', '一覧')
@section('active_menu_parent', 'user')
@section('active_menu_child', 'list')
@section('content')
    {{ Form::open(['url' => 'admin/user/', 'method' => 'get', 'id' => 'form']) }}
    {{ Form::considerRequest(true) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">検索条件</h3>
            <div class="card-tools">
                <a href="{{ url('/admin/user/edit') }}">
                    <button type="button" class="btn btn-primary flex-fill flex-md-grow-0">新規追加</button>
                </a>
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label">氏名カナ</label>
                        <div class="">
                            {!! Form::text('name_kana', '', ['class' => 'form-control pull-right', 'placeholder' => '氏名カナ']) !!}
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label">ステータス</label>
                        <div class="">
                            {!! Form::select('status', $userStatusBox, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary float-right">検索</button>
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">検索結果</h3>
            <div class="card-tools form-inline">
                <span class="mr-3">
                    @if ($userList->count() > 0)
                        {{ $userList->firstItem() }}-{{ $userList->lastItem() }}件/
                    @endif
                    {{ $userList->total() }}件
                </span>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th><a href="{{ Request::getSortLink('name') }}">氏名</a></th>
                        <th><a href="{{ Request::getSortLink('name_kana') }}">氏名カナ</a></th>
                        <th><a href="{{ Request::getSortLink('login_id') }}">メールアドレス</a></th>
                        <th><a href="{{ Request::getSortLink('status') }}">ステータス</a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userList as $item)
                        <tr>
                            <td>
                                <a href="{{ url('/admin') }}/user/edit/{{ $item->id }}">
                                    {{ $item->administrator_name }}
                                </a>
                            </td>
                            <td>{{ $item->administrator_name_kana }}</td>
                            <td>{{ $item->login_id }}</td>
                            <td>{{ $item->status_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer clearfix">
            {{ $userList->appends($conditions)->links() }}
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
    {{ Form::close() }}
@stop
