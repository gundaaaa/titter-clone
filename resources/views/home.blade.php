@extends('layouts.app')
<?php

///////////////////////////////////////
// ツイート一覧
///////////////////////////////////////
// $view_tweets = [
//     [
//         'user_id' => 1,
//         'user_name' => 'taro',
//         'user_nickname' => '太郎',
//         'user_image_name' => 'kyousyu.jpg',
//         'tweet_body' => '今プログラミングをしています。',
//         'tweet_image_name' => null,
//         'tweet_created_at' => '2022-02-15 16:00:00',
//         'like_id' => null,
//         'like_count' => 0,
//     ],
//     [
//         'user_id' => 2,
//         'user_name' => 'jiro',
//         'user_nickname' => '次郎',
//         'user_image_name' => null,
//         'tweet_body' => 'newデザイン！',
//         'tweet_image_name' => 'win1280.jpg',
//         'tweet_created_at' => '2022-02-25 18:00:00',
//         'like_id' => 1,
//         'like_count' => 1,
//     ],
// ];

?>
@section('title','ホーム画面 / Twitterクローン')
@section('main')
@foreach($nickname as $nick)
@foreach($name as $names)
<div class="main-header">
    <h1>ようこそ{{$nick}}さん</h1>
    <P>{{$msg}}</P>
</div>
<div class="tweet-post">
    <div class="my-icon">
        @foreach($image as $images)
        <img src="{{ asset('storage/icon/' . $images) }}" />
        @endforeach
        <!-- <img src="/icon/img_uploaded/user/kyousyu.jpg" alt=""> -->
    </div>
    <div class="input-area">
        <!-- ファイルをアップロードする際は enctype="multipart/form-data"を入れおく。-->
        <form action="home" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_image"  value="{{$images}}"class="form-control form-control-sm">
            <input type="hidden" class="form-control" name="nickname" value="{{$nick}}" placeholder="ニックネーム" maxlength="50" required autofocus>
            <input type="hidden" class="form-control" name="name" value="{{$names}}" placeholder="ユーザー名" maxlength="50" required>
            <textarea name="body" placeholder="いまどうしてる？" maxlength="140"></textarea>
            <div class="bottom-area">
                <div class="mb-0">
                    <input type="file" name="image" class="form-control form-control-sm">
                </div>
                <button class="btn" type="submit">つぶやく</button>
            </div>
            @endforeach
            @endforeach
        </form>
    </div>
</div>
<div class="ditch"></div>

@if (empty($view_tweets) )
<p class="p-3">ツイートがまだありません</p>
@else
<div class="tweet-list">
    @foreach( $view_tweets as $view_tweet )
    @include('common.tweet')
    @endforeach
</div>
@endif
@endsection