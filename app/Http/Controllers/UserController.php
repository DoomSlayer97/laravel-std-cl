<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function auth(Request $req) {

        $bodyParams = $req -> only("email", "password");

        try {
            
            if(!$token = JWTAuth::attempt($bodyParams)) {
                return response([
                    "message"           =>              "invalid_credentials"
                ], 400);
            }

        } catch (JWTException $e) {
            return response([
                "message"           =>              "could_not_create_token"
            ], 500);
        }

        return response([
            "message"               =>              "authenticated",
            "token"                 =>              $token
        ]);

    }
    
    public function create(Request $req) {

        $bodyParams = $req -> only(
            "name",
            "email",
            "password"
        );

        $validation = validator($bodyParams, [
            "name"                  =>              "required|string",
            "email"                 =>              "required|string",
            "password"              =>              "required|string"
        ]);

        if ($validation -> fails()) return response([
            "message"               =>              "invalid_params",
            "errors"                =>              $validation -> errors()
        ]);

        $bodyParams["password"] = Hash::make($bodyParams["password"]);

        $newUser = new User($bodyParams);

        if (!$newUser -> save()) return response([
            "message"           =>          "create_error"
        ], 500);

        return response([
            "message"               =>              "created",
            "user"                  =>              $newUser
        ]);

    }

    public function findAll() {

        $users = User::where("isDeleted", 0)
            -> get();

        return response([
            "users"             =>              $users
        ]);

    }

    public function findOne($id) {
        
        $user = User::find($id);

        return response([
            "user"              =>              $user
        ]);

    }

    public function update(Request $req, int $id) {

        $bodyParams = $req -> only(
            "name",
            "email",
            "password"
        );

        $validation = validator($bodyParams, [
            "name"                  =>              "required|string",
            "email"                 =>              "required|string",
            "password"              =>              "required|string"
        ]);

        if ($validation -> fails()) return response([
            "message"               =>              "invalid_params",
            "errors"                =>              $validation -> errors()
        ]);

        $bodyParams["password"] = Hash::make($bodyParams["password"]);

        $newUser = User::find($id);
        
        $newUser -> name = $bodyParams["name"];
        $newUser -> email = $bodyParams["email"];
        $newUser -> password = Hash::make($bodyParams["password"]);

        if (!$newUser -> save()) return response([
            "message"           =>          "create_error"
        ], 500);

        return response([
            "message"               =>              "created",
            "user"                  =>              $newUser
        ]);        

    }

}
