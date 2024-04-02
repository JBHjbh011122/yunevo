@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/boite-reception.css') }}">

    <script>
        function matchCustom(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }
            if (typeof data.text === 'undefined') {
                return null;
            }
            var regex = new RegExp("\b" + params.term, 'i');
            if (regex.test(data.text)) {
                var modifiedData = $.extend({}, data, true);
                return modifiedData;
            }
            return null;
        }
        function initSelect2() {
            $('#recipient').select2({
                minimumInputLength: 0,
                matcher: matchCustom,
                placeholder: "Sélectionner un destinataire",
                allowClear: true,
                language: "fr"
            });
        }
        $(document).ready(function() {
            initSelect2();
        });
        $(window).resize(function() {
            $('#recipient').select2('destroy');
            initSelect2();
        });
    </script>

@endsection

@section('content')
@include('boite-reception.sous-navbar')
    <h1 class="text-center text-center-text">Boîte de réception</h1>
    <div class="container white-background ">
        <div class="row">
            <div class="col-md-3">
                @include('boite-reception.nav-boite')
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('boite-reception.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="recipient">Destinataire:</label>
                                <select class="form-control custom-select" id="recipient" name="destinataire_id">
                                    @if ($isNew)
                                        <option value="">Sélectionnez le destinataire</option>
                                    @endif
                                    @foreach ($contactedUsers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $selectedUser && $user->id == $selectedUser->id ? 'selected' : '' }}>
                                            {{ $user->prenom }} {{ $user->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('destinataire_id'))
                                    <span class="text-danger">Le champ destinataire est obligatoire.</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="subject">Sujet:</label>
                                <input type="text" class="form-control" name="sujet" id="subject"
                                    placeholder="Entrez le sujet">
                                @if ($errors->has('sujet'))
                                    <span class="text-danger">Le champ sujet est obligatoire.</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="message">Message:</label>
                                <textarea class="form-control" name="texte_message" id="message" rows="4" placeholder="Entrez le message"></textarea>
                                @if ($errors->has('texte_message'))
                                    <span class="text-danger">Le champ message est obligatoire.</span>
                                @endif
                            </div>
                            <button type="submit" class="btn envoyer-btn">Envoyer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
