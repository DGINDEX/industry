@extends('layouts.member')
@section('title', '企業管理')
@section('page_category', '企業管理')
@section('page_detail', '詳細')
@section('active_menu_parent', 'company')
@section('active_menu_child', 'list')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">詳細情報</h3>
        </div>
        <!-- /.card-header -->
        {{ Form::open(['url' => '/member/update', 'method' => 'post', 'id' => 'form', 'name' => 'form', 'files' => true]) }}
        {{ Form::considerRequest(true) }}
        {{ Form::hidden('id', $company->id) }}
        {{ Form::hidden('user_id', $company->user_id) }}
        {{ Form::hidden('status', $company->status) }}
        <div class="card-body">
            <table class='table table-bordered tbl-detail'>
                <tr>
                    <th>No.</th>
                    <td colspan="3">{{ $company->id }}</td>
                </tr>
                <tr>
                    <th>会社名 <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::text('company_name', $company->company_name, ['class' => 'form-control pull-right', 'placeholder' => '会社名']) }}
                    </td>
                </tr>
                <tr>
                    <th>会社名カナ <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::text('company_name_kana', $company->company_name_kana, ['class' => 'form-control pull-right', 'placeholder' => '会社名カナ']) }}
                    </td>
                </tr>
                <tr>
                    <th>ログイン用メールアドレス <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::text('login_id', $company->login_id, ['class' => 'form-control pull-right', 'placeholder' => 'ログイン用メールアドレス']) }}
                    </td>
                </tr>
                <tr>
                    <th>パスワード <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::text('plain_login_password', $company->login_password, ['class' => 'form-control pull-right', 'placeholder' => 'パスワード']) }}
                    </td>
                </tr>
                <tr>
                    <th>郵便番号 <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {!! Form::text('zip', $company->zip, ['class' => 'form-control form-control-inline', 'placeholder' => 'XXX-XXXX', 'id' => 'zip']) !!}
                        <button type="button" id="zip_btn" class="btn btn-success">住所取得</button>
                    </td>
                </tr>
                <tr>
                    <th>都道府県 <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::select('pref_code', config('const.pref'), $company->pref_code, ['class' => 'form-control', 'placeholder' => '選択してください']) }}
                    </td>
                </tr>
                <tr>
                    <th>住所 <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::text('address', $company->address, ['class' => 'form-control', 'placeholder' => '住所', 'id' => 'address']) }}
                    </td>
                </tr>
                <tr>
                    <th>電話番号 <span class="badge badge-danger">必須</span></th>
                    <td>
                        {{ Form::text('tel', $company->tel, ['class' => 'form-control', 'placeholder' => '電話番号(ハイフンあり)']) }}
                    </td>
                    <th>FAX番号</th>
                    <td>
                        {{ Form::text('fax', $company->fax, ['class' => 'form-control', 'placeholder' => 'FAX番号(ハイフンあり)']) }}
                    </td>
                </tr>
                <tr>
                    <th>ホームページURL</th>
                    <td colspan="3">
                        {{ Form::text('hp_url', $company->hp_url, ['class' => 'form-control', 'placeholder' => 'ホームページURL']) }}
                    </td>
                </tr>
                <tr>
                    <th>代表者名 <span class="badge badge-danger">必須</span></th>
                    <td>
                        {{ Form::text('representative_name', $company->representative_name, ['class' => 'form-control', 'placeholder' => '代表者名']) }}
                    </td>
                    <th>従業員数</th>
                    <td>
                        {{ Form::text('employees_num', $company->employees_num, ['class' => 'form-control form-control-inline pull-right', 'placeholder' => '従業員数']) }}
                        人
                    </td>
                </tr>
                <tr>
                    <th>創立年月日</th>
                    <td>
                        {{ Form::text('founding_date', $company->showFoundingDate(), ['class' => 'form-control pull-right', 'placeholder' => 'YYYY/MM/DD', 'pattern' => '\d{4}/\d{2}/\d{2}']) }}
                    </td>
                    <th>業種 <span class="badge badge-danger">必須</span></th>
                    <td>
                        {{ Form::select('industry_id', config('const.company.industry_name'), $company->industry_id, ['class' => 'form-control pull-right', 'placeholder' => '選択してください']) }}
                    </td>
                </tr>
                <tr>
                    <th>カテゴリ <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::select('category_id[]', $categoryList, null, ['class' => 'pillbox']) }}
                    </td>
                </tr>
                <tr>
                    <th>事業内容</th>
                    <td colspan="3">
                        {{ Form::text('business_content', $company->business_content, ['class' => 'form-control pull-right', 'placeholder' => '事業内容']) }}
                    </td>
                </tr>
                <tr>
                    <th>紹介文</th>
                    <td colspan="3">
                        {{ Form::textarea('comment', $company->comment, ['class' => 'form-control pull-right', 'placeholder' => '紹介文', 'rows' => 10]) }}
                    </td>
                </tr>
                <tr>
                    <th>担当者名 <span class="badge badge-danger">必須</span></th>
                    <td>
                        {{ Form::text('responsible_name', $company->responsible_name, ['class' => 'form-control pull-right', 'placeholder' => '担当者名']) }}
                    </td>
                    <th>担当者部署名</th>
                    <td>
                        {{ Form::text('department', $company->department, ['class' => 'form-control pull-right', 'placeholder' => '担当者部署名']) }}
                    </td>
                </tr>
                <tr>
                    <th>お問い合わせ用メールアドレス <span class="badge badge-danger">必須</span></th>
                    <td colspan="3">
                        {{ Form::text('mail', $company->mail, ['class' => 'form-control pull-right', 'placeholder' => 'メールアドレス']) }}
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
                                {{ Form::textarea('imageInfo[' . $i . '][alt_text]', $altText, ['class' => 'form-control pull-right', 'placeholder' => 'コメント', 'rows' => 5]) }}
                            </td>
                            <td>
                                @if (isset($id))
                                    <button type="button" class="btn btn-outline-danger float-center"
                                        onclick="dataDelete(event, '{{ url('/member') }}/image-delete/{{ $id }}', '#form', 'post');">削除</button>
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <!-- /.table -->

        </div>
        <div class="card-footer">
            <button id="save-button" type="submit" class="btn btn-primary float-right">保存</button>
        </div>
        {{ Form::close() }}
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
@stop
@section('script')
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <script src="{{ asset('/js/address.js') }}"></script>
    <script>
        var data = null;
        data = @json(old('category_id')) ? @json(old('category_id')) : @json(null);
        if (data == null) {
            data = @json($categories);
        }
        var array = [];

        if (data != null && data.length != 0) {
            for (let i = 0; i < data.length; i++) {
                array.push(data[i]);
            }
            $(".pillbox").val(array).trigger("change");

        } else {
            $('.pillbox').val(null).trigger('change');
        }

    </script>
@stop
