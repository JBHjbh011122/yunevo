@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/boite-reception.css') }}">
@endsection


@section('content')
@include('boite-reception.sous-navbar')
    <h1 class="text-center">Boîte de réception</h1>
    <div class="container white-background">
        <div class="row">
            <!-- Barre latérale pour la navigation de la boîte de réception -->
            <div class="col-md-3">
                @include('boite-reception.nav-boite')
            </div>
            <!-- Liste des messages -->
            <div class="col-md-9">
                <form id="deleteForm" action="{{ route('boite-reception.destroyMultiple') }}" method="post">
                    @csrf
                    <input type="hidden" name="source"
                        value="{{ request()->is('boite-reception/envoyes*') ? 'sent' : 'recus' }}">

                    <div class="card">
                        <div class="card-header card-cacher">Messages reçus</div>
                        <div class="card-body p-0">
                            <table class="table table-hover m-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 5%;"></th>
                                        <th scope="col">De</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $message)
                                        <tr class='clickable-row {{ $message->est_lu ? 'message-lu' : 'message-non-lu' }}'
                                            data-href='{{ route('boite-reception.showRecu', $message->id) }}'>

                                            <td><input type="checkbox" name="ids[]" class="form-check-input"
                                                    value="{{ $message->id }}"></td>
                                            <td class='clickable-row {{ $message->est_lu ? 'message-lu' : 'message-non-lu' }}'>{{ $message->expediteur->nom }} {{ $message->expediteur->prenom }}</td>
                                            <td class='clickable-row {{ $message->est_lu ? 'message-lu' : 'message-non-lu' }}'><strong>{{ $message->sujet }}</strong><br>{{ Str::limit($message->texte_message, 50) }}
                                            </td >
                                            <td class='clickable-row {{ $message->est_lu ? 'message-lu' : 'message-non-lu' }}'>{{ \Carbon\Carbon::parse($message->date_message)->format('Y.m.d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3 text-right">

                        <button type="submit" id="deleteSelected" class="btn supprimer-btn"
                            style="display:none;">Supprimer</button>
                        <button type="button" id="selectAll" class="btn supprimerUne-btn"
                            style="display:none;">Sélectionner tout</button>
                    </div>
                </form>
                <div id="confirmDeleteModal" class="modal">
                    <div class="modal-content">
                        <p>Le(s) message(s) sera(ont) supprimé(s) pour tous. Voulez-vous vraiment procéder à la suppression ?</p>
                        <div class="modal-buttons">
                            <button type="button" id="confirmDeleteBtn">Oui</button>
                            <button type="button" id="cancelDeleteBtn">Non</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/index.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteSelectedBtn = document.getElementById('deleteSelected');
            var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            var cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            var confirmDeleteModal = document.getElementById('confirmDeleteModal');

            deleteSelectedBtn.addEventListener('click', function(event) {
                event.preventDefault();
                confirmDeleteModal.style.display = 'block';
            });
            confirmDeleteBtn.addEventListener('click', function() {
                document.getElementById('deleteForm').submit();
                confirmDeleteModal.style.display = 'none';
            });
            cancelDeleteBtn.addEventListener('click', function() {
                confirmDeleteModal.style.display = 'none';
            });
        });
    </script>
@endsection
