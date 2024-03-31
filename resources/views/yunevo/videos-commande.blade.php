@extends('layouts.app')
@section('title', 'Vidéos privées entraineur')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/compte-entraineur.css') }}">
@endsection

@section('content')
    <section class="header"></section>
    @include('layouts.navbar-entraineur')
    <h1>Sélectionner la vidéo à envoyer</h1>
    <div class="container">
        <div class="container-videos">
            @forelse ($videosPrivees as $video)
                <div class="video-item">
                    <div class="video-wrapper">
                        <video controls>
                            <source src="{{ asset($video->lien_aws) }}" type="video/mp4">
                            Votre navigateur ne supporte pas la vidéo.
                        </video>
                    </div>
                    <h5 class="font-weight-bold">{{ $video->titre }}</h5>
                    <p class="text-break">{{ Str::limit($video->description, 40) }}</p>
                    <div class="category-icons">
                        <form method="POST" action="{{ route('commande-ajouter', ['clientId' => $clientId, 'trainerId' => $trainerId, 'videoId' => $video->id]) }}" >
                            @csrf
                            <button type="submit" class="btn btn-custom w-100" title="Accéder à la vidéo">
                                Fournir la vidéo
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="no-videos-message ">
                    <h3>Vous n'avez pas encore de video. </h3>
                    <p>Ajouter votre première vidéo privée!<a href="{{ url('/form-video-ajoute') }}">
                        <img src="{{ asset('images/more.png') }}" alt="" class="more"></a>
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection




