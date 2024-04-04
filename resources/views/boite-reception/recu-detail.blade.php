@extends('layouts.app')

@section('head')
    <!-- Inclusion des styles spécifiques pour la page de visualisation des messages -->
    <link rel="stylesheet" href="{{ asset('css/boite-reception.css') }}">
@endsection

@section('content')
@include('boite-reception.sous-navbar')
    <h1 class="text-center text-center-text">Boîte de réception</h1>
    <div class="container white-background">
        <div class="row">
            <!-- Barre latérale pour la navigation dans la boîte de réception -->
            <div class="col-12 col-md-3">
                @include('boite-reception.nav-boite')
                {{-- Commander video --}}
                @if(Auth::user() && Auth::user()->user_type == 'entraineur')
                <a href="{{ route('commande-privees-video', ['clientId' => $clientId, 'trainerId' => $trainerId]) }}"
                    class="btn list-group-item list-group-item-action mt-5 custom-bg font-weight-bold  ">Fournir des vidéos</a>
                @endif
            </div>

            <!-- Contenu du message -->
            <div class="col-12 col-md-9">
                <div class="card">
                    <div class="card-header">
                        Détails du message reçu
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Date :</strong>
                            {{ \Carbon\Carbon::parse($message->date_message)->format('d.m.Y H:i') }}</p>
                        <p class="card-title"><strong>De :</strong> {{ $message->expediteur->nom ?? 'Sender Not Found' }}
                            {{ $message->expediteur->prenom ?? '' }}</p>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $message->sujet }}</h6>
                        <p class="card-text">{{ $message->texte_message }}</p>
                        <a href="{{ route('boite-reception.compose', ['replyTo' => $message->expediteur->id]) }}"
                            class="btn btn-primary supprimerUne-btn">Répondre</a>
                        <form id="deleteMessageForm" action="{{ route('boite-reception.destroy', $message->id) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="source"
                                value="{{ request()->is('boite-reception/envoyes*') ? 'sent' : 'recus' }}">
                            <button type="submit" class="btn btn-danger supprimerUne-btn">Supprimer</button>
                        </form>

                        <div id="confirmDeleteModal" class="modal" style="display:none;">
                            <div class="modal-content">
                                <p>Le message sera supprimé pour tous. Voulez-vous vraiment le supprimer ?</p>
                                <div class="modal-buttons">
                                    <button type="button" id="confirmDelete">Oui</button>
                                    <button type="button" id="cancelDelete">Non</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteButton = document.querySelector('.btn-danger');
            var confirmDeleteModal = document.getElementById('confirmDeleteModal');

            var confirmDelete = document.getElementById('confirmDelete');
            var cancelDelete = document.getElementById('cancelDelete');

            deleteButton.addEventListener('click', function(event) {
                event.preventDefault();
                confirmDeleteModal.style.display = 'block';
            });

            confirmDelete.addEventListener('click', function() {
                document.getElementById('deleteMessageForm').submit();
            });

            cancelDelete.addEventListener('click', function() {
                confirmDeleteModal.style.display = 'none';
            });
        });
    </script>
@endsection




