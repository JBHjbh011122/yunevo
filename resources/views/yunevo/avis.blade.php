@extends('layouts.app')
@section('title', 'Avis')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/avis.css') }}">
@endsection

@section('content')
    <div class="container">
        <main class="">
            <section class="header"></section>

            <section class="stars">
                <h3 class="">Notes des utilisateurs</h3>

                <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center">
                    <div class="stars-section mb-3 mb-md-0">
                        @php
                            // Détermination du nombre d'étoiles ombrées en fonction des évaluations des utilisateurs
                            $filledStars = round($averageRating); // Arrondir le score moyen au nombre entier le plus proche
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $filledStars)
                                <!-- Si le numéro d'étoile actuel est inférieur ou égal au nombre d'étoiles ombrées, affichez l'étoile ombrée -->
                                <img class="" src="{{ secure_asset('images/star-filled.png') }}" data-active="images/star-filled.png"
                                    data-rating="{{ $i }}" alt="Star {{ $i }}" width="30" height="30">
                            @else
                                <!-- Sinon, affichez une étoile vide -->
                                <img class="" src="{{ secure_asset('images/star.png') }}" data-active="images/star-filled.png"
                                    data-rating="{{ $i }}" alt="Star {{ $i }}" width="30" height="30">
                            @endif
                        @endfor
                    </div>
                    <a href="{{ url('/form-avis-ajoute') }}" class="btn-custom">Évaluez l'application</a>
                </div>
            </section>

            <section class="avis">
                <h3>Avis</h3> <br>
                <div>
                    @foreach ($reviews as $index => $review)
                        <div class="avis-card">
                            <div class="avis-container row align-items-center  mb-0">
                                <div class="avis-left col-md-auto">
                                    <img src="{{ $review->user->lien_aws_photo_compte ??secure_asset('images/profil.jpeg') }}"
                                        alt="Avatar Entraineur" title="Profil"
                                        style="height: 100px; width: 100px; border-radius: 50%;">
                                </div>
                                <div class="avis-right col-md">
                                    <span>{{ $review->user->prenom }} {{ $review->user->nom }}</span>
                                    <div class="star-rating">
                                        @php
                                            // Détermination du nombre d'étoiles ombrées en fonction des évaluations des utilisateurs
                                            $rating = $review->evaluation;
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $rating)
                                                <!-- Si le numéro d'étoile actuel est inférieur ou égal au nombre d'étoiles ombrées, affichez l'étoile ombrée -->
                                                <img class="" src="{{secure_asset('images/star-filled.png') }}"
                                                    data-active="images/star-filled.png" data-rating="{{ $i }}" alt="Star {{ $i }}"
                                                    width="30" height="30">
                                            @else
                                                <!-- Sinon, affichez une étoile vide -->
                                                <img class="" src="{{ secure_asset('images/star.png') }}"
                                                    data-active="images/star-filled.png" data-rating="{{ $i }}" alt="Star {{ $i }}"
                                                    width="30" height="30">
                                            @endif
                                        @endfor
                                    </div><br>
                                    <div class="category-icons">
                                        <p>{{ $review->commentaire }}</p>

                                        <div class="icons">
                                            @if(Auth::check() && $review->personnel_id == Auth::user()->id)
                                                <form id="delete-review-form-{{ $review->id }}" action="{{ route('delete-review', ['id' => $review->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" onclick="document.getElementById('delete-review-form-{{ $review->id }}').submit()">
                                                        <img src="{{ secure_asset('images/bin.png') }}" alt="" class="bin" onmouseover="this.style.transform='scale(2)'" onmouseout="this.style.transform='scale(1)'">
                                                    </a>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </main>
    </div>
@endsection





