<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SingController;
use App\Http\Controllers\LikeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ログイン画面
Route::get('login', [singController::class, 'log']);
Route::post('login',[SingController::class, 'login']);
// 会員登録画面
Route::get('sign', [singController::class, 'sin']);
Route::post('sign', [singController::class, 'signup']);
// ホーム画面
Route::get('home', [singController::class, 'home']);
Route::post('home', [singController::class, 'homes']);
// プロフィール画面
Route::get('profile', [singController::class, 'profile']);
Route::post('profile', [singController::class, 'upprofile']);
// いいねボタンの実装
// Route::get('like', [LikeController::class, 'like']);
Route::post('like', [LikeController::class, 'like']);
// つぶやき投稿画面
Route::get('post', [singController::class, 'post']);
// 検索画面
Route::get('search', [singController::class, 'search']);
// 通知画面
Route::get('notification', [singController::class, 'notification']);
