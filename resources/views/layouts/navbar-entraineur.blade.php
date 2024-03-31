@php
$unreadMessagesCount = \App\Models\Message::where('destinataire_id', Auth::id())->where('est_lu', false)->count();
@endphp

<div class="secondary-navbar">
    <ul>
        <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == '/compte-entraineur.php' ? 'active-secondary' : ''); ?>">
            <a class="nav-link" href="{{ url('/compte-entraineur') }}">Compte</a>
        </li>
        <li class="nav-item {{ Request::is('boite-reception/recus') ? 'active-secondary' : '' }}">
            <a class="nav-link" href="{{ route('boite-reception.recus') }}">
                Messages
                @if ($unreadMessagesCount > 0)
                <img src="{{ asset('images/icon-notification.png') }}" alt="Unread Messages" class="notification-icon">
                @endif
            </a>
        </li>
    </ul>
</div>
