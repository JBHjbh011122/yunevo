@extends('layouts.app')
@section('title', 'Form-client-compte-modifie')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container mt-5 form-inscrire">
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:100px;">
                <a href="{{ url()->previous() }}" class="btn btn-light font-weight-bold mb-3">&larr; Revenir</a>
                <div class="card">
                    <div class="card-body">
                        <x-validation-errors class="mb-4" />

                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('submit-form-client-compte-modifier') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <h5 class="card-title">Modifier le compte</h5>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control text-muted" name="nom"
                                value="{{ old('nom', $user->nom) }}" >
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" class="form-control text-muted" name="prenom"
                                value="{{ old('prenom', $user->prenom) }}">
                            </div>

                            <div class="form-group mb-3">
                                <x-input type="text" class="form-control text-muted" id="poids_depart"
                                    name="poids_depart" placeholder="Poids de depart" :value="old('poids_depart',$client->poids_depart)" required autofocus
                                    autocomplete="poids_depart" />
                            </div>
                            <div class="form-group mb-3">
                                <x-input type="text" class="form-control text-muted" id="poids_desire"
                                    name="poids_desire" placeholder="Poids désiré" :value="old('poids_souhait',$client->poids_souhait)" required
                                    autocomplete="poids_desire" />
                            </div>

                            <div class="form-group mb-3">
                                <x-input type="text" class="form-control text-muted" id="taille" name="taille"
                                    placeholder="Taille" :value="old('taille',$client->taille)" required autofocus autocomplete="taille" />
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control d-flex justify-content-between">
                                    <label for="photo_profil" class="mr-3 text-muted" id="label-photo-profil">
                                        @if ($user->lien_aws_photo_compte)
                                            <span id="file-name">Changer l'image si besoin</span>
                                        @else
                                            <span id="file-name">Sélectionner une photo</span>
                                        @endif
                                    </label>

                                    <div class="photo-profil d-flex">
                                        <div class="form-check form-check-inline">
                                            <label for="photo_profil" class="photo-profil-link">
                                                <input type="file" class="form-control d-none" id="photo_profil"
                                                    name="photo_profil" onchange="updateFileName()">
                                                <span id="file-name"></span>

                                                <img src="{{ asset('/images/image.png') }}" alt="photo profil"
                                                    width="30" height="30">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-sauvegarder">
                                <button type="submit" class="btn btn-primary btn-custom">Sauvegarder</button>
                            </div>
                        </form>
                        <script>
                            function updateFileName() {
                                var input = document.getElementById('photo_profil');
                                var fileName = document.getElementById('file-name');
                                if (input.files && input.files.length > 0) {
                                    //  Mettre à jour le contenu du texte avec le nom du fichier sélectionné
                                    fileName.textContent = input.files[0].name;
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
