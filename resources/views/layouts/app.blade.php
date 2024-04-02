<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/chat.css') }}">
    <script defer src="{{ secure_asset('js/index.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="https://fonts.cdnfonts.com/css/font" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
    <!-- CSS pour Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Bibliothèque jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- JS pour Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{secure_asset('css/style.css')}}">
    <!-- JavaScript  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/fr.js"></script>

<!-- connexion jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Connexion Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Connexion de Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Connexion Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <title>@yield('title')</title>
    @yield('head')
    @yield('scripts')

</head>
@stack('scripts')
<body>
    @include('layouts.header')

    @if(isset($includeNavbarClient) && $includeNavbarClient)
        @include('layouts.navbar-client')
    @endif

    <div>
        @yield('content')
    </div>

    <div id="chat-icon" style="position: fixed; bottom: 40px; right: 20px; cursor: pointer;">
        <img src="{{ secure_asset('images/chat-icon.png') }}" alt="Chat Icon" width="50" height="50">
    </div>

    <div id="chat-window" style="display: none;z-index: 1000;">
        <div class="chat-header">
            <div class="btn-chat-header">
                <div></div>
                <p class="chat-title">YunEvo SPORT</p>
            </div>
            <div class="photo-chat-header">
                <img class="photo-chat" src="{{ secure_asset('images/chat.png') }}" alt="photo chat" width="15"
                    height="15">
                <p class="chat-reponse">Nous vous répondrons dès que possible.</p>
            </div>
        </div>
        <div class="chat-content">
        </div>
        <div class="chat-input" style="display: flex" >
            <textarea class="chat-text" id="chat-text" type="text" placeholder="Saisissez votre message..."></textarea>
            <button id="send-message" style="border: none; background: transparent; cursor: pointer; padding-left: 10px;">
                <i class="fas fa-arrow-up" style="font-size: 18px;"></i>
            </button>
        </div>
    </div>

    @include('layouts.footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lorsque le document est chargé
            document.getElementById('chat-icon').addEventListener('click', function() {
                var chatWindow = document.getElementById('chat-window');
                // Affiche ou cache la fenêtre de chat
                chatWindow.style.display = chatWindow.style.display === 'none' ? 'block' : 'none';
            });

            const chatInput = document.getElementById('chat-text'); // Entrée de texte du chat
            const sendMessageButton = document.getElementById('send-message'); // Bouton d'envoi
            const chatContent = document.querySelector('.chat-content'); // Contenu du chat

            // Affiche le message dans le chat
            function displayMessage(message, sender) {
                const messageElement = document.createElement('div');
                const textElement = document.createElement('span'); // Le texte du message
                const iconElement = document.createElement('i'); // L'icône de l'utilisateur ou du bot

                textElement.textContent = message;

                if (sender === 'user') {
                    // Si le message vient de l'utilisateur
                    iconElement.className = 'fas fa-user';
                    messageElement.className = 'message user-message';
                    messageElement.appendChild(iconElement); // Ajoute l'icône à gauche
                    messageElement.appendChild(textElement); // Ajoute le texte à droite
                } else {
                    // Si le message vient du bot
                    iconElement.className = 'fas fa-user-cog';
                    messageElement.className = 'message bot-message';
                    messageElement.appendChild(textElement); // Ajoute le texte à gauche
                    messageElement.appendChild(iconElement); // Ajoute l'icône à droite
                }

                messageElement.style.display = 'flex';
                messageElement.style.alignItems = 'center'; // Centre les éléments verticalement

                chatContent.appendChild(messageElement);
                chatContent.scrollTop = chatContent.scrollHeight; // Fait défiler vers le dernier message
            }

            // Envoie le message
            function sendMessage() {
                var message = chatInput.value.trim();
                if (message) {
                    displayMessage(message, 'user');
                    chatInput.value = ''; // Nettoie le champ d'entrée

                    // Envoie le message au serveur
                    fetch('/send-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Le token CSRF pour la sécurité
                        },
                        body: JSON.stringify({ message: message }) // Le corps de la requête
                    })
                    .then(response => response.json())
                    .then(data => {
                        displayMessage(data.reply, 'bot'); // Affiche la réponse du bot
                    })
                    .catch(error => console.error('Error:', error)); // Gère les erreurs
                }
            }

            // Gère l'appui sur la touche Entrée
            chatInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Empêche la nouvelle ligne
                    sendMessage(); // Envoie le message
                }
            });

            // Gère le clic sur le bouton d'envoi
            sendMessageButton.addEventListener('click', sendMessage);
        });
        </script>


</body>

</html>
