<div class="card">
    <header class="card-header {{ $headerClass }}">
        <p class="card-header-title {{ $titleClass }}">
            {{ $title }}
        </p>
        <a href="#" class="card-header-icon" aria-label="more options">
            <span class="icon">
                <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
        </a>
    </header>
    <div class="card-content">
        <div class="content">
            {{$slot}}
        </div>
    </div>
</div>
