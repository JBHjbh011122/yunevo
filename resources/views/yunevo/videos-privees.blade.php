@extends('layouts.app')

@section('title', 'Vidéos Privées Client')

@php
    use Illuminate\Support\Str;
@endphp

@section('head')
    <link rel="stylesheet" href="{{ asset('css/videos-publiques.css') }}">
@endsection

@php
    $includeNavbarClient = true;
@endphp

@section('content')
    <h1 class="text-center titre-privees text-center-text">Votre vidéos privées</h1>

    <div class="main-container container mt-4 mb-4 priv-titte">
        <div class="dropdown mb-4">
            <button class="btn btn-pr dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Type d'entraînement...
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach ($sortedVideos as $category => $videos)
                <li><a class='dropdown-item scroll-to-category' data-category="{{ Str::slug($category) }}" href='#'>{{ $category }}</a></li>
                @endforeach
            </ul>
        </div>

        @foreach ($sortedVideos as $category => $videos)
            <h3 id="{{ Str::slug($category) }}" class="text-center titre-public mt-0 bg-typ">
                Catégorie d'entraîneur :
                <span class="font-weight-bold font-italic display-6">{{ $category }}</span>
            </h3>
            <div class="container-videos mt-4">
                @foreach ($videos as $video)
                    <div class="video-item">
                        <div class="video-wrapper">
                            <video controls>
                                <source src="{{ $video->lien_aws }}" type="video/mp4">
                                Votre navigateur ne supporte pas la vidéo.
                            </video>
                        </div>

                        @if ($video->entraineur && $video->entraineur->user)
                            <h5 class="font-weight-bold video-info">
                                <img src="{{ $video->entraineur->user->lien_aws_photo_compte ?? asset('images/profil.jpeg') }}"
                                    alt="Avatar Entraineur" title="Profil"
                                    style="height: 30px; width: 30px; border-radius: 50%;">
                                {{ $video->entraineur->user->prenom }} {{ $video->entraineur->user->nom }}
                            </h5>
                        @else
                            <p>Entraîneur non disponible</p>
                        @endif

                        <h6 class="font-weight-bold video-info">
                            <img src="{{ asset('images/athletics.png') }}" class="logo" style="height: 25px; width: 25px;">
                            {{ $category }}
                        </h6>

                        <h6 class="font-weight-bold font-italic video-info">{{ $video->titre }}</h6>
                        <p class="text-break ">{{ Str::limit($video->description, 70) }}</p>
                        <a href="{{ route('detail-video', ['video_id' => $video->id]) }}" title="Lire la suite">Lire la suite</a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <script>
        $(document).ready(function() {
            $('.scroll-to-category').on('click', function(e) {
                e.preventDefault();
                var category = $(this).data('category');
                var offset = $('#' + category).offset().top;
                $('html, body').animate({
                    scrollTop: offset - 200
                }, 1000);
            });
        });
        $(document).ready(function() {
            function initDropdown() {
                $('.dropdown-toggle').dropdown();
            }
            initDropdown();
            $('.dropdown-toggle').on('click', function() {
            });

            $('.modal .close, .modal .btn-secondary').on('click', function() {
             initDropdown();
            });
        });
    </script>
@endsection
