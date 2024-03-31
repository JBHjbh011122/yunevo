@extends('layouts.app')
@section('title', 'Choose-type')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container mt-5 form-connect">
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:100px;">
                <div class="card">
                    <div class="card-body">
                        <x-validation-errors class="mb-4" />

                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('Success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('update-user-type') }}">
                            @csrf
                            <div class="text-center">
                                <p class="text-pas-incrit">Vous n'êtes pas encore inscrit ?</p>
                                <p class="text-pas-incrit">Inscrivez-vous comme :</p>
                                <div class="btn-group">
                                    <button type="submit" name="user_type" value="client"
                                        class="btn btn-primary btn-custom">Client</button>
                                    <button type="submit" name="user_type" value="entraineur"
                                        class="btn btn-primary btn-custom">Entraîneur</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
