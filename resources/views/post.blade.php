@include('config')
@extends('layouts.app')
@section('title','つぶやく画面 / Twitterクローン')
@section('main')
<div class="main-header">
    <h1>つぶやく</h1>
</div>

<!-- つぶやき投稿エリア -->
<div class="tweet-post">
    <div class="my-icon">
        <img src="/icon/img_uploaded/user/sample-person.jpg" alt="">
    </div>
    <div class="input-area">
        <form action="post.php" method="post" enctype="multipart/form-data">
            <textarea name="body" placeholder="いまどうしてる？" maxlength="140"></textarea>
            <div class="bottom-area">
                <div class="mb-0">
                    <input type="file" name="image" class="form-control form-control-sm">
                </div>
                <button class="btn" type="submit">つぶやく</button>
            </div>
        </form>
    </div>
</div>

<!-- 仕切りエリア -->
<div class="ditch"></div>
</div>
</div>
@endsection