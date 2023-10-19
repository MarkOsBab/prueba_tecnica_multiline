<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallRequest;
use App\Models\Call;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CallController extends Controller
{
    const TOTAL_PER_PAGE = 3;
    
    public function __construct()
    {
        Client::createTable();
        Call::createTable();   
    }

    public function index(Request $request)
    {
        $query = Call::query();

        if($request->has('user_id'))
        {
            $query->whereHas('users', function($query) use ($request) {
                $query->where('id', $request->input('user_id'));
            });
        }

        if($request->has('client_id'))
        {
            $query->whereHas('clients', function($query) use ($request) {
                $query->where('cliente_id', $request->input('client_id'));
            });
        }

        if($request->has('call_date'))
        {
            $query->whereDate('llamada_fecha', $request->input('call_date'));
        }

        if($request->has('call_observation'))
        {
            $query->where('llamada_observacion', 'like', '%'. $request->input('call_observation') .'%');
        }

        if($request->has('call_phone'))
        {
            $query->where('llamada_telefono', 'like', '%'. $request->input('call_phone') .'%');
        }

        $calls = $query->paginate(self::TOTAL_PER_PAGE);


        return response()->json($calls);
    }

    public function create()
    {
        return view('create_call');
    }

    public function store(CallRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::user();
        
        if(!is_null($user))
        {
            $llamada = Call::create([
                'cliente_id' => $validatedData['cliente_id'],
                'llamada_telefono' => $validatedData['llamada_telefono'],
                'llamada_observacion' => $validatedData['llamada_observacion'],
                'llamada_fecha' => Carbon::now(),
                'user_id' => $user->id,
            ]);
            $llamada->save();
    
            return response()->json([
                'status' => 'Llamada registrada exitosamente.',
                'llamada' => $llamada,
            ]);
        }
        else
        {
            return response()->json(['error' => 'Debe autenticar al usuario.'], Response::HTTP_UNAUTHORIZED);
        }
    }

}
