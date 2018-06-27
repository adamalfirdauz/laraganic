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

    // public function getTransaction(){
    //     $transactions = Transaction::get();
    //     $item = Item::where('id', '=', '$transactions->item_id')->first()->name;
    //     $user = User::where('id', '=', '$transactions->user_id')->first()->name;
        

    // }
    
    
}
