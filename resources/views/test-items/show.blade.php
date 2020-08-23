@extends('components.card')

@section('card-title', 'VIEW TEST ITEM')

@section('card-content')

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">ID</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $testitem->id }}
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">Competency</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $testitem->competency_id }}
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">Type</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $testitem->type }}
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">Question</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $testitem->question }}
        </div>
    </div>
</div>

@if ($testitem->options)
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">Options</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            <ul>
                @foreach($testitem->options as $opt)
                <li>{{ $opt }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">Answer</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $testitem->answer }}
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">Timeout</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            {{ $testitem->timeout }}
        </div>
    </div>
</div>

<p class="help is-right">Created
    {{ $testitem->created_at->diffForHumans() . ' on ' . $testitem->created_at }}</p>

<div class="is-clearfix">
    <div class="column is-pulled-right">
        <a class="button is-info" href="{{ route('testitems.edit', $testitem) }}">Edit</a>
        <a class="button is-light ml-2" href="{{ route('testitems.index', $testitem) }}">Close</a>
    </div>
</div>
@endsection
