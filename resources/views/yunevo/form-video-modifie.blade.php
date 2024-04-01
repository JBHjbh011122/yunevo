@extends('layouts.app')
@section('title', 'Form_video_modifier')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container mt-5 form-inscrire">
        <a href="{{ url()->previous() }}" class="btn btn-light  font-weight-bold" style="margin-top:100px;">&larr; Revenir</a>
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:10px;">

                <div class="card">
                    <div class="card-body">
                        <x-validation-errors class="mb-4" />

                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('video.update', $video->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <h5 class="card-title">Modifier la vidéo</h5>
                            <!-- Titre -->
                            <div class="form-group mb-3">
                                <input type="text" class="form-control text-muted" id="titre" name="titre"
                                       placeholder="Titre" value="{{ old('titre', $video->titre) }}">
                            </div>
                            <!-- Sélectionner une vidéo -->
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control d-flex justify-content-between">
                                    <label for="video-file" class="mr-3 text-muted" id="label-photo-profil">
                                        @if ($video->lien_aws)
                                            <span id="file-name">Changer la video si besoin</span>
                                        @else
                                            <span id="file-name">Sélectionner une video</span>
                                        @endif
                                    </label>

                                    <div class="photo-profil d-flex">
                                        <div class="form-check form-check-inline">
                                            <label for="video-file" class="photo-profil-link">
                                                <input type="file" class="form-control d-none" id="video-file"
                                                    name="video-file" onchange="updateFileName()">
                                                <span id="file-name"></span>

                                                <img src="{{secure_asset('/images/image.png') }}" alt="photo profil"
                                                    width="30" height="30">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Type -->
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control d-flex justify-content-between">
                                    <label class="mr-3 text-muted">Type</label>
                                    <div class="video d-flex">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="video_type" id="public"
                                                   value="Publique" {{ $video->est_public == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="public">Publique</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="video_type" id="private"
                                                   value="Privee" {{ $video->est_public == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="private">Privée</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="form-description mb-3">
                                <textarea class="text-muted" id="description-video" name="description" rows="3">
                                    {{ old('description', $video->description) }}
                                </textarea>
                            </div>
                            <!-- Bouton de sauvegarde -->
                            <div class="btn-sauvegarder">
                                <button type="submit" class="btn btn-primary btn-custom">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            // Obtenir le paramètre "type de vidéo" de l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const videoType = urlParams.get('type');

            if(videoType) {
                if(videoType === 'publique') {
                    document.getElementById('public').checked = true;
                    document.getElementById('private').disabled = true;
                } else if(videoType === 'privee') {
                    document.getElementById('private').checked = true;
                    document.getElementById('public').disabled = true;
                }
            }
            };

             function updateFileName() {
                                var input = document.getElementById('video-file');
                                var fileName = document.getElementById('file-name');
                                if (input.files && input.files.length > 0) {
                                    //  Mettre à jour le contenu du texte avec le nom du fichier sélectionné
                                    fileName.textContent = input.files[0].name;
                                }
                            }
    </script>
@endsection
