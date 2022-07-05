///////////////////////////////////////
// いいね！用のJavaScript
///////////////////////////////////////
// ★jsでのエラーが発生した時のエラー内容の確認の仕方
// F12で検証ツールでnetworkでfilterの右側のallを選択する。左下の開いているファイルを開いてpereviewでエラーの中身を確認する。
// f12で検証ツールでconsoleでエラーの中身を開いてresponseJSON:のmessageを見ても確認できる。

$(function () {
    // いいね！がクリックされたとき
    $('.js-like').click(function () {
        const this_obj = $(this);
        const tweet_id = $(this).data('tweet-id');
        const like_id = $(this).data('like-id');
        const like_count_obj = $(this).parent().find('.js-like-count');
        let like_count = Number(like_count_obj.html());
    //    @csrfの役割をしている。これは絶対必要laravelでpostする際に本来blead等には@csrfを入れる。jsは入れれないので下記の表記をする。
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log(like_id);
        if (like_id) {
            // いいね！取り消し
            // 非同期通信
            $.ajax({
                // ここのurlはhttp://127.0.0.1:8000/profileみたいに記述する。laravelなので
                url: '/like',
                type: 'POST',
                // ここでdataに入れた物をlikeコントローラに送る。
                data: {
                    'like_id': like_id
                },
                timeout: 10000
            })
                // 取り消しが成功
                .done(() => {
                    // いいね！カウントを減らす
                    like_count--;
                    like_count_obj.html(like_count);
                    this_obj.data('like-id', null);
                    // console.log(data);
                    // いいね！ボタンの色をグレーに変更
                    $(this).find('img').attr('src', '/icon/img/icon-heart.svg');
                })
                .fail((data) => {
                    alert('いいね取り消しの際にエラー発生。');
                    console.log(data);
                });
        } else {
            // いいね！付与
            // 非同期通信
            $.ajax({
                url: '/like',
                type: 'POST',
                data: {
                    'tweet_id': tweet_id
                },
                timeout: 10000
            })
                // いいね！が成功
                .done((data) => {
                    // いいね！カウントを増やす
                    console.log(data);
                    like_count++;
                    like_count_obj.html(like_count);
                    this_obj.data('like-id', data['like_id']);
                    // console.log(data);
                    // いいね！ボタンの色を青に変更
                    $(this).find('img').attr('src', '/icon/img/icon-heart-twitterblue.svg');
                })
                .fail((data) => {
                    alert('いいねの際にエラーが発生。');
                    console.log(data);
                });
        }
    });
})