<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();

        return response()-> json($categories);
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
        $reactToken = $_SERVER['HTTP_REACT_TOKEN'];

        $user=User::where("react_token", $reactToken)->first();
        //return response()->json($user);
         if($user->role == 'admin'){
            $validator=Validator::make($request->all(),[
                "name"=>"required|string|min:5"
            ],[
                "name.required"=>"Le nom est obligatoire",
                "name.string"=>"Le nom doit etre une chaine de caracteres",
                "name.nim"=>"Le nom doit etre min 2carateres",
            ]);
    
            if($validator->fails()){
                return response()->json(["errors" =>$validator->errors()], 401);
             }
             $categoryFinder=Category::where( "name",$request->name);

             if($categoryFinder->count() != 0){
                return response()->json(["message"=>"Category exist"]);
             }else{
                $category=Category::create([
                    "name"=>$request->name
                 ]);
                    
                 if(!$category){
                    return response()->json(["errors" =>"Error de sauvegarde"], 401);
                 }
                return response()->json(["message"=>"Sauvegarder avec success"]);
             }
         }else{
            return response()->json(['message'=>'Access Denied']);
         }
       
    }
    



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $reactToken = $_SERVER['HTTP_REACT_TOKEN'];
        $user=User::where("react_token", $reactToken)->first();
         if($user->role == 'admin'){
            $validator=Validator::make($request->all(),[
                "name"=>"required|string|min:5"
            ],[
                "name.required"=>"Le nom est obligatoire",
                "name.string"=>"Le nom doit etre une chaine de caracteres",
                "name.nim"=>"Le nom doit etre min 2carateres",
            ]);
    
            if($validator->fails()){
                return response()->json(["errors" =>$validator->errors()], 401);
             }
            // return response()->json($category->id);
             $categoryFinder=Category::where( "id",$category->id)->update([
                "name"=>$request->name
             ]);

             if($categoryFinder){
                return response()->json(['success'=>'Category updated']);
            }else{
                return response()->json(['error'=>'Request Faild']);
            }
         }else{
            return response()->json(['message'=>'Access Denied']);
         }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $reactToken = $_SERVER['HTTP_REACT_TOKEN'];
        $user=User::where("react_token", $reactToken)->first();
         if($user->role == 'admin'){
             $category->delete();
            //DB::table('categories')->where('id', '=', $category)->delete();
            return response()->json(["message" => "Category deleted"]);
         }else{
            return response()->json(['message'=>'Access Denied']);
         }
    }
}
