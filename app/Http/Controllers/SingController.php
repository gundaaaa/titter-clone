<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Psy\VersionUpdater\IntervalChecker;
use InterventionImage;


class SingController extends Controller
{
    // ログイン画面
    public function log(Request $request)
    {
        // 指定したデータをセッションから削除する
        session()->forget('nickname');
        session()->forget('name');
        session()->forget('image');
        session()->forget('email');
        session()->forget('password');
        session()->forget('id');

        return view('login.signin', [
            'msg' => '',
        ]);
    }
    // ログインの際のコード
    public function  login(Request $request)
    {
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $count = DB::table('users')->where('email', $email)->get()->count();
        if ($count < 1) {
            return view('login.signin', [
                'msg' => 'アドレスが違います。再度入力お願いいます。'
            ]);
        }
        // メールアドレスが合っていたら下記のパスを取ってくる。
        // ここでidを取ってくる。
        $id = DB::table('users')->where('email', $email)->first('id');
        //★ 取ってきたIdがIdの中に1が入っているのでupデートする時とかにエラーが出てします。だから下の表記をしてidの数字のみを取ってきている。★
        $id = $id->id;
        $user = DB::table('users')->where('email', $email)->first('password');
        $nickname = DB::table('users')->where('email', $email)->first('nickname');
        $name = DB::table('users')->where('email', $email)->first('name');
        $image = DB::table('users')->where('email', $email)->first('image');
        $email = DB::table('users')->where('email', $email)->first('email');
        if (password_verify($pass, $user->password)) {
            session()->put('pass', password_verify($pass, $user->password));
            $request->session()->put('nickname', $nickname);
            $request->session()->put('name', $name);
            $request->session()->put('image', $image);
            $request->session()->put('email', $email);
            $request->session()->put('id', $id);
            // dd($id);
            return redirect('home');
        } else {
            return view('login.signin', [
                'msg' => 'ログインの承認に失敗しました。',
            ]);
        }
    }
    // 新規登録画面
    public function sin(Request $request)
    {
        return view('login.signup', [
            'msg' => '',
            'link' => '',
        ]);
    }
    // 新規登録のコード
    public function signup(Request $request)
    {
        $nickname = $_POST['nickname'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        //    アイコン画像の取り出し＆publicの中に保存
        $img = $request->image;
        $image = $img->getClientOriginalName();
        // dd($image);
        InterventionImage::make($img)
            ->resize(50, 50, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/icon/' . $image));

        // $dataの''の中身はデータベースの中身の名前と一緒にする。
        $data = [
            ['nickname' => $nickname, 'name' => $name, 'email' => $email, 'password' => $pass, 'image' => $image]
        ];
        // 同じメールアドレスが無いのかチェック
        $count = DB::table('users')->where('email', $email)->get()->count();
        if ($count > 0) {
            return view('login.signup', [
                'msg' => '同じメールアドレスが存在します。',
                'link' => '',
            ]);
        }
        $count = DB::table('users')->where('name', $name)->get()->count();
        if ($count > 0) {
            return view('login.signup', [
                'msg' => '同じユーザー名が存在ます。',
                'link' => '',
            ]);
        }
        $count = DB::table('users')->where('nickname', $nickname)->get()->count();
        if ($count > 0) {
            return view('login.signup', [
                'msg' => '同じニックネームが存在します。',
                'link' => ''
            ]);
        }
        // 同じ情報が無ければ登録できる。
        // 登録機能
        DB::table('users')->insert($data);
        return view('login.signup', [
            'msg' => '登録完了',
            'link' => '1',
        ]);
    }
    // ホーム画面
    public function home(Request $request)
    {
        $array = session()->get('pass');
        if (!empty($array)) {
            $nickname = session()->get('nickname');
            $name = session()->get('name');
            $image = session()->get('image');
            $id = session()->get('id');
            $query = <<<SQL
            SELECT
            -- tweetsをtの文字に変えたのでtの中に入っているカラムを呼び出している。
                T.id AS tweet_id,
                T.status AS tweet_status,
                -- T.user_name AS user_name,
                -- T.user_nickname AS user_nickname,
                -- T.user_image AS user_image,
                T.tweet_body AS tweet_body,
                T.tweet_image_name AS tweet_image_name,
                T.created_at AS updated_at,
                U.id AS user_id,
                U.nickname AS user_nickname,
                U.name AS user_name,
                U.image AS user_image,
                -- ログインユーザーがいいね！（している場合、値が入る）
                L.id AS like_id,
                -- いいね！数 tweet_id = T.idのT.idは一番↑のT.idと同じものを取って来ている。それをASでlike_countに変換している。
                (SELECT COUNT(*) FROM likes WHERE status = 'active' AND tweet_id = T.id) AS like_count
            FROM
            -- ここでtweetsテーブルとusersテーブルを紐づけている。ASはtweetsをtの文字に変えている。
                tweets AS T
                -- ユーザーテーブルをjpomで紐付ける
                JOIN
                users AS U ON U.id = T.user_id AND u.name = T.user_name AND U.image = T.user_image AND U.nickname = T.user_nickname AND U.status = 'active' 
                -- いいね！テーブルを紐付ける
                LEFT JOIN
                -- L.usr_id=＄idはログイン中のidとlikesテーブルのIDが＝である状態にしている。
                likes AS L ON L.tweet_id = T.id AND L.status = 'active' AND L.user_id = '$id'
            WHERE
                T.status = 'active'
        SQL;
        $item = DB::select($query);
            return view('home', [
                'msg' => "",
                'view_tweets' => $item,
                'nickname' => $nickname,
                'name' =>  $name,
                'image' => $image,
            ]);
        } else {
            return view('login.signin', [
                'msg' => 'ログインから一定時間が経過しています。再度ログインお願いします。'
            ]);
        }
        // $item = DB::select('select * from tweets');
    }
    // ホーム画面のつぶやき投稿のコード
    public function homes(Request $request)
    {
        $name = $_POST['name'];
        $nickname = $_POST['nickname'];
        $body = $_POST['body'];
        $user_image = $_POST['user_image'];
        // 下の動作で画像をファイル化してstorageのディレクトリーに保存している。
        // $image = $request->file('image')->store('public');
        // basenameで新たな名前を付けている。
        // $item = basename($image);
        // storeAsを使った場合はシンボリックリンクをする必要がある。storageのディレクトリに保存されるから。
        // $item = $request->image->storeAs('', $image, 'public');
        // 画像の元の名前を所得
        // 現在ログインしているuserのidを所得している。
        $user_id = session()->get('id');
        $img = $request->image;
        $image = $img->getClientOriginalName();
        // 画像のリサイズ方法＆storageのpublicに保存している。既にシンボリックリンクもできている。
        InterventionImage::make($img)
            ->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(storage_path('app/public/' . $image));

        $data = [
            ['user_id' => $user_id, 'user_name' => $name, 'user_nickname' => $nickname, 'user_image' => $user_image, 'tweet_body' => $body, 'tweet_image_name' => $image]
        ];
        $nickname = session()->get('nickname');
        $name = session()->get('name');
        $image = session()->get('image');

        DB::table('tweets')->insert($data);
        return view('home', [
            'msg' => '投稿しました',
            'nickname' => $nickname,
            'name' =>  $name,
            'image' => $image,
        ]);
    }
    // プロフィール画面
    public function profile(Request $request)
    {
        $array = session()->get('pass');
        if (!empty($array)) {
            $nickname = session()->get('nickname');
            $name = session()->get('name');
            $image = session()->get('image');
            $email = session()->get('email');
            $id = session()->get('id');
            // この下の文でlikesテーブルとusersテーブルを結合している。
            $query = <<<SQL
                SELECT
                -- tweetsをtの文字に変えたのでtの中に入っているカラムを呼び出している。
                    T.id AS tweet_id,
                    T.status AS tweet_status,
                    -- T.user_name AS user_name,
                    -- T.user_nickname AS user_nickname,
                    -- T.user_image AS user_image,
                    T.tweet_body AS tweet_body,
                    T.tweet_image_name AS tweet_image_name,
                    T.created_at AS updated_at,
                    U.id AS user_id,
                    U.nickname AS user_nickname,
                    U.name AS user_name,
                    U.image AS user_image,
                    -- ログインユーザーがいいね！（している場合、値が入る）
                    L.id AS like_id,
                    -- いいね！数 tweet_id = T.idのT.idは一番↑のT.idと同じものを取って来ている。それをASでlike_countに変換している。
                    (SELECT COUNT(*) FROM likes WHERE status = 'active' AND tweet_id = T.id) AS like_count
                FROM
                -- ここでtweetsテーブルとusersテーブルを紐づけている。ASはtweetsをtの文字に変えている。
                    tweets AS T
                    -- ユーザーテーブルをjpomで紐付ける
                    JOIN
                    users AS U ON U.id = T.user_id AND u.name = T.user_name AND U.image = T.user_image AND U.nickname = T.user_nickname AND U.status = 'active' 
                    -- いいね！テーブルを紐付ける
                    LEFT JOIN
                    -- L.usr_id=＄idはログイン中のidとlikesテーブルのIDが＝である状態にしている。
                    likes AS L ON L.tweet_id = T.id AND L.status = 'active' AND L.user_id = '$id'
                WHERE
                    T.status = 'active'
            SQL;
            $item = DB::select($query);
            // dd($item);
            // $item = DB::select('select *  from tweets');
            return view('profile', [
                'nickname' => $nickname,
                'image' => $image,
                'name' => $name,
                'email' => $email,
                'view_tweets' => $item,
            ]);
        } else {
            return view('login.signin', [
                'msg' => 'ログインから一定時間が経過しています。再度ログインお願いします。'
            ]);
        }
    }
    // プロフィール更新画面
    public function upprofile(Request $request)
    {
        $id = session()->get('id');
        $img = $request->image;
        $image = $img->getClientOriginalName();
        InterventionImage::make($img)
            ->resize(50, 50, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/icon/' . $image));

        $data = [
            'nickname' => $request->nickname,
            'name' => $request->name,
            'email' => $request->email,
            'image' => $image,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ];
        DB::table('users')->where('id', $id)->update($data);
        return redirect('/login');
        //    up出来たらセッションに保存しているデータを削除
        //    新しく更新したデータをまた取り出してくる。 // セッションに保存
        // セッションからゲットしてきて
        // 表示を行う。
        // $nickname = session()->get('nickname');
        //     $name = session()->get('name');
        //     $image = session()->get('image');
        //     $email = session()->get('email');
        //    return view('profile', [
        //     'nickname' => $nickname,
        //     'image' => $image,
        //     'name' => $name,
        //     'email' => $email,
        // ]);
    }
    public function post(Request $request)
    {
        return view('post');
    }
    public function search(Request $request)
    {
        return view('search');
    }
    public function notification(Request $request)
    {
        return view('notification');
    }
}
