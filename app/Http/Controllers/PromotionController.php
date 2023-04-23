<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promo=Promotion::all();
        return response()-> json($promo);
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

            'description'=>"required|string|min:8",
          
        ],
        
        [
            "description.required"=>"La description est requise",
            "description.string"=>"La description doit etre en chaine de caratéres",
            "description.min"=>"La description doit etre min 8carateres",

           
        ]);
        if($validator->fails()){
            return response()->json(["errors" =>$validator->errors()], 401);
         }

         $promo= new Promotion();
         $promo->description=$request->description;
        $success= $promo->save();

        if($success){
            return response()->json(['message'=>'Sauvegarder avec success']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        $affectedRows = Promotion::where('id', '=', $request->id)->update([
            "description"=>$request->description,

        ]);
        if($affectedRows){
            return response()->json(['message'=>'Sauvegarder avec success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        //
    }
}
