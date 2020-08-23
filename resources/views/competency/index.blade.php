@extends('components.card')

@section('card-title', 'COMPETENCIES')

@section('card-content')

<datatable createurl="{{ route('competencies.create') }}" route="{{ $route }}" columns="{{ $columns }}"></datatable>

@endsection
