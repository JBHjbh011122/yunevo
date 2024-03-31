@extends('layouts.app')
@section('title', 'Forget Password')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container mt-5 form-inscrire">
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:100px;">
                <div class="card">
                    <div class="card-body">

                        <div class="mb-4 text-sm text-gray-600">
                            {{ __("Vous avez oublié votre mot de passe ? Pas de problème. Indiquez-nous votre adresse d'email et nous vous enverrons un lien de réinitialisation du mot de passe qui vous permettra d'en choisir un nouveau.") }}
                        </div>

                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif

                        <x-validation-errors class="mb-4" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <x-input type="email" class="form-control text-muted" id="email" name="email" placeholder="Email" :value="old('email')" required autocomplete="username" />
                            </div>

                            <div class="btn-inscrire">
                                <x-button class="btn btn-primary btn-custom">
                                    {{ __("Envoyer") }}
                                </x-button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
