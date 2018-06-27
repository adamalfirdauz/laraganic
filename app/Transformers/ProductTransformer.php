<?php

namespace App\Transformers;

use App\Transaction;
use App\Item;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract{
    public function transform(Item $item){
        return [
            'id' => $item->id,
            'name' => $item->name,
            'price' => $item->price,
            'unit' => $item->unit,
            'stock' => $item->stock,
            'category' => $item->category,
            'description' => $item->description,
            'nutrition' => $item->nutrition,
            'img' => 'storage/'.$item->img,
        ];
    }

}