@extends('components.card')

@section('card-title', 'VIEW COMPETENCY')

@section('card-content')

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">ID</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $competency->id }}
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">Title</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $competency->title }}
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">Level</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $levels[$competency->level_id] }}
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">Category</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $categories[$competency->category_id] }}
        </div>
    </div>
</div>

<p class="help is-right">Created
    {{ $competency->created_at->diffForHumans() . ' on ' . $competency->created_at }}</p>

<div class="is-clearfix">
    <div class="column is-pulled-right">
        <a class="button is-info" href="{{ route('competencies.edit', $competency) }}">Edit</a>
        <a class="button is-white ml-2" href="{{ route('competencies.index') }}">Close</a>
    </div>
</div>

@endsection
