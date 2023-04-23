<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article=Article::all();
        return response()-> json($article);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByid(Request $request)
    {
        if($request->id){
            $article = Article::where('id', $request->id)->first();
        return response()->json(['success'=>$article]);
        }else{
            return response()->json(['errors'=>'Un error est survenue']);
        }
        
    }

    public function getChaussures()
    {  
        $chaussures=Article::where('category_id','=',1)->get();
        // $chaussures=DB::table('articles')->where('category_id','=',1)->get();
        if($chaussures){
            return response()->json($chaussures);
        }else{
            return response()->json(['errors'=>'Un error est survenue']);
        }
    }

    public function getVetements()
    {
          $vetements=Article::where('category_id','=',2)->get();
          if($vetements){
            return response()->json($vetements);
        }else{
            return response()->json(['errors'=>'Un error est survenue']);
        }
        // $vetements=DB::table('articles')->where('category_id','=',2)->get();
        // if($vetements){
        //     return response()->json($vetements);
        // }else{
        //     return response()->json(['errors'=>'Un error est survenue']);
        // }
    }
    public function getLast(){
        $orders = Article::where('category_id','=',1)
                ->orderByRaw('created_at DESC')->limit(8)
                ->get();
        
                if($orders){
             return response()->json($orders);
         }else{
             return response()->json(['error'=>'Eurror dans la requéte']);
         }
                
    }
    public function getLastVet(){
        $orders = Article::where('category_id','=',2)
                ->orderByRaw('created_at DESC')->limit(8)
                ->get();

                if($orders){
                    return response()->json($orders);
                }else{
                    return response()->json(['error'=>'Eurror dans la requéte']);
                }
                    
    }
    public function getLastAcs(){
        $orders = Article::where('category_id','=',3)
                ->orderByRaw('created_at DESC')->limit(8)
                ->get();

                if($orders){
                    return response()->json($orders);
                }else{
                    return response()->json(['error'=>'Eurror dans la requéte']);
                }
                    
    }

    public function getAccessoires()
    {
        $accessoires=Article::where('category_id','=',3)->get();
        //$accessoires=DB::table('articles')->where('category_id','=',3)->get();
        if($accessoires){
            return response()->json($accessoires);
        }else{
            return response()->json(['errors'=>'Un error est survenue']);
        }
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
            'category_id'=>"required",
            'title'=>"required","string",
            'description'=>"required|string|min:8",
            'price'=>"required|min:2|string",
            'image'=>"required|image",
            // 'colors'=>"required|string",
            // 'taille'=>"required",
        ],
        
        [
            "category_id.required"=>"Le nom category  est obligatoire",
            "title.rquired"=>"Le nom de l'article est obligatoire",
            "title.string"=>"Le nom de l'article doit étre en chaine de caractéres",
            "description.required"=>"La description est requise",
            "description.string"=>"La description doit etre en chaine de caratéres",
            "description.min"=>"La description doit etre min 8carateres",

            "image.required"=>"L'image est obligatoire",
            "image.image"=>"Désoler le fichier doit étre une image",
            "price.required"=>"Le prix est obligatoire",
            "price.numerique"=>"Le prix doit étre un nombre numérique",
            "price.min"=>"Le prix doit étre un minimun 2 chiffres",
            // "colors.required"=>"Les couleurs sont obligatoire",
            // "colors.string"=>"Les couleurs doivent etre en chaine caracteres",
            // "taille.required"=>"Taille est obligatoire",
           
        ]);
        if($validator->fails()){
            return response()->json(["errors" =>$validator->errors()], 401);
         }

         $file_name=$request->file('image');
        $extension= $file_name->getClientOriginalExtension();
        $file_name=time().'.'.$extension;
          

        
         
         $article= new Article();
           $article->category_id=$request->category_id;
           $article->title=$request->title;
            $article->description=$request->description;
            $article->price= $request->price;
            $article->image=$file_name ;
            $article->colors =$request->colors;
            $article->taille =$request->taille ;
            
            $article->save();
       
        $request->file('image')->move('uploads/',$file_name);

         return response()->json(['message'=>'Sauvegarder avec success']);
        // return response()->json($request->tab);
        // return response()->json($request->tab2);
   
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function editArticle(Request $request)
    {
        if($request->id){
            $article = Article::where('id', $request->id)->first();
        return response()->json($article);
        }else{
            return response()->json(['errors'=>'Un error est survenue']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $validator=Validator::make($request->all(),[
            'category_id'=>"required",
            'title'=>"required","string",
            'description'=>"required|string|min:8",
            'price'=>"required|min:2",
            // 'image'=>"image",
            // 'colors'=>"string|min:2",
            // 'taille'=>"string",
        ],
        
        [
            "category_id.required"=>"Le nom category  est obligatoire",
            "title.rquired"=>"Le nom de l'article est obligatoire",
            "description.nim"=>"La description doit etre min 2carateres",

            // "image.required"=>"L'image est obligatoire ",
            // "price.rquired"=>"Le prix est obligatoire",
            // "colors.string"=>"Les couleurs doivent etre en chaine caracteres",
            // "colors.string"=>"Les couleurs doivent etre en chaine caracteres",
           
        ]);
        if($validator->fails()){
            return response()->json(["errors" =>$validator->errors()], 401);
         }

         if($request->file('image')){
            $file_name= $request->file('image');
            $extension= $file_name->getClientOriginalExtension();
            $file_name=time().'.'.$extension;
            $id=$request->id;

            $affectedRows = Article::where('id', '=', $id)->update([
           "category_id"=>$request->category_id,
            "title"=>$request->title,
            "description"=>$request->description,
            "price"=>$request->price,
            "image"=>$file_name,
            "colors"=>$request->tab,
            "taille"=>$request->tab2,
            ]);
            $request->file('image')->move('uploads/',$file_name);

            if($affectedRows){
                return response()->json(['success'=>'Enregistrer avec success']);
            }else{
                return response()->json(['error'=>'Request Faild']);
            }

         }else{
            $id=$request->id;
            $affectedRows = Article::where('id', '=', $id)->update([
                "category_id"=>$request->category_id,
                 "title"=>$request->title,
                 "description"=>$request->description,
                 "price"=>$request->price,
                 "colors"=>$request->tab,
                 "taille"=>$request->tab2,
                 ]);

                 if($affectedRows){
                     return response()->json(['success'=>'Enregistrer avec success']);
                 }else{
                     return response()->json(['error'=>'Request Faild']);
                 }
         }
        
        // $file_name=$request->file('image');
       // $article->update();
        //   $extension= $file_name->getClientOriginalExtension();
        //  $file_name=time().'.'.$extension;

        

         
         
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
    }
}
