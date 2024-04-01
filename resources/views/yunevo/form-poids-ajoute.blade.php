@extends('layouts.app')
@section('title', 'Form-poids-ajoute')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container mt-5 form-inscrire">
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:100px;">
                <div class="card">
                    <div class="card-body">
                        <x-validation-errors class="mb-4" />

                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('ajouter-poids') }}">
                            @csrf
                            <h5 class="card-title">Ajouter le poids</h5>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control text-muted" id="poid" name="poid"
                                    placeholder="poids" value="{{ old('poid') }}">
                            </div>
                            <div class="btn-sauvegarder">
                                <button type="submit" class="btn btn-primary btn-custom">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
