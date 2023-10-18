<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallRequest;
use App\Models\Call;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Client::createTable();
        Call::createTable();   
    }

    public function create()
    {
        $clients = Client::all();
        return view('create_call', compact('clients'));
    }

    public function store(CallRequest $request)
    {
        $validatedData = $request->validated();
        $llamada = Call::create([
            'cliente_id' => $validatedData['cliente_id'],
            'llamada_telefono' => $validatedData['llamada_telefono'],
            'llamada_observacion' => $validatedData['llamada_observacion'],
            'llamada_fecha' => Carbon::now(),
            'user_id' => Auth::user()->id
        ]);
        $llamada->save();

        return redirect()->route('home')->with('status', 'Llamada registrada exitosamente.');
    }

}
