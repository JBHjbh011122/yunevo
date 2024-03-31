@php
$unreadMessagesCount = \App\Models\Message::where('destinataire_id', Auth::id())->where('est_lu', false)->count();
@endphp

<div class="secondary-navbar">
    <ul>
        <li class="nav-item {{ Request::is('compte-client') ? 'active-secondary' : '' }}">
            <a class="nav-link" href="{{ route('compte-client') }}">Compte</a>
        </li>
        <li class="nav-item {{ Request::is('boite-reception/recus') ? 'active-secondary' : '' }}">
            <a class="nav-link" href="{{ route('boite-reception.recus') }}">
                Messages
                @if ($unreadMessagesCount > 0)
                <img src="{{ asset('images/icon-notification.png') }}" alt="Unread Messages" class="notification-icon">
                @endif
            </a>
        </li>
        <li class="nav-item {{ Request::is('videos-privees') ? 'active-secondary' : '' }}">
            <a class="nav-link" href="{{ route('videos-privees') }}">Videos privées</a>
        </li>
    </ul>
</div>


