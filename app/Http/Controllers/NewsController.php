<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orderBy = 'created_at';

        if($request->sort_by == 'views') $orderBy = 'views';

        $news = News::notDraft()->orderByDesc($orderBy)->get();

        return view(
            'news',
            compact('news')
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showtheme()
    {

        $business = News::where('category', 'buziness')->orderBy('id', 'desc')->take(3)->get();
        $sports = News::where('category', 'sports')->orderBy('id', 'desc')->take(3)->get();

        $popular = News::where('category', 'popular')->orderBy('id', 'desc')->take(3)->get();
        $hotnews = News::where('category', 'hotnews')->orderBy('id', 'desc')->take(3)->get();
        $lifestyle = News::where('category', 'lifestyle')->orderBy('id', 'desc')->take(6)->get();
        $world_carousel = News::where('category', 'world')->orderBy('id', 'desc')->take(8)->get();
        $world_news = News::where('category', 'world')->orderBy('id', 'desc')->take(4)->get();

        return view(
            'news_theme',
            compact('business', 'popular', 'hotnews', 'lifestyle', 'world_carousel', 'world_news', 'sports')
        );
    }

    //Show
    public function show(int $newsId)
    {
        $news = News::findOrFail($newsId);

        $news->incrementViewCount();

        $recentnews = News::orderBy('id', 'desc')->take(5)->get();

        return view('news_item', compact('news', 'recentnews'));
    }
}
