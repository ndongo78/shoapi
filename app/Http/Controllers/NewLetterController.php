<?php

namespace App\Http\Controllers;

use App\Models\NewLetter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class NewLetterController extends Controller
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
            'email'=>["required","string","email:rfc",Rule::unique('new_letters')],
        ],[
            "email.required"=>"L'email est obligatoire ",
            "email.email"=>"L'email est invalid",
            "email.unique"=>"Vous etes deja abonné",

        ]);

        if($validator->fails()){ 
            return response()->json(["errors" => $validator->errors()], 401);
        }
        $article= new NewLetter();
        $article->email= $request->email;

        $article->save();
        return response()->json(['message'=>'Sauvegarder avec success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewLetter  $newLetter
     * @return \Illuminate\Http\Response
     */
    public function show(NewLetter $newLetter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewLetter  $newLetter
     * @return \Illuminate\Http\Response
     */
    public function edit(NewLetter $newLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewLetter  $newLetter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewLetter $newLetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewLetter  $newLetter
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewLetter $newLetter)
    {
        //
    }
}
