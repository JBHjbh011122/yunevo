@extends('layouts.app')
@section('title', 'Compte d\'entraineur')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/compte-entraineur.css') }}">

@endsection

@section('content')

    <section class="header"></section>

    @include('layouts.navbar-entraineur')

    <div class="container">
        <div class="container-entraineur">
            <div class="grid-container-entraineur">
                <div class="profil">
                    <img class="img-profil" src="{{ $user->lien_aws_photo_compte }}" alt="">
                    <div class="nom-profil">
                        <h3>{{ $user->prenom }} {{ $user->nom }}</h3><br>
                        <h3>{{ $entraineur->categories_d_entraineur }}</h3>
                    </div>
                    <div class="description-profil text-break">
                        <p>{{ $entraineur->description_d_entraineur }}</p>
                    </div>
                    <div class="button-profil">
                        <a href="{{ route('modifie-compte-entraineur', ['entraineur_id' => $entraineur->id]) }}" class="btn-custom">Modifier le compte</a><br><br>
                        <button onclick="openDeleteConfirmation('{{ $user->id }}')" class="btn-custom">Supprimer le compte</button>
                    </div>

                    <div id="delete-confirmation-modal-{{ $user->id }}" class="modal" style="display: none;">
                        <div class="modal-content">
                            <p>Êtes-vous sûr de vouloir supprimer votre compte?</p>
                            <div class="modal-buttons">
                                <button type="button" onclick="confirmDelete('{{ $user->id }}')">Oui</button>
                                <button type="button" onclick="closeDeleteConfirmation('{{ $user->id }}')">Non</button>
                            </div>
                        </div>
                    </div>

                    <form id="delete-form-{{ $user->id }}" action="/entraineur/delete/{{ $user->id }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>

                <div class="droite-compte-entraineur">
                    <div class="videos-publiques">
                        <h3 class="compte-entraineur">
                            <span>
                                <a class="none-link" href="{{ route('voir-public-video') }}">
                                    Videos publiques
                                </a>
                            </span>
                            <a class="" href="{{ route('video-ajoute', ['type' => 'publique']) }}">
                                <img src="{{secure_asset('images/more.png') }}" alt="" class="more"></a>
                        </h3>
                        <div class="container-videos">
                            @foreach ($videosPublic as $video)
                            <a href="{{ route('detail-video', $video->id) }}" class="no-underline-link">
                                <div class="video-item">
                                    <div class="video-wrapper">
                                        <video controls>
                                            <source src="{{ $video->lien_aws }}" type="video/mp4">
                                        </video>
                                    </div>

                                    <h6 class="font-weight-bold">{{ $video->titre }}</h6>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="videos-privees">
                        <h3 class="compte-entraineur">
                            <span><a class="none-link" href="{{ route('voir-privees-video') }}">
                                    Videos privees
                                </a></span>
                                <a class="" href="{{ route('video-ajoute', ['type' => 'privee']) }}">
                                    <img src="{{ secure_asset('images/more.png') }}" alt="" class="more"></a>
                        </h3>
                        <div class="container-videos">
                            @foreach ($videosPrivee as $video)
                            <a href="{{ route('detail-video', $video->id) }}" class="no-underline-link">
                                <div class="video-item">
                                    <div class="video-wrapper">
                                        <video controls>
                                            <source src="{{ $video->lien_aws }}" type="video/mp4">
                                        </video>
                                    </div>

                                    <h6 class="font-weight-bold">{{ $video->titre }}</h6>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="blog">
                        <h3 class="compte-entraineur">
                            <span><a class="none-link" href="{{ url('/blog-entraineur') }}">
                                    Blog
                                </a></span>
                            <a class="" href="{{ url('/form-blog-ajoute') }}"><img
                                    src="{{secure_asset('images/more.png') }}" alt="" class="more"
                                    title="Ajouter un nouveau blog"></a>
                        </h3>
                        <div class="container-blog">
                            <div class="container-articles-blog">

                                @foreach ($articles as $article)
                                    <a href="{{ route('blog.show', $article->id) }}" class="no-underline-link">
                                        <div class="article-item-blog">
                                            <img class="img-blog" src="{{ $article->lien_aws_photo_blog }}"
                                                alt="{{ $article->titre }}">
                                            <div class="category-icons">
                                                <h6 class="font-weight-bold ">{{ $article->titre }}</h6>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function openDeleteConfirmation(userId) {
            document.getElementById('delete-confirmation-modal-' + userId).style.display = 'block';
        }

        function closeDeleteConfirmation(userId) {
            document.getElementById('delete-confirmation-modal-' + userId).style.display = 'none';
        }

        function confirmDelete(userId) {
            document.getElementById('delete-form-' + userId).submit();
        }
    </script>
@endsection
