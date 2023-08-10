@extends('layouts.member')
@section('title', '案件管理')
@section('page_category', '案件管理')
@section('page_detail', '詳細')
@section('active_menu_parent', 'matching')
@section('active_menu_child', 'list')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">詳細情報</h3>
        </div>
        <!-- /.card-header -->
        {{ Form::open(['url' => '/member/matching/update', 'method' => 'post', 'id' => 'form', 'name' => 'form', 'files' => true]) }}
        {{ Form::considerRequest(true) }}
        {{ Form::hidden('id', $matching->id) }}
        {{ Form::hidden('company_id', Auth::user()->company->id) }}
        <div class="card-body">
            <table class='table table-bordered tbl-detail'>
                <tr>
                    <th>案件名 <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::text('project_name', $matching->project_name, ['class' => 'form-control pull-right', 'placeholder' => '案件名']) }}
                    </td>
                </tr>
                <tr>
                    <th>コメント <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::text('comment', $matching->comment, ['class' => 'form-control pull-right', 'placeholder' => 'コメント']) }}
                    </td>
                </tr>
                <tr>
                    <th>案件内容 <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::textarea('project_content', $matching->project_content, ['class' => 'form-control pull-right', 'placeholder' => '案件内容', 'rows' => 10]) }}
                    </td>
                </tr>
                <tr>
                    <th>カテゴリ <span class="badge badge-danger">必須</span></th>
                    <td style="width: 500px">
                        {!! Form::select('category_id[]', $categoryList, '', ['class' => 'pillbox']) !!}
                    </td>
                    <th>状態 <span class="badge badge-danger">必須</span></th>
                    <td>
                        {{ Form::select('status', config('const.matching.status_name'), $matching->status, ['class' => 'form-control', 'placeholder' => '選択してください']) }}
                    </td>
                </tr>
                <tr>
                    <th>予算</th>
                    <td>
                        {{ Form::text('budget', $matching->budget, ['class' => 'form-control pull-right', 'placeholder' => '予算']) }}
                    </td>
                    <th>希望納期 <span class="badge badge-danger">必須</span></th>
                    <td>
                        {{ Form::text('desired_delivery_date', $matching->desired_delivery_date, ['class' => 'form-control pull-right', 'placeholder' => '希望納期']) }}
                    </td>
                </tr>
                <tr>
                    <th>打合せ方法</th>
                    <td colspan="3">
                        {{ Form::text('meeting_method', $matching->meeting_method, ['class' => 'form-control pull-right', 'placeholder' => '打合せ方法']) }}
                    </td>
                </tr>
                <tr>
                    <th>受付期間 <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::text('disp_start_date', $matching->showDispStartDate(), ['class' => 'form-control  form-control-inline pull-right date-picker', 'placeholder' => 'YYYY/MM/DD', 'pattern' => '\d{4}/\d{2}/\d{2}']) }}
                        ～
                        {{ Form::text('disp_end_date', $matching->showDispEndDate(), ['class' => 'form-control  form-control-inline pull-right date-picker', 'placeholder' => 'YYYY/MM/DD', 'pattern' => '\d{4}/\d{2}/\d{2}']) }}
                    </td>
                </tr>
                <tr>
                    <th>担当者名 <span class="badge badge-danger">必須</span></th>
                    <td>
                        {{ Form::text('responsible_name', $matching->responsible_name, ['class' => 'form-control pull-right', 'placeholder' => '担当者名']) }}
                    </td>
                    <th>担当者部署名</th>
                    <td>
                        {{ Form::text('department', $matching->department, ['class' => 'form-control pull-right', 'placeholder' => '担当者部署名']) }}
                    </td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>
                        {{ Form::text('tel', $matching->tel, ['class' => 'form-control pull-right', 'placeholder' => '電話番号(ハイフンあり)']) }}
                    </td>
                    <th>メールアドレス <span class="badge badge-danger">必須</span></th>
                    <td>
                        {{ Form::text('mail', $matching->mail, ['class' => 'form-control pull-right', 'placeholder' => 'メールアドレス']) }}
                    </td>
                </tr>

            </table>
            <!-- /.table -->

            <table class='table table-bordered tbl-detail mt-5 images-table'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>画像</th>
                        <th></th>
                        <th>画像説明文</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 4; $i++)
                        @php
                            if (isset($imageInfos[$i])) {
                                $no = $imageInfos[$i]->no;
                                $id = $imageInfos[$i]->id;
                                $altText = $imageInfos[$i]->alt_text;
                                $imageName = $imageInfos[$i]->image_name;
                                $imageUrl = $imageInfos[$i]->image_url;
                            } else {
                                $no = $i;
                                $id = null;
                                $altText = '';
                                $imageName = '';
                                $imageUrl = '';
                            }
                        @endphp
                        <tr>
                            <td>
                                {{ Form::hidden('imageInfo[' . $i . '][no]', $no) }}
                                {{ Form::hidden('imageInfo[' . $i . '][id]', $id) }}
                                {{ $i + 1 }}
                            </td>
                            <td>
                                @if ($imageUrl != '')
                                    <img src="{{ asset($imageUrl) }}">
                                @endif
                            </td>
                            <td>
                                {{ Form::file('imageInfo[' . $i . '][photo]', ['id' => 'file', 'accept' => '.jpeg,.png,.jpg']) }}<br>
                                @if ($imageName != '')
                                    現在のファイル：{{ $imageName }}
                                @endif
                            </td>
                            <td>
                                {{ Form::text('imageInfo[' . $i . '][alt_text]', $altText, ['class' => 'form-control pull-right', 'placeholder' => 'コメント']) }}
                            </td>
                            <td>
                                @if (isset($id))
                                    <button type="button" class="btn btn-outline-danger float-center"
                                        onclick="dataDelete(event, '{{ url('/member') }}/matching/image-delete/{{ $id }}', '#form', 'post');">削除</button>
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <!-- /.table -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            @if ($matching->id)
                <button type="button" class="btn btn-danger float-left delete"
                    onclick="dataDelete(event, '{{ url('/member') }}/matching/delete/{{ $matching->id }}', '#form', 'post');">削除</button>
            @endif
            <button id="save-button" type="submit" class="btn btn-primary float-right">保存</button>
            <a href="{{ url('/member') }}/matching" class="btn btn-secondary float-right mr-2">戻る</a>
        </div>
        {{ Form::close() }}
        <!-- /.card-footer -->

    </div>
    <!-- /.card -->

@stop
@section('script')
    <script>
        var data = null;
        data = @json(old('category_id')) ? @json(old('category_id')) : @json(null);
        if (data == null) {
            data = @json($selectCategories);
        }
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
