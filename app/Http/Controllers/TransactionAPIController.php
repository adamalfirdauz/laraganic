<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Auth;
use Storage;
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

    public function getAll(){
        $user = Auth::user();
        $transactions = Transaction::where('user_id', '=', $user->id)->get();
        // return $transactions;
        return fractal()
            ->collection($transactions)
            ->transformWith(new TransactionTransformer)
            ->toArray();
    }

    public function update(Request $request){
        $user = Auth::user();
        $this->validate($request, [
            'id' => 'required',
        ]);
        $transaction = Transaction::where('id', '=', $request->id)->first();
        if($request->status == 'done'){
            $transaction->status = 5;
        }
        if($request->hasFile('payment_proof')){
            if($transaction->payment_proof){
                Storage::delete($transaction->payment_proof);
            }
            $payment_proof = $request->file('payment_proof')->store('transaction/payment_proof/'.$transaction->code);
            $transaction->payment_proof = $payment_proof;
            $transaction->status = 2;
        }
        $transaction->save();
        return fractal()
            ->item($transaction)
            ->transformWith(new TransactionTransformer)
            ->toArray();
    }
}
