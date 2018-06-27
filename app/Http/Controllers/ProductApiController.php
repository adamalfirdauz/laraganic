<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Validator;
use App\Transformers\ProductTransformer;

class ProductApiController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function getAll(){
        $items = Item::get();
        return fractal()
            ->collection($items)
            ->transformWith(new ProductTransformer)
            ->toArray();
    }

    public function search(Request $request){
        if($request->has('search')){
            $items = Item::search($request->search)->get();
        }
        else{
            $items = Item::get();
        }
        return fractal()
            ->collection($items)
            ->transformWith(new ProductTransformer)
            ->toArray();
    }
    
}
