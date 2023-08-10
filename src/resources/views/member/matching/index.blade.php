@extends('layouts.member')
@section('title', '案件管理')
@section('page_category', '案件管理')
@section('page_detail', '一覧')
@section('active_menu_parent', 'matching')
@section('active_menu_child', 'list')
@section('content')
    {{ Form::open(['url' => 'member/matching/', 'method' => 'get', 'id' => 'form']) }}
    {{ Form::considerRequest(true) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">検索条件</h3>
            <div class="card-tools">
                <a href="{{ url('/member/matching/edit') }}">
                    <button type="button" class="btn btn-primary flex-fill flex-md-grow-0">新規追加</button>
                </a>
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <div class="row">

                <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">案件名</label>
                        <div class="">
                            {!! Form::text('project_name', '', ['class' => 'form-control pull-right', 'placeholder' => '案件名']) !!}
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">カテゴリ</label>
                        <div class="">
                            {!! Form::select('category_id[]', $categoryList, '', ['class' => 'pillbox']) !!}
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">状態</label>
                        <div class="">
                            {!! Form::select('status', config('const.matching.status_name'), null, ['class' => 'form-control', 'placeholder' => '選択してください']) !!}
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

    {{ Form::close() }}

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">検索結果</h3>
            <div class="card-tools form-inline">
                <span class="mr-3">
                    @if ($matchingList->count() > 0)
                        {{ $matchingList->firstItem() }}-{{ $matchingList->lastItem() }}件 /
                    @endif
                    {{ $matchingList->total() }}件
                </span>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th><a href="{{ Request::getSortLink('project_name') }}">案件名</a></th>
                        <th>カテゴリ</th>
                        <th><a href="{{ Request::getSortLink('status') }}">状態</a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matchingList as $item)
                        <tr>
                            <td>
                                <a href="{{ url('/member') }}/matching/edit/{{ $item->id }}">
                                    {{ $item->project_name }}
                                </a>
                            </td>
                            <td>{{ $item->category_name }}</td>
                            <td>{{ $item->status_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer clearfix ">
            {{ $matchingList->appends($conditions)->links() }}
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
@stop
@section('script')
    <script>
        var data = @json($categories);
        var array = [];

        if (data != null) {
            for (let i = 0; i < data.length; i++) {
                array.push(data[i]);
            }

            $(".pillbox").val(array).trigger("change");

        } else {
            $('.pillbox').val(null).trigger('change');
        }

    </script>
@stop
