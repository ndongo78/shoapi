<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>"required|string|min:2",
            'prenom'=>'required|string|min:2',
            'email'=>["required","string","email:rfc",Rule::unique('users')],
            'password'=>"required|string|min:8",
            'confirm_password'=>"required|string|min:8|same:password",
            'telephone'=>"required|numeric|min:8",
            'addresse'=>"required|string|min:8"
        ],
        
        [
            "name.required"=>"Le nom est obligatoire",
            "name.string"=>"Le nom doit etre une chaine de caracteres",
            "name.nim"=>"Le nom doit etre min 2carateres",
            
            "prenom.required"=>"Le prenom est obligatoire",
            "prenom.string"=>"Le prenom doit etre une chaine de caracteres",
            "prenom.nim"=>"Le prenom doit etre min 2carateres",

            "email.required"=>"L'email est obligatoire ",
            "email.email"=>"L'email est obligatoire",
            "email.unique"=>"L'email existe deja",
            
            "password.required"=>"Le password est obligatoire",
            "password.string"=>"Le password doit etre une chaine de caracteres",
            "password.min"=>"Le password doit etre min 8carateres",

            "confirm_password.required"=>"La confirmation du mot de pass est obligatoire",
            "confirm_password.string"=>"Le password doit etre une chaine de caracteres",
            "confirm_password.same"=>"Le password doit etre identique",

            "telephone.required"=>"Numero telephone est obligatoire",
            "telephone.number"=>"Telephone invalid",
            "telephone.min"=>"Telephone doit avoir au moins 8caracteres",

            "addresse.required"=>"L'addresse est obligatoire",
            "addresse.string"=>"L'addresse doit etre une chaine de caracteres et des numero",
            "addresse.min"=>"L'addresse doit avoir au moins 8caracteres",
        ]);

        if($validator->fails()){
           return response()->json(["errors" =>$validator->errors()], 401);
        }

        $react_token=Str::random(33);

        $user= User::create([
            "name"=>$request->name,
            "prenom"=>$request->prenom,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
            "telephone"=>$request->telephone,
            "addresse"=>$request->addresse,
            "react_token" => $react_token,
        ]);

        return response()->json($user);
    }
    public function updateUserInfos(Request $request)
    {
        $id=$request->id;

        $affectedRows = User::where('id', '=', $id)->update([
       "name"=>$request->name,
        "prenom"=>$request->prenom,
        "email"=>$request->email,
        "password"=>Hash::make($request->password),
        "telephone"=>$request->telephone,
        "addresse"=>$request->addresse
        ]);

        if($affectedRows){
            return response()->json(['success'=>'Enregistrer avec success']);
        }else{
            return response()->json(['error'=>'Request Faild']);
        }
    }
  
}
