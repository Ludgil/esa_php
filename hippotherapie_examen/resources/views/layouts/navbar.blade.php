<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('main.index') }}">Centre d'hippothérapie</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                            Gestion des utilisateurs
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('main.index') ? 'active fw-bold' : '' }}" href="{{ route('main.index') }}">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('week.index') ? 'active fw-bold' : '' }}" href="{{ route('week.index') }}">
                        <i class="bi bi-calendar3"></i> Gestion journalière
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pony.index') ? 'active fw-bold' : '' }}" href="{{ route('pony.index') }}">
                        <i class="bi bi-horse"></i> Gestion des poneys
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.index') ? 'active fw-bold' : '' }}" href="{{ route('customer.index') }}">
                        <i class="bi bi-people"></i> Gestion clientèle
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('billing.index') ? 'active fw-bold' : '' }}" href="{{ route('billing.index') }}">
                        <i class="bi bi-receipt"></i> Gestion facturation
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-decoration-none {{ request()->routeIs('logout') ? 'active fw-bold' : '' }}">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
