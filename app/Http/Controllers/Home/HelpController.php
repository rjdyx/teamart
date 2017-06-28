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
		$lists = Article::join('article_category','article.category_id','=','article_category.id')
				->whereNull('article.deleted_at')
				->whereNull('article_category.deleted_at');
		$lists = $lists->select(
				'article.*',
				'article_category.name as category_name',
				'article_category.desc as category_desc'
		)
		->orderBy('article.id','asc')
		->paginate(10);
		$title = '帮助中心';
		return view(config('app.theme').'.home.helpList')->with(['lists'=>$lists, 'title'=>$title]);
	}

	//帮助中心详情页
	public function detail (Request $request, $id) {
		$content = Article::find($id);
		$con = html_entity_decode($content->content);
		$title = '帮助中心';
		//$title = $content->name;
		return view(config('app.theme').'.home.helpContent')->with(['con'=>$con,'title'=>$title]);
	}
}
