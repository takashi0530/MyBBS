<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    //
    // お気に入り一覧の表示
    public function index()
    {
        // お気に入り情報を全部取得
        $bookmarks = Bookmark::latest()->get();

        return view('bookmarks.index')
            ->with([
                'bookmarks' => $bookmarks,
            ]);
    }
}
