@extends('layouts.app')

@section('content')
<div class="columns is-mobile is-centered">
    <div class="column is-half-tablet is-one-third-desktop is-full-mobile">
        <div class="card">
            <header class="card-header has-background-info">
                <p class="card-header-title has-text-white">
                    {{ __('Reset Password') }}
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="field">
                            <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                            <div class="control">
                                <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="help is-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="field is-grouped is-grouped-centered">
                            <div class="control">
                                <button type="submit" class="button is-primary is-rounded">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
