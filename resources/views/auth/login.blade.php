<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign In</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <p class="mb-1">
                    <x-nav-link href="#" class="text-center">
                        {{ __('Forgot password?') }}
                    </x-nav-link>
                </p>
                <div class="social-auth-links text-center mb-3">
                    <x-primary-button class="text-center">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
            <p class="mb-0 text-center">
                Are You New? <x-nav-link href="{{ route('register') }}">
                    {{ __('Create Account') }}
                </x-nav-link>
            </p>
        </div>
    </div>
</x-guest-layout>