@extends('layouts.app')

@section('title', 'detail-video')

@section('head')
    <!-- Include specific styles for the video-detail page -->
    <link rel="stylesheet" href="{{ asset('css/detail-video.css') }}">

@endsection

@section('content')
    <div class="container video-top bg-slightly-gray pb-5">
        <a href="{{ url()->previous() }}" class="btn btn-light mb-4 font-weight-bold">&larr; Revenir</a>
        <div class="row">
            <div class="col-lg-12 text-center">
                <!-- Video player -->
                <video controls class="img-fluid mb-2 image-border image-hover-effect video-player">
                    <source src="{{ asset($selected_video->lien_aws) }}" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            </div>
        </div>

        <div class="row">
            <div class="col text-start">
                <div class="video-header">
                    <h5 class="font-weight-bold">{{ $selected_video->titre }}</h5>
                </div>
                @if ($selected_video->entraineur)
                    <h6 class="font-weight-bold">
                        <img src="{{ $selected_video->entraineur->user->lien_aws_photo_compte ?? asset('images/profil.jpeg') }}"
                            alt="Avatar Entraineur" title="Profil"  class="avatar-coach">
                        {{ $selected_video->entraineur->user->nom }} {{ $selected_video->entraineur->user->prenom }}
                    </h6>
                    <h6 class="font-weight-bold font-italic">
                        <img src="{{ asset('images/athletics.png') }}" class="logo icon-athletics">
                        {{ $trainerTrainingType }}
                    </h6>
                <p class="text-break">{{ $selected_video->description }}</p>
            </div>
            @endif
        </div>
    </div>

@endsection
