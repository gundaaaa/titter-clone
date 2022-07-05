@include('config')
@extends('layouts.app')
@section('title','通知画面 / Twitterクローン')
@section('main')
<body class="home notification text-center">
    <div class="container">
        <div class="main">
            <div class="main-header">
                <h1>通知</h1>
            </div>

            <!-- 仕切りエリア -->
            <div class="ditch"></div>

            <!-- 通知一覧エリア -->
            <div class="notification-list">
                @if (isset($_GET['case']))
                    <p class="no-result">通知はまだありません。</p>
                @else 
                    <div class="notification-item">
                        <div class="user">
                            <img src="icon/img_uploaded/user/sample-person.jpg" alt="">
                        </div>
                        <div class="content">
                            <p>いいね！されました。</p>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="user">
                            <img src="icon/img_uploaded/user/sample-person.jpg" alt="">
                        </div>
                        <div class="content">
                            <p>フォローされました。</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endsection