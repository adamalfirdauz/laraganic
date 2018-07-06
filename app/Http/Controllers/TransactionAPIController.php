<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Auth;
use App\Item;
use Storage;
use App\Transformers\TransactionTransformer;

class TransactionAPIController extends Controller
{
    public function create(Request $requests, Transaction $transaction){
        /** String Random Function start
         *  Digunakan untuk kode transaksi
         * Ukurannya 9 + id dari user
         * */
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 9; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $user = Auth::user();
        $code = $randomString . $user->id;
        /** String Random End */
        for ($i=0;$requests[$i]!=null;$i++) {
            $request = $requests[$i];
            // $this->validate($request, [
            //     'item_id' => 'required',
            //     'qty' => 'required',
            // ]);
            $item = Item::where('id', '=', $request['item_id'])->first();
            $transaction = $transaction->create([
                'code' => $code,
                'user_id' => $user->id,
                'item_id' => $request['item_id'],
                'price' => $item->price,
                'qty' => $request['qty'],
                'status' => 1,
                'msg' => $request['msg'],
            ]);
            $item->stock -= $request['qty'];
            $item->save();
            $transactions[$i] = $transaction;
        }
        return fractal()
            ->collection($transactions)
            ->transformWith(new TransactionTransformer)
            ->toArray();
    }

    public function getAll(){
        $user = Auth::user();
        $transactions = Transaction::where('user_id', '=', $user->id)->get();
        $transactions = $transactions->unique('code');
        // $i=0;
        foreach ($transactions as $transaction) {
            $items = Transaction::where('code', '=', $transaction->code)->get();
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item->price * $item->qty;
            }
            $total[$transaction->code] = $subtotal;
            // $i+=1;
        }
        // dd($transactions, $total);
        // return $transactions;
        return fractal()
            ->collection($transactions)
            ->transformWith(new TransactionTransformer)
            ->addMeta([
                $total,
            ])
            ->toArray();
    }

    public function get($code){
        $transactions = Transaction::where('code', '=', $code)->get();
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
        $code = Transaction::where('id', '=', $request->id)->first()->code;
        $transactions = Transaction::where('code', '=', $code)->get();
        if($request->status == 'done'){
            foreach ($transactions as $transaction) {
                $transaction->status = 4;
                $transaction->save();
            }
        }
        if($request->hasFile('payment_proof')){
            $transaction = $transactions[0];
            if($transaction->payment_proof){
                Storage::delete($transaction->payment_proof);
            }
            $payment_proof = $request->file('payment_proof')->store('transaction/payment_proof/'.$transaction->code);
            foreach($transactions as $transaction){
                $transaction->payment_proof = $payment_proof;
                $transaction->status = 2;
                $transaction->save();
            }
        }
        return fractal()
            ->collection($transactions)
            ->transformWith(new TransactionTransformer)
            ->toArray();
    }
}
