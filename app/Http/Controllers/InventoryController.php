<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;

class InventoryController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'bar_code'          => ['required', 'string', 'max:255'],
            'name'              => ['required', 'string', 'max:255'],
            'brand'             => ['required', 'string', 'max:255'],
            'discription'       => ['required', 'string', 'max:255'],
            'price'             => ['required', 'string', 'max:255'],
            'stack'             => ['required', 'string', 'max:255'],
            'catigory'          => ['required', 'string', 'max:255'],
            'img'               => 'file|mimes:jpeg,png,jpg'
        ]);

        $productImage = null;
        if($request->hasFile('img')){
            $productImage = $request->img->store('products', 'public');
        }

        Products::class([
            'user_id'       => Auth::user('id'),
            'bar_code'      => $request->bar_code,
            'name'          => $request->name,
            'brand'         => $request->brand,
            'discription'   => $request->discription,
            'price'         => $request->price,
            'stack'         => $request->stack,
            'img'           => $productImage,
        ]);

        return redirect('inventory');
    }
}
