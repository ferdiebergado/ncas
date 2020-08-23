<div class="field is-horizontal">
    <div class="field-label is-normal">
        <label class="label">{{ $label }}</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control">
                <input id="{{ $id }}" name="{{ $id }}" class="input {{ $class }} @error($id) is-danger @enderror"
                    type="{{ $type }}" placeholder="{{ $placeholder }}" value="{{ old($id, $value) }}" @if($required)
                    required @endif @if($autofocus) autofocus @endif>
            </div>
            @error($id)
            <p class="help is-danger" id="{{ $id }}-help">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
