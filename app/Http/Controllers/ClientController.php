<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if($request->input('search'))
        {
            $query->where('cliente_nombre', 'like', '%'. $request->input('search') .'%');
        }
        
        return response()->json($query->get());
    }
}
