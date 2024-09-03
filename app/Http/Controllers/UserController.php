<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller{

    public function getUser(){
        return User::all();
    }
    public function store(Request $request){
     //Request
        $validated = Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);
        if($validated->fails()){
            return $validated->errors();
        }

        $ValidateData = $validated->validated();

        if($request->hasFile('thumb')){
            $ValidateData['thumb'] = $request->file('thumb')->store('photos','public');
        }
        $ValidateData['password'] = Hash::make( $ValidateData['password']);
        $user = User::create($ValidateData);
        return response()->json(['status'=>'Success','data'=>$user],201);
        //Resource
        /**
         *
         *
         */

    }

}
