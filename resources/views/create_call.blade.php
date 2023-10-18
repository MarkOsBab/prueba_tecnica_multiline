@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrar Llamada') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('calls.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="cliente_id">Cliente:</label>
                            <select name="cliente_id" id="cliente_id" class="form-control">
                                @foreach($clients as $client)
                                    <option value="{{ $client->cliente_id }}">{{ $client->cliente_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="llamada_telefono">Teléfono:</label>
                            <input type="text" name="llamada_telefono" id="llamada_telefono" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="llamada_observacion">Observación:</label>
                            <textarea name="llamada_observacion" id="llamada_observacion" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary my-2">Guardar Llamada</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
