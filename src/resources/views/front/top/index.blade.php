@extends('layouts.front')
@section('title', 'トップ')
@section('content')

    <div class="banner">
        <div class="banner-text">
            <h2 class="title">{{ config('app.name') }}</h2>
            <div class="banner-content">登録事業所データベース & ビジネスマッチング</div>
            <div class="btn-holder">
                <a href="#search-company" class="btn btn-white"><i class="fas fa-building fa-position-right"></i>企業を探す</a>
                <a href="#search-match" class="btn btn-white"><i class="fas fa-handshake fa-position-right"></i>案件を探す</a>
            </div>
        </div>
    </div>

    <section id="search-company" class="search-area">
        <div class="container">
            <h2 class="sub-title"><span>企業を探す</span></h2>
            <p class="sub-title-text">条件を指定</p>
            <div class="tabs">
                <input class="none" id="category" type="radio" name="tabs-title-company" checked="">
                {{-- <input class="none" id="industry" type="radio" name="tabs-title-company"> --}}
                <input class="none" id="syllabary" type="radio" name="tabs-title-company">
                <div class="search">
                    <ul class="search-tab">
                        <li><label id="category-tab" class="tabs-title" for="category">カテゴリ<br class="sp-br">で探す</label></li>
                        {{-- <li><label id="industry-tab" class="tabs-title" for="industry">業種別<br class="sp-br">で探す</label></li> --}}
                        <li><label id="syllabary-tab" class="tabs-title" for="syllabary">50音順<br class="sp-br">で探す</label></li>
                    </ul>
                </div>

                <div class="tabs-detail" id="category-content">
                    <ul class="search-items-lists flex">
                        @foreach ($categoryList as $key => $value)
                            <li class="search-items">
                                <a href="company?category_id%5B%5D={{ $key }}">
                                    {{ $value }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{-- <div class="tabs-detail" id="industry-content">
                    <ul class="search-items-lists flex">
                        @foreach ($industryList as $key => $value)
                            <li class="search-items">
                                <a href="company?industry_id={{ $key }}">
                                    {{ $value }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}
                <div class="tabs-detail" id="syllabary-content">
                    <div class="is-syllabary">
                        <ul class="search-items-lists flex">
                            <li class="title">
                                あ行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ア">
                                    あ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=イ">
                                    い
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ウ">
                                    う
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=エ">
                                    え
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=オ">
                                    お
                                </a>
                            </li>
                            <li class="title">
                                か行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=カ">
                                    か
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=キ">
                                    き
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ク">
                                    く
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ケ">
                                    け
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=コ">
                                    こ
                                </a>
                            </li>
                            <li class="title">
                                さ行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=サ">
                                    さ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=シ">
                                    し
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ス">
                                    す
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=セ">
                                    せ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ソ">
                                    そ
                                </a>
                            </li>
                            <li class="title">
                                た行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=タ">
                                    た
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=チ">
                                    ち
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ツ">
                                    つ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=テ">
                                    て
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ト">
                                    と
                                </a>
                            </li>
                            <li class="title">
                                な行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ナ">
                                    な
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ニ">
                                    に
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ヌ">
                                    ぬ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ネ">
                                    ね
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ノ">
                                    の
                                </a>
                            </li>
                            <li class="title">
                                は行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ハ">
                                    は
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ヒ">
                                    ひ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=フ">
                                    ふ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ヘ">
                                    へ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ホ">
                                    ほ
                                </a>
                            </li>
                            <li class="title">
                                ま行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=マ">
                                    ま
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ミ">
                                    み
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ム">
                                    む
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=メ">
                                    め
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=モ">
                                    も
                                </a>
                            </li>
                            <li class="title">
                                や行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ヤ">
                                    や
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ユ">
                                    ゆ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ヨ">
                                    よ
                                </a>
                            </li>
                            <li class="title">
                                ら行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ラ">
                                    ら
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=リ">
                                    り
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ル">
                                    る
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=レ">
                                    れ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ロ">
                                    ろ
                                </a>
                            </li>
                            <li class="title">
                                わ行
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ワ">
                                    わ
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ヲ">
                                    を
                                </a>
                            </li>
                            <li class="search-items syllabary-sub">
                                <a href="company?company_name_kana=ン">
                                    ん
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="result-company">
        <div class="container">
            <h2 class="sub-title"><span>企業一覧</span></h2>
            <ul>
                @foreach ($companyList as $item)
                    <li>
                        <a href="{{ url('/') }}/company/detail/{{ $item->id }}">
                            <div class="company-holder">
                                <div class="image-holder">
                                    <div class="back-grey">
                                        <img width="370" height="247" src="{{ asset($item->first_image_url) }}"
                                            alt="{{ $item->first_alt_txt }}" sizes="(max-width: 370px) 100vw, 370px">
                                        {{-- 業種をラベルで表示 --}}
                                        {{-- <p>{{ $item->industry_name }}</p> --}}
                                    </div>
                                </div>
                                <div class="description">
                                    <h2>
                                        <span>
                                            {{ $item->company_name }}
                                        </span>
                                    </h2>
                                    <div class="content-tags">
                                        @foreach ($item->companyCategories as $category)
                                            <div class="category">{{ $category->category_name }}</div>
                                        @endforeach
                                    </div>
                                    <p>{{ $item->business_content }}</p>
                                    <div class="btn-readmore">Read
                                        More</div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="btn-holder">
                <a href="/company" class="btn btn-white">すべて見る</a>
            </div>
        </div>
    </section>

    <section id="search-match" class="search-area">
        <div class="container">
            <h2 class="sub-title"><span>案件を探す</span></h2>
            <p class="sub-title-text">条件を指定</p>
            <div class="tabs">
                <input class="none" id="category-match" type="radio" name="tabs-title-match" checked="">
                <input class="none" id="keyword" type="radio" name="tabs-title-match">
                <div class="search">
                    <ul class="search-tab">
                        <li><label id="category-match-tab" class="tabs-title" for="category-match">カテゴリ<br
                                    class="sp-br">で探す</label></li>
                        <li><label id="keyword-tab" class="tabs-title" for="keyword">キーワード<br class="sp-br">で探す</label></li>
                    </ul>
                </div>

                <div class="tabs-detail" id="category-match-content">
                    <ul class="search-items-lists flex">
                        @foreach ($categoryList as $key => $value)
                            <li class="search-items">
                                <a href="matching?category_id%5B%5D={{ $key }}">
                                    {{ $value }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tabs-detail " id="keyword-content">
                    <div class="search-form">
                        {{ Form::open(['url' => '/matching', 'method' => 'get', 'id' => 'form']) }}
                        {{ Form::considerRequest(true) }}
                        <div class="search-form-out">
                            {{ Form::text('keyword', null, ['class' => 'form-control pull-right', 'placeholder' => 'キーワード']) }}
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
    </section>

    <section class="result-matching">
        <div class="container">
            <h2 class="sub-title"><span>案件一覧</span></h2>
            <div class="inner">
                @if (count($matchingList) != 0)
                    @foreach ($matchingList as $item)
                        <div class="content">
                            <a href="{{ url('/') }}/matching/detail/{{ $item->id }}" class="content-link">
                                <h3 class="content-head">{{ $item->project_name }}</h3>
                                <div class="ribbon-content">
                                    <span class="ribbon accepting">{{ $item->status_name }}</span>
                                </div>
                                <div class="content-tags">
                                    @foreach ($item->matchingCategories as $category)
                                        <div class="category">{{ $category->category_name }}</div>
                                    @endforeach
                                    <div>受付終了日：{{ $item->showDispEndDate() }}</div>
                                </div>
                                <p class="content-desc">
                                    {{ $item->comment }}
                                </p>
                                <div class="btn-readmore">Read
                                    More</div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <h2 class="no-result"><span>現在受付中の<br class="sp-br">案件はありません</span></h2>
                @endif
            </div>
            <div class="btn-holder">
                <a href="/matching" class="btn btn-white">すべて見る</a>
            </div>
    </section>
@stop
