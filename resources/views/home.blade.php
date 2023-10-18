@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Bienvenido {{ Auth::user()->name }}</p>

                    <div class="container-fluid">
                        <div class="d-flex flex-row flex-wrap align-items-center justify-content-end">
                            <a href="{{ route('calls.create') }}" class="btn btn-primary">Crear Llamada</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
