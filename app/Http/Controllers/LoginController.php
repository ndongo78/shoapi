<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{


    public function index()
    {
        $users=User::where('role','=',null)->get();
        return response()-> json($users);
    }

    public function connect(Request $request){
        
        $validator=Validator::make($request->all(),[
            "email"=> "required|email:rfc",
            "password"=>"required|string|min:8"
        ],[
            "email.required"=>"L'email est obligatoire ",
            "email.email"=>"L'email est invalid",

            "password.required"=>"Le password est incorect",
            "password.string"=>"Le password invalid",
            "password.min"=>"Le password doit etre minimum 8carateres",
        ]);

        if($validator->fails()){ 
            return response()->json(["errors" => $validator->errors()], 401);
        }

        if(Auth::attempt(["email" => $request->email, "password" => $request->password])){ 
            $user = User::where('email', $request->email)->first();
            return response()->json($user);
        } else{
                return response()->json(["errorsIdentifiant" => "Indenfiant ou mot de pass incorrect"], 401); 
            }
         
}

  public function resetPassword(Request $request)
    {
        
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );
        // return response()->json($status);
        $validator=Validator::make($request->all(),[
            "email"=> "required|email:rfc",
        ],[
            "email.required"=>"L'email est obligatoire ",
            "email.email"=>"L'email est invalid",
        ]);
        if($validator->fails()){ 
            return response()->json(["errors" => $validator->errors()], 401);
        }else{
            $user = User::where('email','=', $request->email)->first();
            
        //   $result=Password::sendResetLink(['email' => $user->email]);
            if($user){
                
                Mail::to($user->email)->send(new ResetPasswordMail($user)); 

                //return response()->json($user);
            }else{
                return response()->json(['errors'=>"Aucun compte n'est associé à cette addresse email"]);
            }
        }
    }

     public function verifyUserForResetPassword($id){
        $user = User::where('id','=', $id)->first();
        return response()->json($user);
         
     }
     public function updateForgotPassword(Request $request){
        $validator=Validator::make($request->all(),[
           
            'password'=>"required|string|min:8",
            'confirm_password'=>"required|string|min:8|same:password",
        ],
        
        [ 
            "password.required"=>"Le password est obligatoire",
            "password.string"=>"Le password doit etre une chaine de caracteres",
            "password.nim"=>"Le password doit etre min 8carateres",

            "confirm_password.required"=>"La confirmation du mot de pass est obligatoire",
            "confirm_password.string"=>"Le password doit etre une chaine de caracteres",
            "confirm_password.same"=>"Le password doit etre identique",
        ]);

        if($validator->fails()){
           return response()->json(["errors" =>$validator->errors()], 401);
        }
        $password= DB::table('users')
        ->where("users.id", '=',  $request->id)
         ->limit(1)
        ->update(['users.password'=> Hash::make($request->password)] );

        return response()->json(['success'=>'Votre mot de pass est changer avec success']);
     }

    public function resetPasswordView($react_token)
    {
        $user = User::where("react_token", $react_token)->first();
        return response()->json($user);
    }

    public function updatePassword(Request $request){
        $validator=Validator::make($request->all(),[
           
            'password'=>"required|string|min:8",
            'confirm_password'=>"required|string|min:8|same:password",
        ],
        
        [ 
            "password.required"=>"Le password est obligatoire",
            "password.string"=>"Le password doit etre une chaine de caracteres",
            "password.nim"=>"Le password doit etre min 8carateres",

            "confirm_password.required"=>"La confirmation du mot de pass est obligatoire",
            "confirm_password.string"=>"Le password doit etre une chaine de caracteres",
            "confirm_password.same"=>"Le password doit etre identique",
        ]);

        if($validator->fails()){
           return response()->json(["errors" =>$validator->errors()], 401);
        }
        //Page::where('id', $id)->update(array('image' => 'asdasd'));
       // $password=User::where('email','=',$request->email)->update(['password'=>$request->password]);
       $password= DB::table('users')
       ->where("users.email", '=',  $request->email)
        ->limit(1)
       ->update(['users.password'=> $request->password]);
       
       return response()->json($password);
    }

public function adInfos(Request $request){
    if($request->id){
        $user = User::where('id', $request->id)->first();
    return response()->json($user);
    }else{
        return response()->json(['errors'=>'Un error est survenue']);
    }
}

public function getInfo(Request $request)
{
    if($request->id){
        $user = User::where('id', $request->id)->first();
    return response()->json($user);
    }else{
        return response()->json(['errors'=>'Un error est survenue']);
    }
}


}
