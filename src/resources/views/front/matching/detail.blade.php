@extends('layouts.front')
@section('title', '案件詳細')
@section('content')

    <div class="top-space"></div>
    <section class="index-search is-terms">
        <div class="container">
            <h2 class="sub-title"><span>案件情報</span></h2>
            <p class="sub-title-text">{{ $matching->company_name }}</p>
            <section class="company-matching-info">
                <h3 class="sub-title under">案件名</h3>
                <div class="inner big">
                    {{ $matching->project_name }}
                </div>
                <h3 class="sub-title under">案件内容</h3>
                <div class="inner big">
                    {!! nl2br(e($matching->project_content)) !!}
                </div>
            </section>
            <section class="company-matching-info">
                <div class="inner">
                    <div class="company-matching-info-flex flex flex-stretch">
                        <div class="flex-clm">
                            <h3 class="sub-title">案件詳細</h3>
                            <table class="table-col">
                                <tbody>
                                    <tr>
                                        <th scope="row">希望納期</th>
                                        <td>{{ $matching->desired_delivery_date }}</td>
                                    </tr>
                                    @if (isset($matching->budget))
                                        <tr>
                                            <th scope="row">予算</th>
                                            <td>{{ $matching->budget }}</td>
                                        </tr>
                                    @endif
                                    @if (isset($matching->meeting_method))
                                        <tr>
                                            <th scope="row">打合せ方法</th>
                                            <td>{{ $matching->meeting_method }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th scope="row">受付期間</th>
                                        <td>{{ $matching->showDispStartDate() }} ～ {{ $matching->showDispEndDate() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">状態</th>
                                        <td>{{ $matching->status_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">カテゴリ</th>
                                        <td>{{ $matching->category_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">コメント</th>
                                        <td>{{ $matching->comment }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h3 class="sub-title staffs">会社情報</h3>
                            <table class="table-col">
                                <tbody>
                                    <tr>
                                        <th scope="row">会社名</th>
                                        <td><a href="{{ url('/') }}/company/detail/{{ $matching->company_id }}">{{ $matching->company_name }}</a></td>
                                    </tr>
                                    @if (isset($matching->department))
                                        <tr>
                                            <th scope="row">担当者部署</th>
                                            <td>{{ $matching->department }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th scope="row">担当者</th>
                                        <td>{{ $matching->responsible_name }}</td>
                                    </tr>
                                    @if (isset($matching->tel))
                                        <tr>
                                            <th scope="row">ＴＥＬ</th>
                                            <td>{{ $matching->tel }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th scope="row">メールアドレス</th>
                                        <td><a href="mailto:{{ $matching->mail }}">{{ $matching->mail }}</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex-clm image">
                            <div>
                                <img id="zoom-img" src="{{ asset($matching->first_image_url) }}"
                                    alt="{{ $matching->first_alt_text }}">
                            </div>
                            <div>
                                <ul class="clearfix">
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
                                        @if ($imageUrl != '') <li>
                                        <img id="zoom-thumb-img" src="{{ asset($imageUrl) }}"
                                        alt="{{ $altText }}"
                                        onClick="changeImage('{{ asset($imageUrl) }}');">
                                        </li> @endif
                                    @endfor
                                </ul>
                            </div>
                            @if (count($imageInfos) > 1)
                                <p class="note">※クリックすると拡大画像をご覧いただけます。</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="btn-holder">
                    <a href="mailto:{{ $matching->mail }}" class="btn btn-blue contact">お問い合わせはこちら</a>
                </div>
            </section>
            <div class="btn-back">
                <a href="/matching" class="btn btn-white">もどる</a>
            </div>
        </div>
    </section>
@stop
