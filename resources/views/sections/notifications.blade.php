@if(session()->has('success'))
<div class="notification is-success is-light">
    <button class="delete"></button>
    {{ session('success') }}
</div>
@endif

@if(session()->has('error'))
<div class="notification is-danger is-light">
    <button class="delete"></button>
    {{ session('error') }}
</div>
@endif

@if(session()->has('info'))
<div class="notification is-info is-light">
    <button class="delete"></button>
    {{ session('info') }}
</div>
@endif

@if(session()->has('warning'))
<div class="notification is-warning is-light">
    <button class="delete"></button>
    {{ session('warning') }}
</div>
@endif
