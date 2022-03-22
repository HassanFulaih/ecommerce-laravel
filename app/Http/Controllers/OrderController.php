<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($id)
    {
        return Order::where('user_id', $id)->get();
    }

    public function store(Request $request)
    {
        $request-> validate([
            'user_id'=> 'required',
            'phone_number'=> 'required|min:11|max:11|regex:/^([0-9\s\-\+\(\)]*)$/',
            'governorate'=> 'required|string',
            'amount'=> 'required',
            'date_time'=> 'required',
            'city'=> 'required|string',
            'products'=> 'required',
            'name'=> 'required|string',
        ]);
        return Order::create($request->all());
    }
}
