<?php

namespace App\Http\Controllers;

use App\Models\UserFavorite;
use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function index()
    {
        return UserFavorite::all();
    }

    public function update(Request $request, $id)
    {
        $request-> validate([
            'user_id'=> 'required',
            'produts_id'=> 'required',
        ]);
        $user = UserFavorite::where('user_id', $id)->first();
        if(!$user){
            return UserFavorite::create($request->all());
        }
        $user->update($request->all());
        return $user;
    }
}
