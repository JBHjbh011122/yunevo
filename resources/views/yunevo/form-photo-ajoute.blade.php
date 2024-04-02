@extends('layouts.app')
@section('title', 'Form_avis_ajout')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/form.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>

@endsection

@section('content')
    <div class="container mt-5 form-inscrire">
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:100px;">
                <a href="{{ url()->previous() }}" class="btn btn-light font-weight-bold mb-3">&larr; Revenir</a>
                <div class="card">
                    <div class="card-body">
                        <x-validation-errors class="mb-4" />

                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('ajout-photo') }}" enctype="multipart/form-data">
                            @csrf
                            <h5 class="card-title">Ajouter une photo</h5>
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control d-flex justify-content-between">
                                    <label id="file-name" class="mr-3 text-muted">Photo</label>
                                    <div class="photo-profil d-flex">
                                        <div class="form-check form-check-inline">
                                            <label for="photo_profil" class="photo-profil-link">
                                                <input type="file" class="form-control d-none" id="photo_profil"
                                                    name="photo_profil" onchange="updateFileName()">
                                                <span id="file-name"></span>
                                                <img src="{{ asset('/images/image.png') }}" alt="photo profil"
                                                    width="30" height="30">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center form-control d-flex justify-content-between">
                                    <label class="mr-3 text-muted">
                                        <span id="dateLabel">Date de la prise de photo</span>
                                    </label>
                                    <div class="form-check form-check-inline d-flex align-items-center">
                                        <!-- Visible Date Input -->
                                        <input type="text" id="dateInput" name="datePrise" class="form-control"
                                            style="position: absolute; z-index: 2;">
                                        <!-- Calendar Icon -->
                                        <img src="{{ asset('/images/calendar.png') }}" alt="calendar" width="30"
                                            height="30" id="calendarIcon"
                                            style="cursor: pointer; position: relative;background-color:#CFCCBE; z-index: 1200 !important;">
                                    </div>
                                </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateFileName() {
                var input = document.getElementById('photo_profil');
                var fileName = document.getElementById('file-name');
                if (input.files && input.files.length > 0) {
                    fileName.textContent = input.files[0].name;
                }
            }
            document.getElementById('photo_profil').addEventListener('change', updateFileName);
            var calendarIcon = document.getElementById('calendarIcon');
            var fp = flatpickr("#dateInput", {
                onChange: function(selectedDates, dateStr, instance) {

                    document.getElementById('dateLabel').textContent = dateStr;
                },
            });
            calendarIcon.addEventListener('click', function() {
                fp.open();
            });
        });
    </script>
@endsection
