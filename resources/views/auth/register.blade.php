<x-guest-layout>
    <h3>Sign Up</h3>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-floating mb-3">
            <input type="text" name="name" class="form-control" id="floatingText" placeholder="jhondoe" value="{{ old('name') }}" required autofocus>
            <label for="floatingText">Username</label>
            @if($errors->has('name'))
                <div class="text-danger small">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}" required>
            <label for="floatingInput">Email address</label>
            @if($errors->has('email'))
                <div class="text-danger small">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-floating mb-4">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
            @if($errors->has('password'))
                <div class="text-danger small">{{ $errors->first('password') }}</div>
            @endif
        </div>
        <div class="form-floating mb-4">
            <input type="password" name="password_confirmation" class="form-control" id="floatingPasswordConfirm" placeholder="Confirm Password" required>
            <label for="floatingPasswordConfirm">Confirm Password</label>
        </div>
        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
        <p class="text-center mb-0">Already have an Account? <a href="{{ route('login') }}">Sign In</a></p>
    </form>
</x-guest-layout>
