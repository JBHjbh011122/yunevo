@extends('layouts.app')
@section('title', 'Blog antraineur')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/blog-entraineur.css') }}">
    <script src="{{ asset('js/index.js') }}"></script>
@endsection

@section('content')
    <section class="header"></section>
    @include('layouts.navbar-entraineur')

    <div class="">
        <div class="title-blog">
            <h1>Vos blogs</h1>
        </div>
        <a href="{{ route('compte-entraineur') }}" class="btn btn-light mb-4" style="margin-left: 100px;">&larr; Revenir</a>

        <div class="container-articles-blog">

            @forelse ($blogs as $blog)
                <div class="article-item-blog">
                    <img src="{{ $blog->lien_aws_photo_blog }}" alt="{{ $blog->titre }}">
                    <h4>{{ $blog->titre }}</h4>
                    <div class="category-icons">
                        <a class="btn-custom" href="{{ route('blog.show', ['blog_id' => $blog->id]) }}"
                            title="Lire la suite">Lire la suite</a>
                        <div class="icons">
                            <a href="{{ route('modifie-blog', ['blog' => $blog->id]) }}" class="pen"
                                title="Modifier le blog">
                                <img src="{{ asset('images/pen.png') }}" alt="" class="pen">
                            </a>
                            <a class="bin" href="#" onclick="openDeleteConfirmation('{{ $blog->id }}')">
                                <img src="{{ asset('images/bin.png') }}" alt="" class="bin"
                                    title="Supprimer le blog">
                            </a>
                        </div>
                    </div>

                    <div id="delete-confirmation-modal-{{ $blog->id }}" class="modal">
                        <div class="modal-content">
                            <p>Êtes-vous sûr de vouloir supprimer le blog "{{ $blog->titre }}" ?</p>
                            <div class="modal-buttons">
                                <button type="button" onclick="confirmDelete('{{ $blog->id }}')">Oui</button>
                                <button type="button"
                                    onclick="closeDeleteConfirmation('{{ $blog->id }}')">Non</button>
                            </div>
                        </div>
                    </div>

                    <form id="delete-blog-form-{{ $blog->id }}" action="{{ route('blog.destroy', $blog->id) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                @empty
                <div class="no-blogs-message">
                    <p>Vous n'avez pas encore d'articles de blog. <a href="{{ url('/form-blog-ajoute') }}"><img
                                src="{{ asset('images/more.png') }}" alt="" class="more">Créez votre premier
                            blog!</a></p>
                </div>
            @endforelse
        </div>
    </div>
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
