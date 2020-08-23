@extends('components.card')

@section('card-title', 'NEW TEST ITEM')

@section('card-content')

<form action="{{ route('testitems.store') }}" method="POST" @if(app()->environment(['local', 'testing']))
    novalidate
    @endif>
    @csrf
    <testitem-options id="testitem-form" errors="{{ $errors }}" request="{{ $request ?? '' }}" model="{{ $testitem }}"
        competencies="{{ $allCompetencies }}">
    </testitem-options>
    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Timeout (in seconds)*</label>
        </div>
        <div class="field-body">
            <div class="field is-narrow">
                <p class="control">
                    <input type="number" class="input @error('timeout') is-danger @endif" id="timeout" name="timeout"
                        value="{{ old('timeout', 15) }}" min="5" max="600" required>
                </p>
                @error('timeout')
                <p class="help is-danger" id="timeout-help">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
    <div class="field is-horizontal mb-3">
        <div class="field-label">
        </div>
        <div class="field-body">
            <p class="control">
                <button id="btn-submit" class="button is-success is-rounded" type="submit">Save</button>
            </p>
        </div>
    </div>
</form>

@endsection
