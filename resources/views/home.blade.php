@extends('layouts.app')

@section('subtitulo')
    <p>Teste</p>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @auth
                        <p>{{ Auth::user()->name }}</p>
                    @else
                        <p>Bemvindo!</p>
                        <p>Pode fazer o login
                            <a href="{{ route('login') }}">aqui</a>
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
