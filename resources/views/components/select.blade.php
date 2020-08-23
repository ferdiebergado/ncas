<div class="field is-horizontal">
    <div class="field-label is-normal">
        <label class="label">{{ $label }}</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control">
                <div class="select is-fullwidth {{ $class }} @error($id) is-danger @enderror">
                    <select id="{{ $id }}" name="{{ $id }}" @if($required) required @endif @if($autofocus) autofocus
                        @endif>
                        <option value="">Select...</option>
                        @foreach ($options as $option)
                        <option value="{{ $option[$optionValue] }}"
                            {{ old($id) && old($id) == $option[$optionValue] ? 'selected':'' }}>
                            {{ $option[$optionText] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error($id)
            <p class="help is-danger" id="{{ $id }}-help">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
