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
        $item = Item::get();
        return fractal()
            ->collection($item)
            ->transformWith(new ProductTransformer)
            ->toArray();
    }
    
}
