@extends('layouts.app')
@section('title', 'Form_blog_ajoute')

@section('head')
    <link rel="stylesheet" href="{{secure_asset('css/form.css') }}">
    <script src="{{secure_asset('js/index.js') }}"></script>
    <script src="{{ secure_asset('js/prevent-multiple-submissions.js') }}" defer></script>
@endsection

@section('content')
    <div class="container mt-5 form-inscrire">
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:100px;">
                <a href="{{ url()->previous() }}" class="btn btn-light mb-3 font-weight-bold">&larr; Revenir</a>
                <div class="card">
                    <div class="card-body">
                        <x-validation-errors class="mb-4" />

                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('ajout-blog') }}" enctype="multipart/form-data">
                            @csrf
                            <h5 class="card-title">Ajouter un article de blog</h5>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control text-muted" id="titre" name="titre"
                                    placeholder="Titre" value="{{ old('titre') }}">
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control d-flex justify-content-between">
                                    <label id="file-name" for="photo-profil" class="mr-3 text-muted">Sélectionner une
                                        photo</label>
                                    <div class="photo-profil d-flex">
                                        <div class="form-check form-check-inline">
                                            <label for="photo_profil" class="photo-profil-link">
                                                <input type="file" class="form-control d-none" id="photo_profil"
                                                    name="photo_profil" onchange="updateFileName()">
                                                <img src="{{ asset('/images/image.png') }}" alt="photo profil"
                                                    width="30" height="30">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-description mb-3" data-placeholder="Texte">
                                <textarea class="text-muted" name="texte" id="description-entraineur" rows="5">{{ old('texte') }}</textarea>
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
    document.addEventListener('DOMContentLoaded', function() {
        function updateFileName() {
            var input = document.getElementById('photo_profil');
            var fileName = document.getElementById('file-name');
            if (input.files && input.files.length > 0) {
                fileName.textContent = input.files[0].name;
            }
        }

        var fileInput = document.getElementById('photo_profil');
        if (fileInput) {
            fileInput.addEventListener('change', updateFileName);
        }
    });
</script>
@endsection
