@include('config')
@extends('layouts.app')
<?php
[
    [
        'user_nickname' => '太郎',
        'user_image_name' => 'sample-person.jpg',
        'tweet_body' => '今プログラミングをしています。',
        'tweet_image_name' => null,
        'tweet_created_at' => '2021-03-15 14:00:00',
        'like_id' => null,
        'like_count' => 0,
    ],

    [
        'user_id' => 2,
        'user_name' => 'jiro',
        'user_nickname' => '次郎',
        'user_image_name' => null,
        'tweet_body' => 'コワーキングスペースをオープンしました！',
        'tweet_image_name' => 'sample-post.jpg',
        'tweet_created_at' => '2021-03-14 14:00:00',
        'like_id' => 1,
        'like_count' => 1,
    ]
];

?>
@section('title','検索画面 / Twitterクローン')
@section('main')

<body class="home">
    <div class="container">
        <div class="main">
            <div class="main-header">
                <h1>検索</h1>
            </div>

            <!-- 検索エリア -->
            <form action="search" method="get">
                <div class="search-area">
                    <input type="text" class="form-control" placeholder="キーワード検索" name="keyword" value="">
                    <button type="submit" class="btn">検索</button>
                </div>
            </form>

            <!-- 仕切りエリア -->
            <div class="ditch"></div>

            <!-- つぶやき一覧エリア -->
            @if (empty($view_tweets))
                <p class="p-3">ツイートがありません</p>
             @else
                <div class="tweet-list">
                @foreach ($view_tweets as $view_tweet)
                        @include('common.tweet')
             @endforeach
                </div>
            @endif
        </div>
    </div>
    @endsection