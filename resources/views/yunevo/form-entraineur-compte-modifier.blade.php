@extends('layouts.app')
@section('title', 'Form-entraineur-compte-modifier')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
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

                        <form method="POST" action="{{ route('submit-form-entraineur-compte-modifier') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <h5 class="card-title">Modifier le compte</h5>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control text-muted" name="nom"
                                value="{{ old('nom', $user->nom) }}" >
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" class="form-control text-muted" name="prenom"
                                value="{{ old('prenom', $user->prenom) }}" >
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
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control justify-content-between">
                                    <label for="category" class="mr-3 text-muted">Catégories d'entrainement</label>
                                    <div class="category d-flex align-items-center position-relative">
                                        <div class="form-check form-check-inline">
                                            <a href="#" id="category-dropdown-toggle" class="category-link">
                                                <img src="{{ asset('/images/down-arrow.png') }}" alt="category"
                                                    width="30" height="30">
                                            </a>
                                        </div>

                                        <div id="category-dropdown" class="category-select" style="display: none;">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="option1" name="categories" value="CrossFit"
                                                 {{ $entraineur->categories_d_entraineur == 'CrossFit' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="option1">CrossFit</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="option2" name="categories" value="Yoga et méditation"
                                                {{ $entraineur->categories_d_entraineur == 'Yoga et méditation' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="option2">Yoga et méditation</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="option3"
                                                    name="categories" value="Entraînement fonctionnel"
                                                    {{ $entraineur->categories_d_entraineur == 'Entraînement fonctionnel' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="option3">Entraînement fonctionnel</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="option4"
                                                    name="categories" value="Entraînements cardio"
                                                    {{ $entraineur->categories_d_entraineur == 'Entraînements cardio' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="option4">Entraînements cardio</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="option5"
                                                    name="categories" value="Mobilité et étirement"
                                                    {{ $entraineur->categories_d_entraineur == 'Mobilité et étirement' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="option5">Mobilité et étirement</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="option4"
                                                    name="categories" value="Entraînements de danse"
                                                    {{ $entraineur->categories_d_entraineur == 'Entraînements de danse' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="option6">Entraînements de danse</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="option5"
                                                    name="categories" value="Entraînements de force"
                                                    {{ $entraineur->categories_d_entraineur == 'Entraînements de force' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="option7">Entraînements de force</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="option5"
                                                    name="categories" value="Autre"
                                                    {{ $entraineur->categories_d_entraineur == 'Autre' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="option8">Autre</label>
                                            </div>
                                            <div class="button-container">
                                                <button type="button" id="hide-dropdown">X</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Champ pour la description -->
                            <div class="form-description mb-3" data-placeholder="Décrivez-vous">
                                <textarea class="text-muted" name="description" id="description-entraineur" rows="5">
                                    {{ old('description',$entraineur->description_d_entraineur) }}</textarea>
                            </div>
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
        document.getElementById('category-dropdown-toggle').addEventListener('click', function(event) {
            event.preventDefault();
            var dropdown = document.getElementById('category-dropdown');
            dropdown.style.display = 'block';
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('category-dropdown-toggle').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('category-dropdown').style.display = 'block';
            });

            document.getElementById('hide-dropdown').addEventListener('click', function() {
                document.getElementById('category-dropdown').style.display = 'none';
            });

            var categoryOptions = document.getElementsByName('categories');
            var categoryLabel = document.querySelector('label[for="category"]');

            Array.from(categoryOptions).forEach(function(option) {
                option.addEventListener('change', function() {
                    if(option.checked) {
                        categoryLabel.textContent = option.value;
                        document.getElementById('category-dropdown').style.display = 'none';
                    }
                });
            });
        });

        function updateFileName() {
            var input = document.getElementById('photo_profil');
            var fileName = document.getElementById('file-name');
            if (input.files && input.files.length > 0) {
                //  Mettre à jour le contenu du texte avec le nom du fichier sélectionné
                fileName.textContent = input.files[0].name;
            }
        }
    </script>
@endsection
