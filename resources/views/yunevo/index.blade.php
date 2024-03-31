@extends('layouts.app')
@section('title', 'Accueil')

@section('head')

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="main-index">
        <main class="content">
            <section class="intro-image">
                <img src="{{ asset('images/running.png') }}" alt="">
                <div class="text-part">
                    <h2>Bienvenue sur <br> <span class="larger-text">YunEvО SPORT</span> <br>Transformez votre vie, avec une
                        guidance professionnelle à chaque étape.</h2>
                    @if (auth()->guest() ||
                            (!auth()->user()->isClient() &&
                                !auth()->user()->isEntraineur()))
                        <a href="{{ route('login') }}">
                            <button class="btn btn-custom" title="Cliquez pour vous connecter ou vous inscrire">Se
                                connecter</button>
                        </a>
                    @endif
                </div>
            </section>
            <section class="video-publiques column-section">
                <p>Explorez notre catalogue de vidéos publiques pour choisir un entraîneur et trouver le sport qui vous
                    convient. Essayez quelque chose de nouveau et avancez vers la santé et l’harmonie avec YunEnVO SPORT!
                </p>
                <a href="{{ route('videos-publiques') }}" class="btn btn-publiques"
                    title="Cliquez pour accéder à la page vidéo publique">Vidéos publiques</a>
            </section>
            <!-- Section Avantages -->
            <section class="advantages-section">
                <h1 class="title-avan">Avantages des entraînements en ligne</h1>
                <div class="advantage-columns">
                    <!-- Première Colonne -->
                    <div class="advantage-column">
                        <!-- Accessibilité -->
                        <div class="advantage-item">
                            <h3><img class="advantage-icon" src="{{ asset('images/planet.png') }}"
                                    alt="Icône Accessibilité">Accessibilité</h3>
                            <p>Entraînez–vous de n’importe quel endroit du monde, en économisant du temps sur le trajet.</p>
                        </div>
                        <img class="advantage-image" src="{{ asset('images/man.jpg') }}" alt="Image Accessibilité">
                        <!-- Horaire Flexible -->
                        <div class="advantage-item">
                            <h3><img class="advantage-icon" src="{{ asset('images/clock.png') }}"
                                    alt="Icône Horaire Flexible">Horaire flexible</h3>
                            <p>Des entraînements à l'heure qui vous convient.</p>
                        </div>
                    </div>
                    <!-- Deuxième Colonne -->
                    <div class="advantage-column  column-section">
                        <img class="advantage-image" src="{{ asset('images/fit.jpg') }}" alt="Image Choix Variés">
                        <!-- Choix Variés -->
                        <div class="advantage-item">
                            <h3>Choix variés <img class="advantage-icon" src="{{ asset('images/choice.png') }}"
                                    alt="Icône Choix Variés"></h3>
                            <p>Choisissez votre entraîneur préféré sur YunEvo SPORT et l'entraînement qui vous convient.</p>
                        </div>
                        <img class="advantage-image" src="{{ asset('images/yoga.jpg') }}" alt="Image Horaire Flexible">
                    </div>
                </div>
            </section>
            <section class="reviews-section" id="reviewsSection">
                <h2 class="title-avan">Avis de nos utilisateurs</h2>
                <div id="reviewsCarousel" class="carousel slide" data-ride="carousel">
                    <?php
                    $reviews = json_decode(file_get_contents(public_path('data/reviews.json')), true);
                    ?>
                    <!-- Contenu du carrousel -->
                    <div class="carousel-inner">
                        @foreach ($reviews as $index => $review)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="review-container">
                                    <div class="review-left">
                                        <img src="{{ asset($review['img']) }}" alt="{{ $review['name'] }}"
                                            class="carousel-review-image">
                                        <span>{{ $review['name'] }}</span>
                                    </div>
                                    <div class="review-right">
                                        <div class="stars">★★★★☆</div>
                                        <p>{{ $review['review'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Boutons de navigation -->
                    <a class="carousel-control-prev" href="#reviewsCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#reviewsCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
                <a href="{{ route('form-avis-ajoute') }}" title="Cliquez pour laisser votre commentaire">
                    <button>Évaluez l'application</button>
                </a>
            </section>
            <section class="reg-section  column-section">
                <div class="join-team-section">
                    <div class="text-section">
                        <p>Vous rêvez de partager vos compétences et d'aider les autres à atteindre leurs objectifs en
                            matière de fitness ? Rejoignez l'équipe de formateurs professionnels de YunEvo SPORT et aidons
                            ensemble les gens à devenir la meilleure version d’eux–mêmes!</p>
                        <div class="btn-container">
                            @if (auth()->guest() || (auth()->check() && auth()->user()->user_type === 'client'))
                                <a href="{{ route('register-entraineur') }}" class="btn btn-custom"
                                    title="Cliquez pour vous inscrire comme entraîneur">
                                    S'inscrire comme entraîneur
                                </a>
                            @endif
                        </div>
                    </div>
                    <img src="{{ asset('images/fitness.jpg') }}" alt="Entraîneur de Fitness">
                </div>
            </section>
        </main>
    </div>
    <script>
        document.getElementById('reviewsSection').addEventListener('click', function(event) {
            // Vérifier que le clic n'est pas sur un bouton ou un lien de navigation   a href="{{ route('videos-publiques') }}"
            if (!event.target.closest('.carousel-control-prev, .carousel-control-next')) {

                window.location.href = '{{ route('avis') }}';
            }
        });
    </script>
@endsection
