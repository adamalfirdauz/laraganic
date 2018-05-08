<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Validator;

class CartController extends Controller
{
    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'id' => 'required',
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $email = $request->email;
        // Cart::store($email);
        $cart = Cart::instance($email)->add([$input,$input]);
        Cart::instance($email)->store($email);
        return response()->json(['success'=>$cart], 200);
    }

    public function content(Request $request){
        $email = $request->email;
        Cart::instance($email)->restore($email);
        $cart = Cart::instance($email)->content();
        // dd(Cart::instance($email)->restore($email));
        return response()->json(['content'=>$cart], 200);
    }
}
