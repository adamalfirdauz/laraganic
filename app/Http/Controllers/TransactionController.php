<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\User;
use App\Transaction;

class TransactionController extends Controller
{
    public function pageEnter(){
        $sidebar = 31;
        $head = (object) array();
        $head->title = "Transaksi";
        $head->subtitle = "Daftar Transaksi";
        $transactions = Transaction::get();
        $transactions = $transactions->unique('code');
        $i = 0;
        foreach($transactions as $transaction){
            $subtotal = 0;
            $items = Transaction::where('code', '=', $transaction->code)->get();
            $j = 0;
            foreach($items as $item){
                $subtotal += $item->price * $item->qty;
                $temp = Item::select('name', 'category')->where('id', '=', $item->item_id)->first();
                // dd($temp);
                $arr[$j] = $temp;
                $j+=1;
            }
            $transaction->total = $subtotal;
            $transaction->product = $arr;
        }
        // dd($transactions);
        return view('pages.transaction-enter', compact('sidebar', 'head', 'transactions'));
    }
    public function pageSending(){
        $sidebar = 32;
        $head = (object) array();
        $head->title = "Transaksi";
        $head->subtitle = "Transaksi Sedang Dikirim";
        return view('pages.transaction-sending', compact('sidebar', 'head'));
    }
    public function pageAccepted(){
        $sidebar = 33;
        $head = (object) array();
        $head->title = "Transaksi";
        $head->subtitle = "Transaksi Diterima";
        return view('pages.transaction-accepted', compact('sidebar', 'head'));
    }
    public function pageArchive(){
        $sidebar = 34;
        $head = (object) array();
        $head->title = "Transaksi";
        $head->subtitle = "Arsip";
        return view('pages.transaction-archive', compact('sidebar', 'head'));
    }

    public function updateStatus($code, $status){
        $transactions = Transaction::where('code', '=', $code)->get();
        foreach($transactions as $transaction){
            $transaction->status = $status;
            $transaction->save();
        }
        return back()->with('success', 'Update status transaksi berhasil.');
    }
    
    
}
