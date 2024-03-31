@extends('layouts.app')
@section('title', 'Vidéos publiques')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/compte-entraineur.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <section class="header"></section>
    @include('layouts.navbar-entraineur')

    <div class="container">

        <a href="{{ url()->previous() }}" class="btn btn-light  mt-4 font-weight-bold">&larr; Revenir</a>

        <div class="container mt-5 form-inscrire">
            <div class="row">
                <div class="col-md-6 mx-auto" style="margin-top:40px;">
                    <div class="card">
                        <div class="card-body">

                            <form id="deleteVideoForm" action="{{ route('delete-video', ['video_id' => $video->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')

                                <h5 class="card-title">Êtes-vous sûr de vouloir supprimer cette vidéo ?</h5>
                                <button type="submit" class="btn btn-primary btn-custom ">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@endsection
