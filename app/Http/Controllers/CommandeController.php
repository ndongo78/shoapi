<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes=DB::table('commandes')
        ->join('users', 'users.id', '=', 'commandes.user_id')
        ->join('articles', 'articles.id', '=', 'commandes.article_id')
        ->get();
        if($commandes){
            return response()->json($commandes);
        }else{
            return response()->json(['errors'=>'Un error est survenue']);
        }
        // $commande=Commande::all();
        // return response()-> json($commande);
    }

    public function getCommande(Request $request)
    {
         $id=$request->id;
        $commande=DB::table('commandes')->where('user_id','=',$id)
        ->join('articles', 'articles.id', '=', 'commandes.article_id')
        ->get();
        if($commande){
            return response()->json($commande);
        }else{
            return response()->json(['errors'=>'Un error est survenue']);
        }
        
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
        foreach($request->tab as $id){
            $commande= new Commande();
            $commande->user_id= $request->id;
            $commande->article_id= $id;
            $commande->color=$request->color;
            $commande->taile=$request->taille;
           $commandes= $commande->save();
  
          }
          if ($commandes) {
          return response()->json(['message'=>'Sauvegarder avec success']);
  
          }else{
         return response()->json(['error'=>'Error de sauvegarde']);
  
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
