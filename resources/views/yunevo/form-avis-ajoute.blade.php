@extends('layouts.app')
@section('title', 'Form_avis_ajout')

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
                            <div class="mb-4 font-weight-bold text-sm font-italic text-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('nonSuccess'))
                            <div class="mb-4 font-weight-bold text-sm font-italic text-danger text-center">
                                {{ session('nonSuccess') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('ajout-avis') }}">
                            @csrf
                            <h5 class="card-title">Évaluez l'application</h5>
                            <div class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <img class="ajoute-avis" src="{{ secure_asset('images/star.png') }}"
                                        data-active="{{secure_asset('images/star-filled.png') }}"
                                        data-rating="{{ $i }}" alt="Star {{ $i }}" width="30"
                                        height="30" onclick="handleStarClick(this)">
                                @endfor
                                <input type="hidden" name="rating" id="rating" value="">
                            </div>

                            <div class="form-description mb-3" data-placeholder="Décrivez votre expérience (facultatif)">
                                <textarea class="form-control bg-light" name="description" id="description-avis" rows="5">{{ old('description') }}</textarea>
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

    <script>
        function handleStarClick(star) {
            var rating = star.getAttribute('data-rating');
            document.getElementById('rating').value = rating;
            var stars = document.querySelectorAll('.ajoute-avis');
            stars.forEach(function(star) {
                var starRating = star.getAttribute('data-rating');
                if (starRating <= rating) {
                    star.src = star.getAttribute('data-active');
                } else {
                    star.src = '{{ asset('images/star.png') }}';
                }
            });
        }
    </script>
@endsection





