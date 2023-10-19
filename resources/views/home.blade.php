@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Panel de control') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container-fluid">
                        <div class="d-flex flex-row flex-wrap align-items-center justify-content-between">
                            <h2>Bienvenido {{ Auth::user()->name }}</h2>
                            <a href="{{ route('calls.create') }}" class="btn btn-primary">Crear Llamada</a>
                        </div>
                        <list-calls></list-calls>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
