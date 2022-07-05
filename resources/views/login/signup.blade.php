<!DOCTYPE html>
<html lang="ja">
@include('config')

<head>
    @include('common.head')
    <title>会員登録画面 / 掲示板クローン</title>
    <meta name="description" content="会員登録画面です">
</head>

<body class="signup text-center">
    <main class="form-signup">
        <form name="myform" action="sign" method="post" enctype="multipart/form-data" onsubmit="return cancelsubmit()">
            @csrf
            <img src="/TwitterClone/Views/img/logo-white.svg" alt="" class="logo-white">
            <h1>アカウントを作る</h1>
            <input type="text" class="form-control" name="nickname" autocomplete="off" placeholder="ニックネーム" maxlength="50" required autofocus>
            <input type="text" class="form-control" name="name" autocomplete="off" placeholder="ユーザー名、例)techis132" maxlength="50" required>
            <div class="mb-0">
                <input type="file" name="image" class="form-control form-control-sm">
            </div>
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="254" required>
            <input type="password" class="form-control" name="password" placeholder="パスワード" minlength="4" maxlength="128" required>
            <button class="form-control" type="submit">登録する</button>
            <P>{{$msg}}</P>
            @if($link)
            <p class="mt-3 mb-2"><a href="login">ログインする</a></p>
            @endif
            <p>すでに登録済みの方は<a href="login">こちら</a></p>
            <p class="mt-2 mb-3 text-muted">&copy; 2022</p>
        </form>
    </main>
    <script>
        // document.myform.btn.addEventListener('click', function() {
        // cancelsubmitでformと連動させてキャンセルがクリックされたらfalseにして送信させないようにしている。
        function cancelsubmit() {
            var result = window.confirm('送信しても宜しいですか？');
            if (result) {
                console.log('OKがクリックされました');
            } else {
                console.log('キャンセルがクリック');
                // キャンセルが押された際に入力したものを全てリセットしている。
                document.myform.reset();
                return false;
            }
        }
    </script>
</body>

</html>