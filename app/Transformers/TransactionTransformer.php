<?php

namespace App\Transformers;

use App\Transaction;
use App\Item;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract{
    public function transform(Transaction $transaction){
        $item = Item::where('id', '=', $transaction->item_id)->first();
        return [
            'id' => $transaction->id,
            'code' => $transaction->code,
            'user_id' => $transaction->user_id,
            'item_id' => $transaction->item_id,
            'item_name' => $item->name,
            'price' => $transaction->price,
            'qty' => $transaction->qty,
            'status' => $transaction->status,
            'msg' => $transaction->msg,
            'payment_proof' => 'storage/'.$transaction->payment_proof,
        ];
    }

}