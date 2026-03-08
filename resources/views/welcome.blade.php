<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Yum! Brands Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/luxe-ui.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ca00268a38.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="welcome-shell">
        <div class="welcome-panel" data-animate>
            <div class="welcome-grid">
                <div>
                    <h1 class="hero-title mb-3">
                        <i class="fas fa-store-alt"></i> Yum! Brands Dashboard
                    </h1>
                    <p class="text-muted mb-4">A cinematic operations hub for multi-brand franchises with fast interaction, dynamic views, and elegant motion.</p>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard.index') }}" class="btn btn-primary mr-2 mb-2" data-animate>
                                <i class="fas fa-chart-line"></i> Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary mr-2 mb-2" data-animate>
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-secondary mb-2" data-animate>
                                    <i class="fas fa-user-plus"></i> Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <div>
                    <h5 class="mb-3" style="font-family: 'Sora', sans-serif;">Platform Highlights</h5>
                    <div class="feature-grid">
                        <div class="feature-item" data-animate>
                            <i class="fas fa-exchange-alt mr-2"></i>
                            <strong>Brand Context Switching</strong> for instant store segmentation.
                        </div>
                        <div class="feature-item" data-animate>
                            <i class="fas fa-chart-bar mr-2"></i>
                            <strong>Financial Analytics</strong> with direct KPI visualization.
                        </div>
                        <div class="feature-item" data-animate>
                            <i class="fas fa-download mr-2"></i>
                            <strong>Data Export Workflows</strong> with background processing.
                        </div>
                        <div class="feature-item" data-animate>
                            <i class="fas fa-envelope mr-2"></i>
                            <strong>Alerting and Notifications</strong> when data actions complete.
                        </div>
                        <div class="feature-item" data-animate>
                            <i class="fas fa-lock mr-2"></i>
                            <strong>Secure Access</strong> for role-aware operational visibility.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/luxe-ui.js') }}"></script>
</body>
</html>
