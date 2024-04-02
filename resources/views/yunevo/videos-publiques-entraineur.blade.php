@extends('layouts.app')
@section('title', 'Vidéos publiques entraineur')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/compte-entraineur.css') }}">
@endsection

@section('content')
    <section class="header"></section>
    @include('layouts.navbar-entraineur')
    <h1>Vos vidéos publiques</h1>
    <div class="container">
        <div class="container-videos">
            @forelse ($videosPublic as $video)
                <div id="delete-confirmation-modal-{{ $video->id }}" class="modal">
                    <div class="modal-content">
                        <p>Êtes-vous sûr de vouloir supprimer la vidéo "{{ $video->titre }}" ?</p>
                        <div class="modal-buttons">

                            <button type="button" onclick="confirmDelete('{{ $video->id }}')">Oui</button>
                            <button type="button"
                                onclick="closeDeleteConfirmation('{{ $video->id }}')">Non</button>
                        </div>
                    </div>
                </div>

                <form id="delete-video-form-{{ $video->id }}" action="{{ route('video.destroy', ['video_id' => $video->id]) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

                <div class="video-item">
                    <div class="video-wrapper">
                        <video controls>
                            <source src="{{secure_asset($video->lien_aws) }}" type="video/mp4">
                            Votre navigateur ne supporte pas la vidéo.
                        </video>
                    </div>

                    <h5 class="font-weight-bold">{{ $video->titre }}</h5>
                    <p class="text-break">{{ Str::limit($video->description, 40) }}</p>
                    <div class="category-icons">
                        <a class="btn-custom" href="{{ route('detail-video', ['video_id' => $video->id]) }}">Lire la suite</a>
                        <div class="icons">
                            <a href="{{ route('modifie-video', ['video_id' => $video->id]) }}" class="pen"
                                title="Modifier la video">
                                <img src="{{ secure_asset('images/pen.png') }}" alt="" class="pen">
                            </a>
                            <a class="bin" href="#" onclick="openDeleteConfirmation('{{ $video->id }}')">
                                <img src="{{secure_asset('images/bin.png') }}" alt="" class="bin"
                                    title="Supprimer la video">
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="no-videos-message ">
                    <h3>Vous n'avez pas encore de video. </h3>
                    <p>Ajouter votre première vidéo publique!
                        <a class="" href="{{ route('video-ajoute', ['type' => 'publique']) }}">
                            <img src="{{ asset('images/more.png') }}" alt="" class="more"></a>
                    </p>
                </div>
            @endforelse
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
