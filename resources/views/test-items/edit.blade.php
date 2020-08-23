@extends('components.card')

@section('card-title', 'EDIT TEST ITEM')

@section('card-content')

<form action="{{ route('testitems.update', $testitem) }}" method="POST" @if(app()->environment(['local', 'testing']))
    novalidate
    @endif>
    @csrf
    @method('PUT')
    <testitem-options id="testitem-form" errors="{{ $errors }}"
        request="{{ json_encode(Arr::except(request()->old(), '_token')) }}" model="{{ json_encode($testitem) }}">
    </testitem-options>
    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Timeout*</label>
        </div>
        <div class="field-body">
            <div class="field is-narrow">
                <p class="control">
                    <input type="number" class="input @error('timeout') is-danger @endif" id="timeout" name="timeout"
                        value="{{ old('timeout', $testitem->timeout) }}" min="5" max="600" required>
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
