<header id="header">
    <nav class="navbar navbar-expand-xl navbar-light">
        <a class="navbar-brand" href="{{ url('/') }}">YunEvO <img src="{{secure_asset('images/athletics.png') }}" class="logo"> SPORT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobileNav" aria-controls="mobileNav" aria-expanded="false" aria-label="Toggle navigation" id="openNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}">Accueil</a>
                </li>
                <li class="nav-item {{ request()->is('nos-entraineurs') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('nos-entraineurs') }}">Entraîneurs</a>
                </li>
                <li class="nav-item {{ request()->is('allvideos-publiques') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('allvideos-publiques') }}">Vidéos publiques</a>
                </li>
                <li class="nav-item {{ request()->is('blog') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('blog') }}">Blog</a>
                </li>
                @guest
                    <!-- Liens affichés lorsque l'utilisateur n'est pas connecté -->
                    <li class="nav-item {{ request()->is('form-se-connecter') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                    </li>
                @endguest

                @auth
                    <!-- Liens affichés lorsque l'utilisateur est connecté -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Déconnexion
                        </a>
                        <!-- déconnexion -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    <li class="nav-item">
                        @if (Auth::user()->user_type === 'client')
                            <!-- Lien vers le profil du client -->
                            <a class="nav-link" href="{{ url('/compte-client') }}">
                                <!-- Image de l'avatar du client ou image par défaut si elle n'est pas définie -->
                                <img src="{{ Auth::user()->lien_aws_photo_compte ??secure_asset('images/profil.jpeg') }}" alt="Avatar Client" title="Profil" style="height: 55px; width: 55px; border-radius: 50%;">
                            </a>
                        @elseif (Auth::user()->user_type === 'entraineur')
                            <!-- Lien vers la page de profil de l'entraineur -->
                            <a class="nav-link" href="{{ url('/compte-entraineur') }}">
                                <!-- Image de l'avatar de l'entraineur ou image par défaut si elle n'est pas définie -->
                                <img src="{{ Auth::user()->lien_aws_photo_compte ?? secure_asset('images/profil.jpeg') }}" alt="Avatar Entraineur" title="Profil" style="height: 55px; width: 55px; border-radius: 50%;">
                            </a>
                        @endif
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>

<div class="overlay-nav" id="mobileNav">
    <div class="overlay-menu">
        <button class="btn btn-secondary closebtn" id="closeNav">&times;</button>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/') }}">Accueil</a>
            </li>
            <li class="nav-item {{ request()->is('nos-entraineurs') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('nos-entraineurs') }}">Entraîneurs</a>
            </li>
            <li class="nav-item {{ request()->is('allvideos-publiques') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('allvideos-publiques') }}">Vidéos publiques</a>
            </li>
            <li class="nav-item {{ request()->is('blog') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blog') }}">Blog</a>
            </li>
            @guest
                <li class="nav-item {{ request()->is('form-se-connecter') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                </li>
            @endguest

            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Déconnexion
                    </a>
                </li>
                <li class="nav-item">
                    @if (Auth::user()->user_type === 'client')
                        <!-- Lien vers le profil du client -->
                        <a class="nav-link" href="{{ url('/compte-client') }}">
                            <!-- Image de l'avatar du client ou image par défaut si elle n'est pas définie -->
                            <img src="{{ Auth::user()->lien_aws_photo_compte ?? asset('images/profil.jpeg') }}" alt="Avatar Client" title="Profil" style="height: 55px; width: 55px; border-radius: 50%;">
                        </a>
                    @elseif (Auth::user()->user_type === 'entraineur')
                        <!-- Lien vers la page de profil de l'entraineur -->
                        <a class="nav-link" href="{{ url('/compte-entraineur') }}">
                            <!-- Image de l'avatar de l'entraineur ou image par défaut si elle n'est pas définie -->
                            <img src="{{ Auth::user()->lien_aws_photo_compte ?? asset('images/profil.jpeg') }}" alt="Avatar Entraineur" title="Profil" style="height: 55px; width: 55px; border-radius: 50%;">
                        </a>
                    @endif
                </li>
            @endauth
        </ul>
    </div>
</div>
