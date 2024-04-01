@extends('layouts.app')

@section('title', 'blog')

@section('head')
    <link rel="stylesheet" href="{{secure_asset('css/blog.css') }}">
@endsection

@section('content')
    <div class="">
        <div class="title-blog">
            <h1>Blog</h1>
            <h3>Votre ressource pour des entraînements efficaces</h3>
        </div>
        <div class="container-articles-blog">
            @foreach ($blogs as $blog)
                <div class="article-item-blog">
                    <img src="{{ $blog->lien_aws_photo_blog }}" alt="{{ $blog->titre }}">
                    <h4>{{ $blog->titre }}</h4>
                    <a href="{{ route('blog.show', ['blog_id' => $blog->id]) }}" title="Lire la suite">Lire la suite</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
