@extends('layouts.app')

@section('content')
<div class="columns is-mobile is-centered">
    <div class="column is-half-tablet is-one-third-desktop is-full-mobile">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    {{ __('Verify Your Email Address') }}
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    @if (session('resent'))
                    <div class="notification is-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="button is-link">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
