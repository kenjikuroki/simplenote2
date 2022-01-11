<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
        $memos = Memo::where('user_id', $user['id'])->where('status',1)->orderBy('update_at', 'DESC')->get();
        return view('home', compact('user', 'memos'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        //ログインしているユーザー情報をView渡す
        $user = \AUth::user();
        return view('create', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);
        // POSTされたデータをDB（memosテーブル）に挿入
        // MEMOモデルにDBへ保存する命令を出す
        $memo_id = Memo::insertGetId([
            'content' => $data['content'],
             'user_id' => $data['user_id'], 
             'status' => 1
        ]);
            // リダイレクト処理
             return redirect()->route('home');
        }
        
}
