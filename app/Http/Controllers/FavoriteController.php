<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getFavorite(Request $request)
    {
        $id=$request->id;
        $vetements=Favorite::where('user_id','=',$id)
        ->join('articles', 'articles.id', '=', 'favorites.article_id')
        ->get();
        if($vetements){
          return response()->json($vetements);
      }else{
          return response()->json(['errors'=>'Un error est survenue']);
      }

        //  $id=$request->id;
        // $favorite=DB::table('favorites')->where('user_id','=',$id)
        // ->join('articles', 'articles.id', '=', 'favorites.article_id')
        // ->get();
        // if($favorite){
        //     return response()->json($favorite);
        // }else{
        //     return response()->json(['errors'=>'Un error est survenue']);
        // }
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

      $validator=Validator::make($request->all(),[
            "user_id"=>"required",
            "article_id"=>["required",Rule::unique('articles')],
      ],
        [
            "article_id.unique"=>"Article existe deja dans vos favoris",
        ]);

        $favorite= Favorite::create([
           "user_id"=>$request->idUser,
           "article_id"=>$request->article_id
        ]);

        if($favorite){
            return response()->json(['success'=>'Article ajouter a vos favoris']);
        }else{
            return response()->json(['error'=>'Request Faild']);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
