<div class="steps" id="stepsDemo">
    @foreach ($steps as $step)
    <div class="step-item">
        <div class="step-marker">{{ $step['marker'] }}</div>
        <div class="step-details">
            <p class="step-title">{{ $step['title'] }}</p>
        </div>
    </div>
    @endforeach
    <div class="steps-content">
        {{ $slot }}
    </div>
    <div class="steps-actions">
        <div class="steps-action">
            <a href="#" data-nav="previous" class="button is-light">Back</a>
        </div>
        <div class="steps-action">
            <a href="#" data-nav="next" class="button is-primary">Next</a>
        </div>
    </div>
</div>
