@extends('layouts.app')

@section('title', 'videos-publiques')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/videos-publiques.css') }}">
@endsection

@section('content')
    <h1 class="text-center titre-public">Vidéos publiques</h1>
    <div class="main-container  container mt-4 mb-4 ">
        <div class="dropdown mb-4">
            <button class="btn btn-pr dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Sélectionner le type d'entraînement...
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach ($trainerCategories as $category)
                    <li><a class='dropdown-item'
                            href='{{ route('videos-par-categorie', $category) }}'>{{ $category }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="container-videos">
            @foreach ($allPublicVideos as $video)
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
                        {{ $video->entraineur->categories_d_entraineur }}
                    </h6>
                    <h6 class="font-weight-bold font-italic video-info">{{ $video->titre }}</h6>
                    <p class="text-break ">{{ Str::limit($video->description, 70) }}</p>
                    <a href="{{ route('detail-video', ['video_id' => $video->id]) }}" title="Lire la suite">Lire la suite</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
