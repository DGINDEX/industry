@extends('layouts.front')
@section('title', '企業一覧')
@section('content')

    <section class="search-condition">
        <div class="top-space"></div>
        <h2 class="sub-title"><span>企業を探す</span></h2>
        <div class="search-area">
            <div class="container">
                {{ Form::open(['url' => '/company', 'method' => 'get', 'id' => 'form']) }}
                {{ Form::considerRequest(true) }}
                <div class="inputs suggest-wrapper">
                    <div class="input-item">
                        <div class="condition-input two">
                            {!! Form::text('company_name', '', ['class' => 'form-control pull-right input-wrapper', 'placeholder' => '会社名']) !!}
                        </div>
                    </div>
                    <div class="input-item">
                        <div class="condition-input two selector-wrapper">
                            {!! Form::select('category_id[]', $categoryList, '', ['class' => 'select-box input-wrapper', 'placeholder' => 'カテゴリを選択してください']) !!}
                        </div>
                    </div>
                    {{-- <div class="input-item">
                        <div class="condition-input selector-wrapper">
                            {!! Form::select('industry_id', $industryList, '', ['class' => 'select-box input-wrapper', 'placeholder' => '業種を選択してください']) !!}
                        </div>
                    </div> --}}
                </div>
                <div class="btn-search-holder">
                    <button type="submit" class="btn btn-search"><i class="fas fa-search fa-position-right"></i>検索する</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </section>

    <section class="result-company">
        <div class="container">
            <h2 class="sub-title"><span>企業一覧</span></h2>
            @if (isset($searchKey))
                <p class="sub-title-text">「{{ $searchKey }}」の検索結果</p>
            @endif

            <div class="count is-view">
                <div class="result-count">
                    <span class="unit">全</span>
                    <span class="val">{{ $companyList->total() }}</span>
                    <span class="unit">件</span>
                </div>
            </div>

            @if (count($companyList) != 0)
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
                <div class="pager">
                    {{ $companyList->appends($conditions)->links() }}
                </div>
            @else
                <h2 class="no-result"><span>検索結果はありません</span></h2>
            @endif

            <div class="btn-back">
                <a href="/#search-company" class="btn btn-white">もどる</a>
            </div>

        </div>
    </section>
@stop
