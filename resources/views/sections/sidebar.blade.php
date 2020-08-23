<aside class="menu">
    <p class="menu-label">
        General
    </p>
    <ul class="menu-list">
        <li><a class="@if(Route::is('home')) is-active @endif" href="{{ route('home') }}">Dashboard</a></li>
    </ul>
    <p class="menu-label">
        Administration
    </p>
    <ul class="menu-list">
        <li><a class="@if(Route::is('assessments.*')) is-active @endif">Assessments</a></li>
        <li><a href="{{ route('testitems.index') }}" class="@if(Route::is('testitems.*')) is-active @endif">Test
                Items</a></li>
        <li><a href="{{ route('competencies.index') }}"
                class="@if(Route::is('competencies.*')) is-active @endif">Competencies</a></li>
        <li><a class="@if(Route::is('qrcodes.*')) is-active @endif">QR Codes</a></li>
    </ul>
</aside>
