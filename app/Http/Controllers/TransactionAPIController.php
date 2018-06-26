<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Auth;
use App\Transformers\TransactionTransformer;

class TransactionAPIController extends Controller
{
    public function create(Request $request, Transaction $transaction){
        $this->validate($request, [
            'item_id' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'status' => 'required',
        ]);
        $user = Auth::user();
        $transaction = $transaction->create([
            'user_id' => $user->id,
            'item_id' => $request->item_id,
            'price' => $request->price,
            'qty' => $request->qty,
            'status' => $request->status,
            'msg' => $request->msg,
        ]);
        // String Random Function start
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        // String Random Function end
        $transaction->code =  $randomString . $transaction->id;
        $transaction->save();
        return fractal()
            ->item($transaction)
            ->transformWith(new TransactionTransformer)
            ->toArray();
    }
}
