@extends('layouts.app')

@section('content')
<div class="columns is-mobile is-centered">
    <div class="column is-half-tablet is-one-third-desktop is-full-mobile">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    {{ __('Confirm Password') }}
                </p>
            </header>
            <div class="card-content">
                <div class="content">

                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="field">
                            <label for="password" class="label">{{ __('Password') }}</label>

                            <div class="control">
                                <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="help is-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="is-link" href="{{ route('password.request') }}">
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
@endsection
