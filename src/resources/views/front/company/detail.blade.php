@extends('layouts.front')
@section('title', '企業詳細')
@section('content')

    <div class="top-space"></div>
    <section class="index-search is-terms">
        <div class="container">
            <h2 class="sub-title"><span>企業情報</span></h2>
            <p class="sub-title-text">{{ $company->company_name }}</p>

            <section class="company-matching-info">
                <div class="container">
                    <div class="inner">
                        <div class="company-matching-info-flex flex flex-stretch">
                            <div class="flex-clm">
                                <h3 class="sub-title">企業詳細</h3>
                                <table class="table-col">
                                    <tbody>
                                        <tr>
                                            <th scope="row">No.</th>
                                            <td>{{ $company->id }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">会社名</th>
                                            <td>{{ $company->company_name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">所在地</th>
                                            <td>{{ $company->pref_name }}{{ $company->address }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ＴＥＬ</th>
                                            <td>{{ $company->tel }}</td>
                                        </tr>
                                        @if (isset($company->fax))
                                            <tr>
                                                <th scope="row">ＦＡＸ</th>
                                                <td>{{ $company->fax }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="row">代表者名</th>
                                            <td>{{ $company->representative_name }}</td>
                                        </tr>
                                        @if (isset($company->founding_date))
                                            <tr>
                                                <th scope="row">創立年月日</th>
                                                <td>{{ $company->showFoundingDate() }}</td>
                                            </tr>
                                        @endif
                                        @if (isset($company->employees_num))
                                            <tr>
                                                <th scope="row">従業員数</th>
                                                <td>{{ $company->employees_num }}人</td>
                                            </tr>
                                        @endif
                                        @if (isset($company->business_content))
                                            <tr>
                                                <th scope="row">事業内容</th>
                                                <td>{{ $company->business_content }}</td>
                                            </tr>
                                        @endif
                                        @if (isset($company->hp_url))
                                            <tr>
                                                <th scope="row">ホームページ</th>
                                                <td><a href="{{ $company->hp_url }}" target="_blank"
                                                        rel="noopener noreferrer">{{ $company->hp_url }}</a></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="row">カテゴリ</th>
                                            <td>{{ $company->category_name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">業種</th>
                                            <td>{{ $company->industry_name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h3 class="sub-title staffs">担当者情報</h3>
                                <table class="table-col">
                                    <tbody>
                                        @if (isset($company->department))
                                            <tr>
                                                <th scope="row">担当者部署</th>
                                                <td>{{ $company->department }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="row">担当者</th>
                                            <td>{{ $company->responsible_name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">メールアドレス</th>
                                            <td>{{ $company->mail }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex-clm image">
                                <div>
                                    <img id="zoom-img" src="{{ asset($company->first_image_url) }}"
                                        alt="{{ $company->first_alt_text }}">
                                </div>
                                <div>
                                    <ul class="clearfix">
                                        @for ($i = 0; $i < 4; $i++)
                                            @php
                                                if (isset($imageInfos[$i])) {
                                                    $no = $imageInfos[$i]->no;
                                                    $id = $imageInfos[$i]->id;
                                                    $altText = str_replace(array("\r\n", "\r", "\n"), '', $imageInfos[$i]->alt_text);
                                                    $altTextBr = str_replace(array("\r\n", "\r", "\n"), '<br />', $imageInfos[$i]->alt_text);
                                                    $imageName = $imageInfos[$i]->image_name;
                                                    $imageUrl = $imageInfos[$i]->image_url;
                                                } else {
                                                    $no = $i;
                                                    $id = null;
                                                    $altText = '';
                                                    $altTextBr = '';
                                                    $imageName = '';
                                                    $imageUrl = '';
                                                }
                                            @endphp
                                            @if ($imageUrl != '') <li>
                                            <img id="zoom-thumb-img" src="{{ asset($imageUrl) }}"
                                            alt="{{ $altText }}"
                                            onClick="changeImage('{{ asset($imageUrl) }}','{{ $altTextBr }}');">
                                            </li> @endif
                                        @endfor
                                    </ul>
                                </div>
                                @if (count($imageInfos) > 1)
                                    <p class="note">※クリックすると拡大画像をご覧いただけます。</p>
                                @endif
                                @if (count($imageInfos) > 0 && (isset($imageInfos[0]->alt_text) || $imageInfos[0]->alt_text != ''))
                                    <div class="image-comment"><p id="image-text">{!! nl2br(e($imageInfos[0]->alt_text)) !!}</p></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if (isset($company->comment))
                <section class="company-matching-info">
                    <div class="inner big">
                        {!! nl2br(e($company->comment)) !!}
                    </div>
                </section>
            @endif

            <section class="company-matching-info">
                <div class="inner">
                    <!-- GOOGLE MAP -->
                    <div id="map">
                        <iframe
                            src="{{$ssl}}://maps.google.co.jp/maps?&output=embed&q={{ $company->address . $company->company_name }}"></iframe>
                    </div>
                    <!-- // GOOGLE MAP -->
                </div>
            </section>

            <div class="btn-back">
                <a href="/company" class="btn btn-white">もどる</a>
            </div>
        </div>
    </section>
@stop
