<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Validator;

class ItemController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function create(Request $request, Item $item){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'stock' => 'required',
            'category' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $success = $item->create($input);
        return response()->json(['success'=>$success]);
    }
}
