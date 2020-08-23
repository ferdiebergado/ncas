<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body class="has-navbar-fixed-top is-clipped">
    <div id="app" v-cloak>
        @include('sections.header')
        <section class="section">
            <div class="container is-fluid">
                <div class="columns">
                    @auth
                    <div class="column is-one-fifth-desktop is-one-fifth-tablet">
                        @include('sections.sidebar')
                    </div>
                    @endauth
                    <div class="column">
                        @auth
                        @include('sections.notifications')
                        <div v-if="messages.length > 0">
                            <notification v-for="message in messages" :key="message.id" :id="message.id"
                                :type="message.type" :message="message.message" :file="message.file"
                                :fade="message.fade">
                            </notification>
                        </div>
                        <echo-notification id="{{ Auth::user()->uuid }}"></echo-notification>
                        @endauth
                        @yield('content')
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
