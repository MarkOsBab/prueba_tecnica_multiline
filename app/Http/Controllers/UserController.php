<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if($request->has('search'))
        {
            $query->where('name', 'like', '%'. $request->input('search') .'%');
        }

        return response()->json($query->get());
    }
}
