<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <i class="fas fa-tools me-2"></i> Mechanic App
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav">
                <a class="nav-link active" href="/"><i class="fas fa-home me-1"></i> Home</a>


                {{-- @if (Auth::guard('admin')->check() || Auth::guard('customer')->check() || Auth::guard('mechanic')->check())
                    <a class="nav-link" href="/chat"><i class="fas fa-comments me-1"></i> Chat</a>
                @endif --}}



                <!-- Show specific menu items based on the authenticated guard -->
                @if (Auth::guard('admin')->check())
                    <a class="nav-link" href="/dashboard"><i class="fas fa-user-shield me-1"></i> Admin Dashboard</a>
                    <a class="nav-link" href="{{ route('admin_EditProfile', Auth::guard('admin')->user()) }}"><i
                            class="fas fa-user me-1"></i> Admin Profile</a>
                @endif

                @if (Auth::guard('customer')->check())
                    <a class="nav-link" href="{{ route('customer.profile', Auth::guard('customer')->user()->id) }}"><i
                            class="fas fa-user me-1"></i> Customer Profile</a>

                    {{-- <a class="nav-link" href="/mechanics"><i class="fas fa-map-marker-alt me-1"></i> Find Mechanics</a> --}}

                    <a class="nav-link"
                        href="{{ route('emergency.request.create', Auth::guard('customer')->user()) }}"><i
                            class="fas fa-calendar-check me-1"></i> Emergency Request</a>

                    <a class="nav-link" href="{{ route('service-requests.create') }}"><i
                            class="fas fa-calendar-check me-1"></i>Make Service Request</a>

                    <a class="nav-link" href="{{ route('service-requests.index') }}"><i
                            class="fas fa-calendar-check me-1"></i>Own Request</a>
                @endif

                @if (Auth::guard('mechanic')->check())
                    <a class="nav-link" href="{{ route('mechanic.profile', Auth::guard('mechanic')->user()) }}"><i
                            class="fas fa-user-cog me-1"></i> Mechanic Profile</a>

                    <a class="nav-link"
                        href="{{ route('mechanic.emergency.show', Auth::guard('mechanic')->user()) }}"><i
                            class="fas fa-user-cog me-1"></i> Mechanic Requests</a>
                @endif
            </div>

            <!-- Auth Buttons (Right Side) -->
            <div class="navbar-nav ms-auto">
                @if (Auth::guard('admin')->check() || Auth::guard('customer')->check() || Auth::guard('mechanic')->check())
                    <form action="/logout" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white">
                            <i class="fas fa-sign-out-alt me-1"></i> Log Out
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</nav>
