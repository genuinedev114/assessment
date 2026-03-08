<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Register - {{ config('app.name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/luxe-ui.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ca00268a38.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="auth-shell">
        <div class="auth-card" data-animate>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="mb-0" style="font-family: 'Sora', sans-serif; font-size: 1.7rem;">{{ config('app.name') }}</h1>
                    <span class="badge badge-pill" style="background: rgba(255, 173, 90, 0.2); color: #ffe3c2; border: 1px solid rgba(255, 173, 90, 0.45);">Create Account</span>
                </div>
                <p class="text-muted mb-4">Create your profile to monitor store performance across all supported brands.</p>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" data-animate>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="d-none" data-flash-type="error" data-flash-title="Registration failed" data-flash-message="{{ $errors->first() }}"></div>
                @endif

                <form method="POST" action="{{ route('register') }}" data-animate>
                    @csrf

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>

                <hr />

                <div class="text-center" data-animate>
                    <p class="text-muted mb-0">Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
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
