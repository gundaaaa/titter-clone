<!DOCTYPE html>
<html lang="ja">
@include('config')
<head>

    @include('common.head')
    <title>ログイン画面 / 投稿掲示板</title>
    <meta name="description" content="ログイン画面です">
</head>

<body class="signup text-center">
    @csrf
    <main class="form-signup">
        <form action="login" method="post">
            @csrf
            <img src="/TwitterClone/Views/img/logo-white.svg" alt="" class="logo-white">
            <h1>掲示板にログイン</h1>
            <input type="email" class="form-control" name="email"  placeholder="メールアドレス" required autofocus>
            <!-- autocompleteをoffにすると打った文字の履歴が残らない -->
            <input type="password" class="form-control" name="password" autocomplete="off" placeholder="パスワード" required>
            <button class="w-100" type="submit">ログイン</button>
            <p>{{$msg}}</p>
            <p class="mt-3 mb-2"><a href="sign">会員登録する</a></p>
            <p class="mt-2 mb-3 text-muted">&copy; 2022</p>
        </form>
    </main>
</body>

</html>