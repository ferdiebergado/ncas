@extends('components.card')

@section('card-title', 'CREATE NEW COMPETENCY')

@section('card-content')

<form action="{{ route('competencies.store') }}" method="POST" @if(app()->environment(['local', 'testing']))
    novalidate
    @endif>
    @csrf
    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Title*</label>
        </div>
        <div class="field-body">
            <div class="field is-fullwidth">
                <p class="control">
                    <input type="text" class="input {{ $errors->has('title') ? 'is-danger':'' }}" id="title"
                        name="title" value="{{ old('title') }}" min="3" max="200" placeholder="Title" required
                        autofocus>
                </p>
                @error('title')
                <p class="help is-danger" id="help-title">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
    {{-- <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Level*</label>
        </div>
        <div class="field-body">
            <div class="field is-narrow">
                <div class="control">
                    <div id="select-level" class="select is-fullwidth {{ $errors->has('level_id') ? 'is-danger':'' }}">
    <select id="level_id" name="level_id" required>
        <option value>Select...</option>
        @foreach ($levels as $key => $value)
        <option value="{{ $key }}" {{ old('level_id') && old('level_id') == $key ? 'selected':'' }}>
            {{ $value }}
        </option>
        @endforeach
    </select>
    </div>
    </div>
    @error('level_id')
    <p class="help is-danger" id="help-level">{{ $message }}</p>
    @enderror
    </div>
    </div>
    </div> --}}
    {{-- <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Category*</label>
        </div>
        <div class="field-body">
            <div class="field is-narrow">
                <div class="control">
                    <div id="select-category"
                        class="select is-fullwidth {{ $errors->has('category_id') ? 'is-danger':'' }}">
    <select id="category_id" name="category_id" required>
        <option value>Select...</option>
        @foreach ($categories as $key => $value)
        <option value="{{ $key }}" {{ old('category_id') && old('category_id') == $key ? 'selected':'' }}>{{ $value }}
        </option>
        @endforeach
    </select>
    </div>
    </div>
    @error('category_id')
    <p class="help is-danger" id="help-category">{{ $message }}</p>
    @enderror
    </div>
    </div>
    </div> --}}
    <div class="field is-horizontal mb-3">
        <div class="field-label">
        </div>
        <div class="field-body">
            <p class="control">
                <button id="btn-submit" class="button is-success is-rounded" type="submit">Save</button>
                <a class="button is-white ml-2" href="{{ route('competencies.index') }}">Close</a>
            </p>
        </div>
    </div>
</form>

@endsection
