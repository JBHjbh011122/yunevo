@extends('layouts.app')
@section('title', 'Compte client')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/compte-client.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')

    <section class="header"></section>

    @include('layouts.navbar-client')

    <div class="container ">
        <div class="container-client">
            <div class="grid-container-client">
                <div class="profil">
                    <img class="img-profil" src="{{ $user->lien_aws_photo_compte }}" alt="">
                    <div class="nom-profil">
                        <h3>{{ $user->prenom }} {{ $user->nom }}</h3><br>
                        @if (isset($taille))
                            <h5>Taille: {{ $taille }} cm</h5><br>
                        @endif
                        @if (isset($poidsDepart))
                            <h5>Poids initial: {{ $poidsDepart }} kg</h5><br>
                        @endif
                        @if (isset($poidsSouhaite))
                            <h5>Poids souhaité: {{ $poidsSouhaite }} kg</h5><br>
                        @endif
                        @if (isset($poidsActuel))
                            <h5>Poids actuel: {{ $poidsActuel }} kg</h5><br>
                        @endif
                    </div>

                    <div class="button-profil">
                        <a href="{{ route('modifie-compte-client', ['client_id' => $client->id]) }}" class="btn-custom-client">Modifier le compte</a><br><br>
                        <button onclick="openDeleteConfirmation('{{ $user->id }}')" class="btn-custom-client">Supprimer le compte</button>
                    </div>

                    <div id="delete-confirmation-modal-{{ $user->id }}" class="modal" style="display: none;">
                        <div class="modal-content">
                            <p>Êtes-vous sûr de vouloir supprimer votre compte?</p>
                            <div class="modal-buttons">
                                <button type="button" onclick="confirmDelete('{{ $user->id }}')">Oui</button>
                                <button type="button" onclick="closeDeleteConfirmation('{{ $user->id }}')">Non</button>
                            </div>
                        </div>
                    </div>

                    <form id="delete-form-{{ $user->id }}" action="/client/delete/{{ $user->id }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>

                <div class="droite-compte-client">
                    <div class="photo-progression">
                        <h3 class="compte-client">
                            <span>
                                <a class="none-link" href="{{ url('/photo-client-progression') }}">
                                    Photo de progression
                                </a>
                            </span>
                            <a class="more" href="{{ url('/form-photo-ajoute') }}"><img
                                    src="{{secure_asset('images/more.png') }}" class="more"></a>
                        </h3><br>

                        <div class="container-client-progression">
                            <div class="container-articles-client">
                                @if (isset($latestPhoto) && $latestPhoto->lien_aws)
                                    <div class="article-item-client">
                                        <img class="img-client" src="{{ $latestPhoto->lien_aws }}" alt="Latest Photo">
                                    </div>
                                @endif

                                @if (isset($secondLatestPhoto) && $secondLatestPhoto->lien_aws)
                                    <div class="article-item-client">
                                        <img class="img-client" src="{{ $secondLatestPhoto->lien_aws }}" alt="Second Latest Photo">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grafique-evoluation">
                        <h3 class="compte-client">
                            <span>Grafique de l'évoluation du poids</span>
                            <a class="more" href="{{ url('/form-poids-ajoute') }}"><img
                                    src="{{ secure_asset('images/more.png') }}" class="more"></a>
                        </h3>
                        <div class="">
                            <div class="container-articles-grafique">
                                <div class="grafique">
                                    <canvas id="myChart" width="300" height="200"></canvas>
                                    <script>
                                        var ctx = document.getElementById('myChart').getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: @json(array_keys($weights)),
                                                datasets: [{
                                                    label: 'Poids',
                                                    data: @json(array_values($weights)),
                                                    borderWidth: 1,
                                                    borderColor: 'rgba(75, 192, 192, 1)',
                                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: false
                                                    }
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                                <div class="imc-cont">
                                    <h5>Votre IMC est:</h5><br>
                                    @if (isset($imc) && isset($signification))
                                        <h3 class="imc">{{ number_format($imc, 2) }}</h3>
                                        <h6> {{ $signification }}</h6>
                                    @else
                                        <p>Les informations IMC ne sont pas disponibles.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openDeleteConfirmation(userId) {
                document.getElementById('delete-confirmation-modal-' + userId).style.display = 'block';
            }

            function closeDeleteConfirmation(userId) {
                document.getElementById('delete-confirmation-modal-' + userId).style.display = 'none';
            }

            function confirmDelete(userId) {
                document.getElementById('delete-form-' + userId).submit();
            }
        </script>
@endsection
