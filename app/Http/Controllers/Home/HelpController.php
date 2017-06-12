<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ArticleCategory;
use App\Article;
use Illuminate\Support\Facades\Auth;

class HelpController extends Controller
{
	//帮助中心列表页
	public function index (Request $request) {
		$lists = ArticleCategory::get();
		$title = '帮助中心';
		return view(config('app.theme').'.home.helpList')->with(['lists'=>$lists, 'title'=>$title]);
	}

	//帮助中心详情页
	public function detail (Request $request, $id) {
		$content = Article::find($id);
		$title = '帮助中心';
		return view(config('app.theme').'.home.helpContent')->with(['content'=>$content,'title'=>$title]);
	}
}
