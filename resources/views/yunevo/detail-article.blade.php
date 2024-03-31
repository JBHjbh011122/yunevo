@extends('layouts.app')

@section('title', 'Detail de l\'article')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/detail-article.css') }}">
    <script src="{{ asset('js/index.js') }}"></script>
@endsection

@section('content')
    @if (isset($blog))
        <div class="container blog-top bg-slightly-gray pb-5">
            <a href="{{ url()->previous() }}" class="btn btn-light mb-4">&larr; Revenir</a>

            @if ($blog->entraineur && $blog->entraineur->user)
                <div class="row">
                    <div class="col-md-6 d-flex flex-column align-items-center">
                        <img src="{{ $blog->entraineur->user->lien_aws_photo_compte }}"
                            alt="{{ $blog->entraineur->user->prenom }} {{ $blog->entraineur->user->nom }}"
                            class="rounded-circle mb-2 image-border image-hover-effect">
                        <h3>{{ $blog->entraineur->user->prenom }} {{ $blog->entraineur->user->nom }}</h3>
                    @endif
                    <p>Date de publication : {{ $blog->date_publication }}</p>
                    </div>
                <div class="col-md-6">
                    <div class="image-container">
                        <img src="{{ $blog->lien_aws_photo_blog }}" alt="{{ $blog->titre }}"
                            class="img-fluid mb-2 image-border image-hover-effect">
                    </div>
                </div>
            </div>

            <div class="col text-center">
                <h3 class="golden-underline">{{ $blog->titre }}</h3>
                <p>{{ $blog->texte }}</p>
            </div>
            @auth
                @if (Auth::user()->id == $blog->entraineur->entraineur_id && $isOwner)
                    <div class="icons">
                        <a href="{{ route('modifie-blog', ['blog' => $blog->id]) }}" class="pen" title="Modifier le blog">
                            <img src="{{ asset('images/pen.png') }}" alt="" class="pen">
                        </a>
                        <a class="bin" href="#" onclick="openDeleteConfirmation('{{ $blog->id }}')">
                            <img src="{{ asset('images/bin.png') }}" alt="" class="bin" title="Supprimer le blog">
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        <div id="delete-confirmation-modal-{{ $blog->id }}" class="modal">
            <div class="modal-content">
                <p>Êtes-vous sûr de vouloir supprimer le blog "{{ $blog->titre }}" ?</p>
                <div class="modal-buttons">

                    <button type="button" onclick="confirmDelete('{{ $blog->id }}')">Oui</button>
                    <button type="button" onclick="closeDeleteConfirmation('{{ $blog->id }}')">Non</button>
                </div>
            </div>
        </div>

        <form id="delete-blog-form-{{ $blog->id }}" action="{{ route('blog.destroy', $blog->id) }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
        </div>
    @else
        <div class="container mt-5 bg-slightly-gray pb-5">
            <p>Article non trouvé</p>
        </div>
    @endif
    <script>
        function openDeleteConfirmation(blogId) {
            document.getElementById('delete-confirmation-modal-' + blogId).style.display = 'block';
        }

        function closeDeleteConfirmation(blogId) {
            document.getElementById('delete-confirmation-modal-' + blogId).style.display = 'none';
        }

        function confirmDelete(blogId) {
            document.getElementById('delete-blog-form-' + blogId).submit();
        }
    </script>
@endsection
