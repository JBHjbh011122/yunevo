@if ($userType == 'entraineur')
    @include('layouts.navbar-entraineur')
@else
    @include('layouts.navbar-client')
@endif
