<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // Register Function
    public function register(Request $request){
        //validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:authors",
            "phone_no" => "required",
            "password" => "required|confirmed"
        ]);

        //create data
        $author = new Author();
        $author->name = $request->name;
        $author->email = $request->email;
        $author->phone_number = $request->phone_no;
        $author->password = bcrypt($request->password);

        //save to database
        $save_author = $author->save();
        //response
        if($save_author){
            return response()->json([
                "status" => "1",
                "message" => "Successfully Registered"
            ]);
        }
        else{
            return response()->json([
                "status" => "0",
                "message" => "Something Wrong"
            ]);
        }
    }

    // Login Function
    public function login(Request $request){

        $login_data = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if(!auth()->attempt($login_data)){
            return response()->json([
                "status" => false,
                "message" => "invalid credential"
            ]);
        }

        $token = auth()->user()->createToken("auth_token");

        return response()->json([
            "status" => true,
            "message" => "Loged In",
            "access_token" => $token
        ]);

    }

    // Profile Function 
    public function profile(){

    }

    // Logout Function
    public function logout(){

    }
}
