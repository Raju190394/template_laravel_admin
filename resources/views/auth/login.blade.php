<x-guest-layout>
    <h3>Sign In</h3>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
            <label for="floatingInput">Email address</label>
            @if($errors->has('email'))
                <div class="text-danger small">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-floating mb-4">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required autocomplete="current-password">
            <label for="floatingPassword">Password</label>
            @if($errors->has('password'))
                <div class="text-danger small">{{ $errors->first('password') }}</div>
            @endif
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot Password</a>
            @endif
        </div>
        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
        <p class="text-center mb-0">Don't have an Account? <a href="{{ route('register') }}">Sign Up</a></p>
    </form>
</x-guest-layout>
