@extends('layouts.app')
@section('title', 'Les entraîneurs par catégorie')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nos-entraineur.css') }}">
@endsection

@section('content')
  <!-- Place pour un formulaire de sortie dans votre HTML -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<!-- Fenêtre modale pour les non-clients -->
<div id="nonClientModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attention</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Seuls les utilisateurs enregistrés en tant que clients peuvent envoyer des messages.</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="logoutAndRegister" class="btn btn-primary">S'inscrire en tant que client</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>

    <div class="content">
        <div class="title bg-typ">
            <h1 class="text-center titre-public">Les entraîneurs - <span class="font-weight-bold font-italic">{{ $category?? 'Default Category' }}</span></h1>
        </div>

        <div class="container mt-5 liste-entraineur">

            <a href="{{ url('nos-entraineurs') }}" class="btn btn-light mb-4 font-weight-bold">&larr; Revenir</a>

            <div class="info">
                @foreach ($entraineurs as $entraineur)
                    <div class="entraineur">
                        <div class="info-entraineur row">
                            <div class="col-lg-2 mb-4 d-flex align-items-center justify-content-center">
                                <!-- Image du modèle de l'utilisateur -->
                                <img src="{{ $entraineur->user->lien_aws_photo_compte }}" class="rounded-circle"
                                    alt="entraineur" width="130" height="130">
                            </div>
                            <div class="col-md-8 mb-4">
                                <!-- Prenom et Nom du modèle de l'utilisateur -->
                                <h5 class="info-title">
                                    <strong>{{ $entraineur->user->prenom . ' ' . $entraineur->user->nom }}</strong></h5>
                                <!-- Catégorie du modèle Entraineur -->
                                <h5 class="info-title gris">{{ $entraineur->categories_d_entraineur }}</h5>
                                <!-- Description du modèle Entraineur -->
                                <p class="info-text">
                                    {{ $entraineur->description_d_entraineur }}
                                </p>
                            </div>
                            <div class="col-lg-2 mb-4 d-flex align-items-center justify-content-center btn-contacter">
                                <a href="{{ route('compose.message', ['entraineurId' => $entraineur->user->id]) }}"
                                    class="btn btn-primary btn-custom"
                                    data-tooltip="Envoyer un courriel automatique au entraineur"
                                    data-is-client="{{ Auth::check() && Auth::user()->user_type === 'client' ? 'true' : 'false' }}">
                                    Contacter
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $('.btn-custom').click(function(e) {
        var isClient = $(this).attr('data-is-client') === 'true';
        if (!isClient) {
            e.preventDefault();
            $('#nonClientModal').modal('show');
        }
    });

    $('.modal .close, .modal .btn-secondary').click(function() {
        $(this).closest('.modal').modal('hide');
    });

    $('#logoutAndRegister').click(function(event) {
        event.preventDefault();
        $('#logout-form').submit();
        setTimeout(function() {
            window.location.href = '/login';
        }, 500);
    });
});
</script>
@endsection
