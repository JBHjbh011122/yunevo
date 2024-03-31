@extends('layouts.app')

@section('title', 'detail-video')

@section('head')
    <!-- Include specific styles for the video-detail page -->
    <link rel="stylesheet" href="{{ asset('css/detail-video.css') }}">
    <style>
        .video-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .font-weight-bold{margin-bottom: 20px;}
    </style>
@endsection

@section('content')
    <div id="delete-confirmation-modal-{{ $selected_video->id }}" class="modal">
        <div class="modal-content">
            <p>Êtes-vous sûr de vouloir supprimer la vidéo "{{ $selected_video->titre }}" ?</p>
            <div class="modal-buttons">

                <button type="button" onclick="confirmDelete('{{ $selected_video->id }}')">Oui</button>
                <button type="button"
                    onclick="closeDeleteConfirmation('{{ $selected_video->id }}')">Non</button>
            </div>
        </div>
    </div>

    <form id="delete-video-form-{{ $selected_video->id }}" action="{{ route('video.destroy', ['video_id' => $selected_video->id]) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

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
                    @if ($isOwner)
                        <div class="icons">
                            <a href="{{ route('modifie-video', ['video_id' => $selected_video->id]) }}" class="pen"
                                title="Modifier la video">
                                <img src="{{ asset('images/pen.png') }}" alt="" class="pen">
                            </a>
                            <a class="bin" href="#" onclick="openDeleteConfirmation('{{ $selected_video->id }}')">
                                <img src="{{ asset('images/bin.png') }}" alt="" class="bin"
                                    title="Supprimer la video">
                            </a>
                        </div>
                    @endif
                </div>

                @if ($selected_video->entraineur)
                    <h6 class="font-weight-bold">
                        <img src="{{ $selected_video->entraineur->user->lien_aws_photo_compte ?? asset('images/profil.jpeg') }}"
                            alt="Avatar Entraineur" title="Profil" style="height: 30px; width: 30px; border-radius: 50%;">
                        {{ $selected_video->entraineur->user->nom }} {{ $selected_video->entraineur->user->prenom }}
                    </h6>
                    <h6 class="font-weight-bold font-italic">
                        <img src="{{ asset('images/athletics.png') }}" class="logo" style="height: 25px; width: 25px;">
                        {{ $trainerTrainingType }}
                    </h6>
                @endif
                <p class="text-break">{{ $selected_video->description }}</p>
            </div>
        </div>
    </div>
    <script>
        function openDeleteConfirmation(videoId) {
                document.getElementById('delete-confirmation-modal-' + videoId).style.display = 'block';
            }

            function closeDeleteConfirmation(videoId) {
                document.getElementById('delete-confirmation-modal-' + videoId).style.display = 'none';
            }

            function confirmDelete(videoId) {
                document.getElementById('delete-video-form-' + videoId).submit();
            }
        </script>
@endsection
