<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 🔽 2行追加
use Validator;
use App\Models\Tweet;
use Auth;
use App\Models\User;

class TweetController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
  // 🔽 編集
  $tweets = Tweet::getAllOrderByUpdated_at();
  return response()->view('tweet.index',compact('tweets'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // 🔽 追加
    return response()->view('tweet.create');
  }

  // 以降は変更なし



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      // バリデーション
      $validator = Validator::make($request->all(), [
        'tweet' => 'required | max:191',
        'description' => 'required',
      ]);
      // バリデーション:エラー
      if ($validator->fails()) {
        return redirect()
          ->route('tweet.create')
          ->withInput()
          ->withErrors($validator);
      }
      $data = $request->merge(['user_id' => Auth::user()->id])->all();
      $result = Tweet::create($data);

    // tweet.index」にリクエスト送信（一覧ページに移動）
      return redirect()->route('tweet.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $tweet = Tweet::find($id);
      return response()->view('tweet.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $tweet = Tweet::find($id);
      return response()->view('tweet.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $validator = Validator::make($request->all(), [
        'tweet' => 'required | max:191',
        'description' => 'required',
      ]);
      //バリデーション:エラー
      if ($validator->fails()) {
        return redirect()
          ->route('tweet.edit', $id)
          ->withInput()
          ->withErrors($validator);
      }
      //データ更新処理
      $result = Tweet::find($id)->update($request->all());
      return redirect()->route('tweet.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $result = Tweet::find($id)->delete();
      return redirect()->route('tweet.index');
    }

    public function timeline()
    {
  // フォローしているユーザを取得する
      $followings = User::find(Auth::id())->followings->pluck('id')->all();
  // 自分とフォローしている人が投稿したツイートを取得する
      $tweets = Tweet::query()
        ->where('user_id', Auth::id())
        ->orWhereIn('user_id', $followings)
        ->orderBy('updated_at', 'desc')
        ->get();
      return view('tweet.index', compact('tweets'));
    }

    public function mydata()
    {
    // Userモデルに定義したリレーションを使用してデータを取得する．
    $tweets = User::query()
      ->find(Auth::user()->id)
      ->userTweets()
      ->orderBy('created_at','desc')
      ->get();
    return response()->view('tweet.index', compact('tweets'));
  }
}
