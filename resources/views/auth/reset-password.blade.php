@extends('layouts.app')
@section('title', 'Register')

@section('head')
    <link rel="stylesheet" href="{{secure_asset('css/form.css')}}">
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

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <h5 class="card-title">Réinitialiser le mot de passe</h5>
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                            <div class="form-group mb-3">
                                <p id="email" class="form-control text-muted">
                                    {{ old('email', $request->email) }}
                                </p>
                            </div>

                            <div class="form-group mb-3">

                                <x-input id="password" class="form-control text-muted" type="password" name="password" placeholder="Mot de passe" required autocomplete="new-password" />
                            </div>

                            <div class="form-group mb-3">

                                <x-input id="password_confirmation" class="form-control text-muted" type="password" name="password_confirmation" placeholder="Confirmez le mot de passe" required autocomplete="new-password" />
                            </div>

                            <div class="btn-inscrire">
                                <x-button class="btn btn-primary btn-custom">
                                    {{ __('Reset') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
