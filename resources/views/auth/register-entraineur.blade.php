@extends('layouts.app')
@section('title', 'Register')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container mt-5 form-inscrire">
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:100px;">
                <div class="card">
                    <div class="card-body">
                        <x-validation-errors class="mb-4" />

                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <h5 class="card-title">Remplissez le formulaire</h5>

                            <div class="form-group mb-3" >
                                <x-input type="text" class="form-control text-muted" id="nom" name="nom" placeholder="Nom" :value="old('nom')" required autofocus autocomplete="nom" />
                            </div>

                            <div class="form-group mb-3">
                                <x-input type="text" class="form-control text-muted" id="prenom" name="prenom" placeholder="Prénom" :value="old('prenom')" required autofocus autocomplete="prenom" />
                            </div>

                            <div class="form-group mb-3">
                                <x-input type="email" class="form-control text-muted" id="email" name="email" placeholder="Email" :value="old('email')" required autocomplete="email" />
                            </div>

                            <div class="form-group mb-3">
                                <x-input type="password" class="form-control text-muted" id="password" name="password" placeholder="Mot de passe" required autocomplete="new-password" />
                            </div>

                            <div class="form-group mb-3">
                                <x-input type="password" class="form-control text-muted" id="password_confirmation" name="password_confirmation" placeholder="Confirmez le mot de passe" required autocomplete="new-password" />
                            </div>
                            <input type="hidden" name="user_type" value="entraineur">
                            <input type="hidden" name="registration_type" value="entraineur">

                            <div class="btn-inscrire">
                                <x-button class="btn btn-primary btn-custom">
                                    {{ __("S'inscrire") }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
