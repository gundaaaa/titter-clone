<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Psy\VersionUpdater\IntervalChecker;
use InterventionImage;

class LikeController extends Controller
{
    // いいねボタンの実装
    public function like(Request $request)
    {
        $user = session()->get('id');
        $like_id = null;
        $response = null;
        // jsからポストされた場合
        if (isset($request->tweet_id)) {
            $data = [
                'tweet_id' => $request->tweet_id,
                'user_id' => $user
            ];
            // いいね！登録 下でインサートしてインサートしたデータを取って来ている。
            // ddの確認はjsとの直接通信なので、// F12で検証ツールでnetworkでfilterの右側のallを選択する。左下の開いているファイルを開いてpereviewでエラーの中身を確認する。
            $like_id = DB::table('likes')->insertGetId($data);
        }
        // いいねの取り消し
        // var_dump($request->like_id);
        if (isset($request->like_id)) {
            $data = [
                'status' => 'deleted',
            ];
            // $like_id = $request->like_id;
            $user_id = $user;
            // いいね!削除
            // $response = DB::table('likes')->where('id',$request->like_id)->update($data);
            $response = DB::table('likes')->where('id', $request->like_id)->where('user_id', $user_id)->update($data);
        }
        // / JSON形式で結果を返却
        // ------------------------------------
        $response = [
            'message' => 'successful',
            // いいね！したときに値が入る
            'like_id' => $like_id,
        ];
        // ★この前にvar_dumpがあるとこの下のresponseは出来なくなる。
        // 通信から来た場所に返信している。今回だったらlikes.jsに返信している。
        return response()->json($response);

    }
}
