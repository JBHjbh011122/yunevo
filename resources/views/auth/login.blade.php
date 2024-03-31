@extends('layouts.app')
@section('title', 'Login')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container mt-5 form-connect">
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:100px;">
                <div class="card">
                    <div class="card-body">
                        <x-validation-errors class="mb-4" />

                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('Success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <input type="email" class="form-control text-muted" id="email" name="email" placeholder="Adresse e-mail" required autofocus>
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control text-muted" id="password" name="password" placeholder="Mot de passe" required autocomplete="current-password">
                            </div>

                            <div class="btn-connect">
                                <x-button class="btn btn-primary btn-custom-connect">
                                    {{ __('Se connecter') }}
                                </x-button>
                            </div>

                            <div class="google-connect">
                                <a href="{{ route('google.login', ['provider' => 'google']) }}" target="_blank" class="connect-google">
                                    <p class="google">Se connecter avec Google</p>
                                </a>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="oublie-mot-passe">
                                    <a href="{{ route('password.request') }}" class="mot-passe-oublie">
                                        <p class="form-text text-muted">Mot de passe oublié?</p>
                                    </a>
                                </div>
                            @endif


                            <div class="text-center">
                                <p class="text-pas-incrit">Vous n'êtes pas encore inscrit ?</p>
                                <p class="text-pas-incrit">Inscrivez-vous comme :</p>
                                <div class="btn-group">
                                    <a href="{{ route('register', ['user_type' => 'client']) }}" class="btn btn-primary btn-custom">Client</a>
                                    <a href="{{ route('register', ['user_type' => 'entraineur']) }}" class="btn btn-primary btn-custom">Entraîneur</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
