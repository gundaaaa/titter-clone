<!DOCTYPE html>
<html lang="ja">

<head>
    @include('common.head')
    <title>@yield('title')</title>
    <meta name="description" content="ホーム画面です">
</head>

<body class="home">
    {{-- <img src="/icon/img_uploaded/user/sample-person.jpg" alt=""> --}}
    <div class="container">
        @include('common.side')

        <div class="main">
            @yield('main')
        </div>
    </div>

    @include('common.foot')
</body>

</html>