@extends('layouts.admin')
@section('title', '企業管理')
@section('page_category', '企業管理')
@section('page_detail', '一覧')
@section('active_menu_parent', 'company')
@section('active_menu_child', 'list')
@section('content')
    {{ Form::open(['url' => 'admin/company/', 'method' => 'get', 'id' => 'form']) }}
    {{ Form::considerRequest(true) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">検索条件</h3>
            <div class="card-tools">
                <a href="{{ url('/admin/company/edit') }}">
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
                        <label class="col-form-label">会社名</label>
                        <div class="">
                            {!! Form::text('company_name', '', ['class' => 'form-control pull-right', 'placeholder' => '会社名']) !!}
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">業種</label>
                        <div class="">
                            {!! Form::select('industry_id', $industryList, '', ['class' => 'form-control pull-right', 'placeholder' => '選択してください']) !!}
                        </div>
                    </div>
                </div> --}}
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">代表者名</label>
                        <div class="">
                            {!! Form::text('representative_name', '', ['class' => 'form-control pull-right', 'placeholder' => '代表者名']) !!}
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">ステータス</label>
                        <div class="">
                            {!! Form::select('status', config('const.status_name'), '', ['class' => 'form-control', 'placeholder' => '選択してください']) !!}
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
                <!-- /.row -->
            </div>
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
                    @if ($companyList->count() > 0)
                        {{ $companyList->firstItem() }}-{{ $companyList->lastItem() }}件/
                    @endif
                    {{ $companyList->total() }}件
                </span>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover table-striped">
                 <thead>
                    <tr>
                        <th><a href="{{ Request::getSortLink('id') }}">No.</a></th>
                        <th><a href="{{ Request::getSortLink('company_name') }}">会社名</a></th>
                        {{-- <th><a href="{{ Request::getSortLink('industry_name') }}">業種</a></th> --}}
                        <th>カテゴリ</th>
                        <th><a href="{{ Request::getSortLink('representative_name') }}">代表者名</a></th>
                        <th><a href="{{ Request::getSortLink('status_name') }}">ステータス</a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companyList as $item)
                        <tr>
                            <td>
                                {{ $item->id }}
                            </td>
                            <td>
                                <a href="{{ url('/admin') }}/company/edit/{{ $item->id }}">
                                    {{ $item->company_name }}
                                </a>
                            </td>
                            {{-- <td>{{ $item->industry_name }}</td> --}}
                            <td>{{ $item->category_name }}</td>
                            <td>{{ $item->representative_name }}</td>
                            <td>{{ $item->status_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer clearfix">
            {{ $companyList->appends($conditions)->links() }}
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
