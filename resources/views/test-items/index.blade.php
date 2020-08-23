@extends('components.card')

@section('card-title', 'TEST ITEMS')

@section('card-content')
{{-- <testitem-datatable new="{{ route('testitems.create') }}" rows="{{ $testitems }}" route="{{ $path }}"
enums="{{ $enums }}" pages="{{ $pages }}">
</testitem-datatable> --}}

<datatable createurl="{{ route('testitems.create') }}" route="{{ $route }}" columns="{{ $columns }}"></datatable>
@endsection
