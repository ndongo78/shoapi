<?php

namespace App\Http\Controllers;

use App\Models\Mesclients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MesclientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages=DB::table('mesclients')->select('*')
        //->join('users', 'users.id', '=', 'mesclients.user_id')
        ->get();
        if($messages){
            return response()->json($messages);
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
        $validator=Validator::make($request->all(),[
            'email'=>"required|string|email:rfc",
            'object'=>"required|string|min:2",
            'message'=>"required|string|min:8",
        ],
        
        [
            "email.required"=>"L'email est obligatoire ",
            "email.email"=>"L'email est invalide",

            "object.required"=>"L'object est obligatoire",
            "object.string"=>"L'object doit etre en chaine de caracteres",
            "object.nim"=>"L'object doit etre au min 2carateres",

            
            "message.required"=>"L'object est obligatoire",
            "message.string"=>"L'object doit etre en chaine de caracteres",
            "message.min"=>"L'object doit etre au min 8carateres",
        ]);

        if($validator->fails()){
            return response()->json(["errors" =>$validator->errors()], 401);
         }
           
         $userMessage= Mesclients::create([
             'user_id'=>$request->id,
             'email'=>$request->email,
             'sujet'=>$request->object,
             'message'=>$request->message,

         ]);

         if($userMessage){
             return response()->json(['message'=>'Nous avez bien recu votre message.Nous vous répondrons dans un bref délai']);
         }else{
             return response()->json(['errors'=>'Une erreur est survenu. veillez réessayer']);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mesclients  $mesclients
     * @return \Illuminate\Http\Response
     */
    public function show(Mesclients $mesclients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mesclients  $mesclients
     * @return \Illuminate\Http\Response
     */
    public function edit(Mesclients $mesclients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mesclients  $mesclients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mesclients $mesclients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mesclients  $mesclients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mesclients $mesclients)
    {
        //
    }
}
