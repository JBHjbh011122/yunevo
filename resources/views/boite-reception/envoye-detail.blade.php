@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/boite-reception.css') }}">
@endsection

@section('content')
@include('boite-reception.sous-navbar')
    <h1 class="text-center text-center-text">Boîte de réception</h1>
    <div class="container white-background">
        <div class="row">
            <div class="col-md-3">
                @include('boite-reception.nav-boite')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Détails du message envoyé
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Date :</strong>
                            {{ \Carbon\Carbon::parse($message->date_message)->format('d.m.Y H:i') }}</p>
                        <p class="card-text"><strong>À :</strong> {{ $message->destinataire->nom }}
                            {{ $message->destinataire->prenom }}</p>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $message->sujet }}</h6>
                        <p class="card-text">{{ $message->texte_message }}</p>
                        <button class="btn btn-danger supprimerUne-btn" id="openConfirmModal">Supprimer</button>


                        <div id="confirmDeleteModal" class="modal" style="display:none;">
                            <div class="modal-content">
                                <p>Le message sera supprimé pour tous. Voulez-vous vraiment le supprimer ?</p>
                                <div class="modal-buttons">
                                    <button type="button" id="confirmDelete">Oui</button>
                                    <button type="button" id="cancelDelete">Non</button>
                                </div>
                            </div>
                        </div>

                        <form id="deleteMessageForm" action="{{ route('boite-reception.destroy', $message->id) }}"
                            method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="source"
                                value="{{ request()->is('boite-reception/envoyes*') ? 'sent' : 'recus' }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var openConfirmModalButton = document.getElementById('openConfirmModal');
            var confirmDeleteModal = document.getElementById('confirmDeleteModal');
            var confirmDeleteButton = document.getElementById('confirmDelete');
            var cancelDeleteButton = document.getElementById('cancelDelete');

            openConfirmModalButton.addEventListener('click', function(event) {
                event.preventDefault();
                confirmDeleteModal.style.display = 'block';
            });

            confirmDeleteButton.addEventListener('click', function() {
                document.getElementById('deleteMessageForm').submit();
            });

            cancelDeleteButton.addEventListener('click', function() {
                confirmDeleteModal.style.display = 'none';
            });
        });
    </script>
@endsection
