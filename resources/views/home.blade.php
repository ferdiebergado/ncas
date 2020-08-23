@extends('components.card')

@section('card-title')
Dashboard
@endsection

@section('card-content')

@if (session('status'))
<div class="notification is-success">
    {{ session('status') }}
</div>
@endif

{{ __('You are logged in!') }}
@endsection
