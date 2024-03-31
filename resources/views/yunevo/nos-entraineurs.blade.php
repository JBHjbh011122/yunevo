@extends('layouts.app')
@section('title', 'Nos entraîneurs')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nos-entraineur.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <div class="title">
            <h1 class="text-center titre-public">Nos entraîneurs</h1>
        </div>
        <div class="container mt-5 liste-entraineur">
            <div class="dropdown mb-4">
                <button class="btn btn-pr dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Sélectionner le type d'entraînement...
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach ($categories as $category)
                        <li><a class='dropdown-item'
                                href="{{ route('entraineurs-par-categorie', ['category' => $category]) }}">{{ $category }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="info">
                @foreach ($entraineurs as $entraineur)
                    <div class="entraineur">
                        <div class="info-entraineur row">
                            <div class="col-md-2 mb-4 d-flex align-items-center justify-content-center">
                                <!-- Image du modèle de l'utilisateur -->
                                <img src="{{ $entraineur->user->lien_aws_photo_compte }}" class="rounded-circle"
                                    alt="entraineur" width="130" height="130">
                            </div>
                            <div class="col-md-8 mb-4">
                                <!-- Prenom et Nom du modèle de l'utilisateur -->
                                <h5 class="info-title">
                                    <strong>{{ $entraineur->user->prenom . ' ' . $entraineur->user->nom }}</strong>
                                </h5>
                                <!-- Catégorie du modèle Entraineur -->
                                <h5 class="info-title gris">{{ $entraineur->categories_d_entraineur }}</h5>
                                <!-- Description du modèle Entraineur -->
                                <p class="info-text">
                                    {{ $entraineur->description_d_entraineur }}
                                </p>
                            </div>
                            <div class="col-md-2 mb-4 d-flex align-items-center justify-content-center btn-contacter">
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
            // Utilisez .attr() pour lire la valeur de l'attribut sous forme de chaîne
            var isClient = $(this).attr('data-is-client') === 'true';

            if (!isClient) {
                e.preventDefault(); // Empêcher le clic sur le lien si ce n'est pas le client
                $('#nonClientModal').modal('show');
            }
            // Pour les clients, l'action par défaut (suivant un lien) sera autorisée
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
