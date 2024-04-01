@extends('layouts.app')
@section('title', 'Les entraîneurs par catégorie')

@section('head')
    <link rel="stylesheet" href="{{secure_asset('css/form.css') }}">
    <link rel="stylesheet" href="{{secure_asset('css/nos-entraineur.css') }}">
@endsection

@section('content')
    <div class="content">
        <div class="title bg-typ">
            <h1 class="text-center titre-public">Les entraîneurs - <span class="font-weight-bold font-italic">{{ $category?? 'Default Category' }}</span></h1>
        </div>

        <div class="container mt-5 liste-entraineur">

            <a href="{{ url('nos-entraineurs') }}" class="btn btn-light mb-4 font-weight-bold">&larr; Revenir</a>

            <div class="info">
                @foreach ($entraineurs as $entraineur)
                    <div class="entraineur">
                        <div class="info-entraineur row">
                            <div class="col-md-2 mb-4 d-flex align-items-center justify-content-center">
                                <!-- Image du modèle de l'utilisateur -->
                                <img src="{{ $entraineur->user->lien_aws_photo_compte }}" class="rounded-circle"
                                    alt="entraineur" width="130" height="130">
                            </div>
                            <div class="col-md-8 mb-4">
                                <!-- Prenom et Nom du modèle de l'utilisateur -->
                                <h5 class="info-title">
                                    <strong>{{ $entraineur->user->prenom . ' ' . $entraineur->user->nom }}</strong></h5>
                                <!-- Catégorie du modèle Entraineur -->
                                <h5 class="info-title gris">{{ $entraineur->categories_d_entraineur }}</h5>
                                <!-- Description du modèle Entraineur -->
                                <p class="info-text">
                                    {{ $entraineur->description_d_entraineur }}
                                </p>
                            </div>
                            <div class="col-md-2 mb-4 d-flex align-items-center justify-content-center btn-contacter">
                                <a href="{{ route('compose.message', ['entraineurId' => $entraineur->user->id]) }}" class="btn btn-primary btn-custom"
                                    data-tooltip="Envoyer un courriel automatique au entraineur">Contacter</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
