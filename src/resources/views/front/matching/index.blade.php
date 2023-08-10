@extends('layouts.front')
@section('title', '案件一覧')
@section('content')

    <section class="search-condition">
        <div class="top-space"></div>
        <h2 class="sub-title"><span>案件を探す</span></h2>
        <div class="search-area">
            <div class="container">
                {{ Form::open(['url' => '/matching', 'method' => 'get', 'id' => 'form']) }}
                {{ Form::considerRequest(true) }}
                <div class="inputs suggest-wrapper">
                    <div class="input-item">
                        <div class="condition-input">
                            {!! Form::text('keyword', '', ['class' => 'form-control pull-right input-wrapper', 'placeholder' => 'キーワード']) !!}
                        </div>
                    </div>
                    <div class="input-item">
                        <div class="condition-input selector-wrapper">
                            {!! Form::select('category_id[]', $categoryList, '', ['class' => 'select-box input-wrapper', 'placeholder' => 'カテゴリを選択してください']) !!}
                        </div>
                    </div>
                    <div class="input-item">
                        <div class="condition-input selector-wrapper">
                            {!! Form::select('status', config('const.matching.front_status_name'), '', ['class' => 'select-box input-wrapper', 'placeholder' => '受付状態を選択してください']) !!}
                        </div>
                    </div>
                </div>
                <div class="btn-search-holder">
                    <button type="submit" class="btn btn-search"><i class="fas fa-search fa-position-right"></i>検索する</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </section>

    <section class="result-matching">
        <div class="container">
            <h2 class="sub-title"><span>案件一覧</span></h2>
            @if (isset($searchKey))
                <p class="sub-title-text">「{{ $searchKey }}」の検索結果</p>
            @endif

            <div class="count is-view">
                <div class="result-count">
                    <span class="unit">全</span>
                    <span class="val">{{ $matchingList->total() }}</span>
                    <span class="unit">件</span>
                </div>
            </div>

            @if (count($matchingList) != 0)
                @foreach ($matchingList as $item)
                    <div class="content">
                        <a href="{{ url('/') }}/matching/detail/{{ $item->id }}" class="content-link">
                            <h3 class="content-head">{{ $item->project_name }}</h3>
                            @php
                                if ($item->status == config('const.matching.status.accepting')) {
                                    $class = 'accepting';
                                } else {
                                    $class = '';
                                }
                            @endphp
                            <div class="ribbon-content">
                                <span class="ribbon {{ $class }}">{{ $item->status_name }}</span>
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
                <div class="pager">
                    {{ $matchingList->appends($conditions)->links() }}
                </div>
            @else
                <h2 class="no-result"><span>検索結果はありません</span></h2>
            @endif

            <div class="btn-back">
                <a href="/#search-match" class="btn btn-white">もどる</a>
            </div>
        </div>
    </section>

@stop
