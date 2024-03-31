@extends('layouts.app')
@section('title', 'Photo progression du client')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/blog-entraineur.css') }}">
    <script src="{{ asset('js/index.js') }}"></script>
@endsection

@section('content')
    <section class="header"></section>
    @include('layouts.navbar-entraineur')

    <div class="">
        <div class="title-blog">
            <h1>Vos photos de progression</h1>
        </div>
        <a href="{{ route('compte-client') }}" class="btn btn-light mb-4" style="margin-left: 100px;">&larr; Revenir</a>

        <div class="container-articles-blog">
            @forelse ($photos as $photo)
                <div class="article-item-blog">
                    <img src="{{ $photo->lien_aws}}" alt="photo-progression" onclick="openModal('{{ $photo->lien_aws}}')">
                    <div class="category-icons">
                        <div class="photo_icons">
                            <h4 class="date_photo">{{ \Carbon\Carbon::parse($photo->date_image)->format('Y-m-d') }}</h4>
                            <a class="bin_photo" href="#" onclick="openDeleteConfirmation('{{ $photo->id }}')">
                                <img src="{{ asset('images/bin.png') }}" alt="" class="bin"
                                    title="Supprimer le photo">
                            </a>
                        </div>
                    </div>
                    <div id="delete-confirmation-modal-{{ $photo->id }}" class="modal">
                        <div class="modal-content">
                            <p>Êtes-vous sûr de vouloir supprimer le photo  ?</p>
                            <div class="modal-buttons">
                                <button type="button" onclick="confirmDelete('{{ $photo->id }}')">Oui</button>
                                <button type="button"
                                    onclick="closeDeleteConfirmation('{{ $photo->id }}')">Non</button>
                            </div>
                        </div>
                    </div>
                    <form id="delete-photo-form-{{ $photo->id }}" action="{{ route('photo.destroy', $photo->id) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                @empty
                <div class="no-blogs-message">
                    <p>Vous n'avez pas encore de photo. <a href="{{ url('/form-photo-ajoute') }}"><img
                                src="{{ asset('images/more.png') }}" alt="" class="more">Ajouter votre premier
                            photo!</a></p>
                </div>
            @endforelse
        </div>
    </div>
    <div id="photo-modal" class="photo-modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="img01">
    </div>
    <script>
        function openDeleteConfirmation(photoId) {
            document.getElementById('delete-confirmation-modal-' + photoId).style.display = 'block';
        }
        function closeDeleteConfirmation(photoId) {
            document.getElementById('delete-confirmation-modal-' + photoId).style.display = 'none';
        }
        function confirmDelete(photoId) {
            document.getElementById('delete-photo-form-' +photoId).submit();
        }
        function openModal(src) {
            document.getElementById('photo-modal').style.display = "block";
            document.getElementById('img01').src = src;
        }
        function closeModal() {
            document.getElementById('photo-modal').style.display = "none";
        }
    </script>
@endsection
