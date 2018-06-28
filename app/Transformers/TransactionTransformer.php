<?php

namespace App\Transformers;

use App\Transaction;
use App\Item;
use Auth;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract{
    public function transform(Transaction $transaction){
        $item = Item::where('id', '=', $transaction->item_id)->first();
        $collections = Transaction::where('code', '=', $transaction->code)->get();
        $total = 0;
        foreach ($collections as $collection) {
            // dd($collection);
            $total += $collection->price * $collection->qty;
        }
        return [
            'id' => $transaction->id,
            'code' => $transaction->code,
            'user_id' => $transaction->user_id,
            'item_id' => $transaction->item_id,
            'item_name' => $item->name,
            'price' => $transaction->price,
            'qty' => $transaction->qty,
            'total' => $total,
            'status' => $transaction->status,
            'msg' => $transaction->msg,
            'payment_proof' => 'storage/'.$transaction->payment_proof,
            'created_at' => $transaction->created_at,
            'updated_at' => $transaction->updated_at,
        ];
    }

}