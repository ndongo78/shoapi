<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
         // je récupère en premier le token que j'ai envoyé depuis mon React
         $react_token = $request->header('react_token');
         
         // je teste si le token est bon
         if(!$react_token){
             // sinon erreur
             return response()->json(["errors" => "Accès refusé"], 403);
         }
         
         // si oui, je récupère l'utilisateur à connecter
         $user  = User::where('react_token', $react_token)->first();
 
         // si l'utilisateur à connecter n'est pas bon, je retourne la même erreur
         if(!$user){
             return response()->json(["errors" => "Accès refusé"], 403);
         }
         // sinon on authorise la connexion de l'utilisateur depuis la BDD
          Auth::login($user);
 
          // puis le request peut accéder au contrôleur concerné
         return $next($request);
 
         // je n'oublie pas de déclarer ce Middleware là dand le kernel.php
         // au niveau de : protected $routeMiddleware = []
    }
}
