@extends('layouts.app')
@section('title', 'Form_blog_modifie')

@section('head')
    <link rel="stylesheet" href="{{secure_asset('css/form.css') }}">
    <script src="{{secure_asset('js/index.js') }}"></script>
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

                        <form method="POST" action="{{ route('blog.update', $blog->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <h5 class="card-title">Modifier un article de blog</h5>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control text-muted" id="titre" name="titre"
                                    placeholder="Titre" value="{{ old('titre', $blog->titre) }}">
                            </div>
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control d-flex justify-content-between">
                                    <label for="photo_profil" class="mr-3 text-muted" id="label-photo-profil">
                                        @if ($blog->lien_aws_photo_blog)
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

                                                <img src="{{secure_asset('/images/image.png') }}" alt="photo profil"
                                                    width="30" height="30">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-description mb-3" data-placeholder="Texte">
                                <textarea class="text-muted" name="texte" id="description-entraineur" rows="5">{{ old('texte', $blog->texte) }}</textarea>
                            </div>

                            <div class="btn-sauvegarder">
                                <button type="submit" class="btn btn-primary btn-custom">Modifier</button>
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
