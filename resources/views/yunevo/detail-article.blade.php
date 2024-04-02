@extends('layouts.app')

@section('title', 'Détail de l\'article')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/detail-article.css') }}">
    <script src="{{ asset('js/index.js') }}"></script>
@endsection

@section('content')
    @if (isset($blog))
        <div class="otsup">
            <div class="container blog-top bg-slightly-gray pb-5">
                <a href="{{ url()->previous() }}" class="btn btn-light mb-4 font-weight-bold">&larr; Revenir</a>

                @if ($blog->entraineur && $blog->entraineur->user)
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column align-items-center">
                            <img src="{{ $blog->entraineur->user->lien_aws_photo_compte }}"
                                alt="{{ $blog->entraineur->user->prenom }} {{ $blog->entraineur->user->nom }}"
                                class="rounded-circle mb-2 image-border image-hover-effect">
                            <h3>{{ $blog->entraineur->user->prenom }} {{ $blog->entraineur->user->nom }}</h3>
                            <p>Date de publication : {{ $blog->date_publication }}</p>
                        </div>

                        <div class="col-md-6">
                            <div class="image-container">
                                <img src="{{ $blog->lien_aws_photo_blog }}" alt="{{ $blog->titre }}"
                                    class="img-fluid mb-2 image-border image-hover-effect">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col text-center">
                    <h3 class="golden-underline">{{ $blog->titre }}</h3>
                    <p>{{ $blog->texte }}</p>
                </div>
            </div>
        </div>
    @else
        <div class="container mt-5 bg-slightly-gray pb-5">
            <p>Article non trouvé</p>
        </div>
    @endif
@endsection
