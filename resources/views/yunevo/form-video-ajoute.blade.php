@extends('layouts.app')
@section('title', 'Form_video_ajoute')

@section('head')
    <link rel="stylesheet" href="{{secure_asset('css/form.css') }}">
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

                        <form method="POST" action="{{ route('ajout-video') }}" enctype="multipart/form-data">
                            @csrf
                            <h5 class="card-title">Ajouter une vidéo</h5>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control text-muted" id="titre" name="titre"
                                    placeholder="Titre" value="{{ old('titre') }}">
                            </div>
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control d-flex justify-content-between">
                                    <label for="video-file" class="mr-3 text-muted">Sélectionner une vidéo</label>
                                    <div class="photo-profil d-flex">
                                        <div class="form-check form-check-inline">
                                            <label for="video-file" class="photo-profil-link">
                                                <input type="file" class="form-control d-none" id="video-file"
                                                    name="video-file" onchange="onFileSelected(event)">
                                                <img src="{{ asset('/images/image.png') }}" alt="photo profil"
                                                    width="30" height="30">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control d-flex justify-content-between">
                                    <label class="mr-3 text-muted">Type</label>
                                    <div class="video d-flex">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="video_type" id="public"
                                                value="Publique">
                                            <label class="form-check-label" for="public">Publique</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="video_type" id="private"
                                                value="Privee">
                                            <label class="form-check-label" for="private">Privée</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-description mb-3" data-placeholder="Description">
                                <textarea class="text-muted" id="description-video" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="btn-sauvegarder">
                                <button type="submit" class="btn btn-primary btn-custom">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
    window.onload = function() {
        // Obtenir les paramètres de type de vidéo à partir de l'URL
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
        function onFileSelected(event) {
    const fileName = event.target.files[0].name;
    const label = document.querySelector('label[for="video-file"]');
    label.textContent = fileName;
}
        </script>
   @endsection

