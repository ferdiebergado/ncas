@extends('layouts.app')

@section('content')
<div class="columns is-mobile is-centered">
    <div class="column is-half-tablet is-one-third-desktop is-full-mobile">
        <div class="card">
            <header class="card-header has-background-info">
                <p class="card-header-title has-text-white">
                    {{ __('Login') }}
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="field">
                            <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                            <div class="control">
                                <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            </div>
                            @error('email')
                            <p class="help is-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password" class="label">{{ __('Password') }}</label>

                            <div class="control">
                                <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="current-password">

                            </div>
                            @error('password')
                            <p class="help is-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="checkbox" for="remember">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                {{ __('Remember Me') }}
                        </div>
                </div>

                <div class="field-is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary is-rounded">
                            {{ __('Login') }}
                        </button>
                        @if (Route::has('password.request'))
                        <a class=" button is-text" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection
