<?php

namespace App\Http\Controllers;

use App\Models\CosmeticOrder;
use Illuminate\Http\Request;

class CosmeticOrderController extends Controller
{
    public function show($id)
    {
        return CosmeticOrder::where('user_id', $id)->get();
    }

    public function store(Request $request)
    {
        $request-> validate([
            'user_id'=> 'required',
            'phone_number'=> 'required|min:11|max:11|regex:/^([0-9\s\-\+\(\)]*)$/',
            'name'=> 'required',
            'governorate'=> 'required|string',
            'amount'=> 'required',
            'date_time'=> 'required',
            'city'=> 'required|string',
            'products'=> 'required',
            'name'=> 'required|string',
        ]);
        return CosmeticOrder::create($request->all());
    }
}
