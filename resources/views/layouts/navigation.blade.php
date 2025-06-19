@auth
    @if (auth()->user()->current_role === 'merchant')
        <!-- Merchant Navigation Bar -->
        @include('layouts.navigation-merchant')
    @else
        <!-- User Navigation Bar -->
        @include('layouts.navigation-user')
    @endif
@else
    <!-- Guest Navigation Bar -->
    @include('layouts.navigation-guest')
@endauth