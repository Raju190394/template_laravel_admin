<x-guest-layout>
    <div class="mb-4 text-center">
        <h4 class="fw-bold mb-1">Welcome Back</h4>
        <p class="text-muted small">Please enter your credentials to continue</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label small fw-bold text-muted">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-solid fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control border-start-0 ps-0 rounded-end-3" placeholder="email@school.com" value="{{ old('email') }}" required autofocus>
            </div>
            @if($errors->has('email'))
                <div class="text-danger extra-small mt-1">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold text-muted">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-solid fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control border-start-0 ps-0 rounded-end-3" placeholder="••••••••" required autocomplete="current-password">
            </div>
            @if($errors->has('password'))
                <div class="text-danger extra-small mt-1">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember_me">
                <label class="form-check-label small text-muted" for="remember_me">Keep me signed in</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-primary text-decoration-none fw-medium">Forgot?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-4 shadow-sm">
            Sign In <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
        </button>

        <p class="text-center mb-0 small text-muted">
            New here? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Create Account</a>
        </p>
    </form>
</x-guest-layout>
