@extends('layouts.app')
@include('config')

@section('main')
@section('title','プロフィール画面 / Twitterクローン')
@foreach($nickname as $nick)
<div class="main-header">
    <h1>ようこそ{{$nick}}さん・プロフィール編集画面へ</h1>
</div>

<div class="profile-area">
    <div class="top">
        @foreach($image as $images)
        @foreach($name as $names)
        <div class="user">
            <img src="{{ asset('storage/icon/' . $images) }} " />
        </div>
        @endforeach

        @if (isset($_GET['user_id']))
        <!-- 他人のプロフィール -->
        @if (isset($_GET['case']))
        <button class="btn btn-sm">フォローを外す</button>
        @else
        <button class="btn btn-sm btn-reverse">フォローする</button>
        @endif
        @else
        <!-- 自分のプロフィール -->
        <button class="btn btn-reverse btn-sm js-modal-button" type="submit" data-bs-toggle="modal" data-bs-target="#js-modal">プロフィール編集</button>

        <div class="modal fade" id="js-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="profile" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">プロフィールを編集</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @foreach($image as $images)
                            <div class="user">
                                <img src="{{ asset('storage/icon/' . $images) }} " />
                            </div>
                            @endforeach
                            <div class="mb-3">
                                <label class="mb-1">プロフィール写真</label>
                                <input type="file" class="form-control form-control-sm" name="image">
                            </div>

                            <input type="text" class="mb-4 form-control" name="nickname" maxlength="50" value="{{$nick}}" placeholder="ニックネーム" required>
                            <input type="text" class="mb-4 form-control" name="name" maxlength="50" value="{{$names}}" placeholder="ユーザー名" required>
                            @foreach($email as $user_email)
                            <input type="email" class="mb-4 form-control" name="email" maxlength="254" value="{{$user_email}}" placeholder="メールアドレス" required>
                            @endforeach
                            <input type="password" class="mb-4 form-control" name="password" minlength="4" maxlength="128" value="" placeholder="パスワード変更する場合ご入力ください">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-reverse" data-bs-dismiss="modal">キャンセル</button>
                            <button class="btn" type="submit">保存する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="name">{{$nick}}</div>
    <div class="text-muted">{{'@'.$names}}</div>

    <div class="follow-follower">
        <div class="follow-count">1</div>
        <div class="follow-text">フォロー中</div>
        <div class="follow-count">1</div>
        <div class="follow-text">フォロワー</div>
    </div>
</div>
@endforeach
@endforeach
<div class="ditch"></div>

@if (empty($view_tweets))
<p class="p-3">ツイートがまだありません</p>
@else
<div class="tweet-list">
    @foreach ($view_tweets as $view_tweet)
    @include('common.tweet')
    @endforeach
</div>
@endif
@endsection