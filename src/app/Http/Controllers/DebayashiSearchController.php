<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debayashi;

class DebayashiSearchController extends Controller
{
    public function index(Request $request)
    {
        // 初期化
        $debayashi = null;
        // キーワードを取得
        $keyword = $request->input('search_keyword');

        // もしキーワードが入力されている場合
        if (!empty($keyword)) {
            $debayashi = Debayashi::getByKeyword($keyword);
        }

        // Spotify検索
        $this->spotifyService->search($debayashi);
        // Apple Music検索
        $this->appleMusicService->search($debayashi);
        // シェアボタン用テキストの取得
        $shareText = $this->getShareText($debayashi);

        //検索フォームへ
        return view('search.index', [
            'debayashi' => $debayashi,
            'shareText' => $shareText,
            'keyword' => $keyword,
        ]);
    }
}
