@php
$unreadMessagesCount = \App\Models\Message::where('destinataire_id', Auth::id())->where('est_lu', false)->count();
@endphp

<div class="secondary-navbar">
    <ul>
        <li class="nav-item {{ Request::is('compte-entraineur') ? 'active-secondary' : '' }}">
            <a class="nav-link" href="{{ route('compte-entraineur') }}">Compte</a>
        </li>
        <li class="nav-item {{ Request::is('boite-reception/recus', 'boite-reception/envoyes', 'boite-reception/recu-detail/', 'boite-reception/envoye-detail/', 'boite-reception/compose', 'compose', 'compose/') ? 'active-secondary' : '' }}">
            <a class="nav-link" href="{{ route('boite-reception.recus') }}">
                Messages
                @if ($unreadMessagesCount > 0)
                    <img src="{{ asset('images/notification.png') }}" alt="Unread Messages" class="notification-icon">
                @endif
            </a>
        </li>

    </ul>
</div>
