<?php

namespace App\Http\Controllers\Generics;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{   
    //Retorna todos as news
    public static function getNews(Request $request){

        $data = '';

        if($request->language == 0){

            $data = News::all()
            ->paginate($request->perPage);

        }else{

            $data = News::where('language_id', $request->language)
            ->orderby('id', 'desc')
            ->limit($request->perPage)
            ->get();
        }

        return $data;
    }
}
