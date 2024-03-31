<ul class="list-group">
    <a href="{{ route('boite-reception.recus') }}" class="list-group-item list-group-item-action
       {{ request()->routeIs('boite-reception.recus') || request()->routeIs('boite-reception.showRecu') ? 'active' : '' }}">
        {{ __('Messages reçus') }}
    </a>
    <a href="{{ route('boite-reception.envoyes') }}" class="list-group-item list-group-item-action
       {{ request()->routeIs('boite-reception.envoyes') || request()->routeIs('boite-reception.showEnvoye') ? 'active' : '' }}">
        {{ __('Messages envoyés') }}
    </a>
    <a href="{{ route('boite-reception.compose') }}" class="list-group-item list-group-item-action
   {{ request()->routeIs('boite-reception.compose') || request()->query('replyTo') ? 'active' : '' }}">
    {{ __('Nouveau message') }}
</a>
</ul>



