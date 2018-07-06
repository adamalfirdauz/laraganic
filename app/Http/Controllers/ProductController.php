<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Validator;
use Storage;


class ProductController extends Controller
{
    public function pageAdd(){
        $sidebar = 21;
        $head = (object) array();
        $head->title = "Produk";
        $head->subtitle = "Tambah Produk Baru";
        return view('pages.product-add', compact('sidebar', 'head'));
    }
    public function pageUpdate(){
        $sidebar = 22;
        $head = (object) array();
        $head->title = "Produk";
        $head->subtitle = "Update Produk";
        $items = Item::get();
        return view('pages.product-update', compact(
            'sidebar', 
            'head', 
            'items'
        ));
    }

    public function createProduct(Request $request, Item $item){
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'category' => 'required',
            'unit' => 'required',
            'nutrition' => 'required',
            'img' => 'required'
        ]);
        // dd($request);
        $input = $request->all();
        $success = $item->create($input);
        $img = $request->file('img')->store('items/'.$success->id);
        $success->img = $img;
        $success->save();
        return redirect('product/page-add')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduct(Request $request){
        $item = Item::where('id', '=', $request->id)->first();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->description = $request->description;
        $item->category = $request->category;
        $item->unit = $request->unit;
        $item->nutrition = $request->nutrition;
        $item->save();
        // dd($item);

        if($request->hasFile('img')){
            if($item->img){
                Storage::delete($item->img);
            }
            $img = $request->file('img')->store('items/'.$item->id);
            $item->img = $img;
            if(!$item->save()){
                return back()->with('danger', 'Internal server error, silahkan coba lagi.');
            }
            else{
                return back()->with('success', 'Produk berhasil diubah.');
            }
        }
        return back()->with('success', 'Produk berhasil diubah.');
    }

}
