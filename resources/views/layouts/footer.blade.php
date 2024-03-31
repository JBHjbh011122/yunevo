<footer class="custom-footer">
    <div class="container">
        <div class="row justify-content-between">
            <!-- Colonne de gauche -->
            <div class="col-auto">
                <a href="#" target="_blank" class="instagram-link">
                    <div class="footer-item">
                        <a href="https://www.instagram.com/yunevosport/" target="_blank" title="Cliquez ici pour accéder à notre page Instagram">
                            <i class="fab fa-instagram icon"></i> <!-- Icône Instagram -->
                        </a>
                    </div>

                    <div class="footer-item">
                        Suivez-nous sur Instagram. <!-- Texte d'invitation à suivre sur Instagram -->
                    </div>
                </a>
            </div>
            <!-- Colonne du milieu -->
            <div class="col-auto">
                <a href="{{ url('/') }}">
                    <div class="footer-item">
                        &copy; {{ date('Y') }} <!-- Année du droit d'auteur -->
                    </div>
                    <div class="footer-item">
                        YunEvO SPORT <!-- Nom de l'entreprise ou du service -->
                    </div>
                </a>
            </div>
            <!-- Colonne de droite -->
            <div class="col-auto">
                <a href="{{ url('responsabilite') }}" target="_blank" class="responsabilite-link">
                    <div class="footer-item">
                        <img src="{{ asset('images/icon-information.png') }}" alt="footer-icon" width="30" height="30">
                        <!-- Icône de responsabilité (peut être une icône d'information) -->
                    </div>
                    <div class="footer-item">
                        <a href="{{ url('responsabilite') }}" target="_blank" class="responsabilite-link {{ request()->is('responsabilite') ? 'active' : '' }}" title="Cliquez pour accéder à la page de responsabilité">
                            Responsabilité
                        </a>
                    </div>
                </a>
            </div>
        </div>
    </div>
</footer>
