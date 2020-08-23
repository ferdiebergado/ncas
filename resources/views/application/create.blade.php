@extends('layouts.base')

@section('content')
<div class="columns is-centered">
    <div class="column is-half-tablet is-half-desktop">
        <h1 class="title">NCAS</h1>
        <h2 class="subtitle">National Competency Assessment System</h2>
        <x-card title="NEW ASSESSMENT APPLICATION" header-class="has-background-light">
            <form action="{{ route('applications.store') }}" method="POST">
                @csrf
                <x-steps :steps="$steps">
                    <div class="step-content">
                        <fieldset>
                            <x-input label="Last Name" id="last_name" placeholder="Last Name" required="true"
                                autofocus="true">
                            </x-input>
                            <x-input label="First Name" id="first_name" placeholder="First Name" required="true">
                            </x-input>
                            <x-input label="Middle Name" id="middle_name" placeholder="Middle Name"></x-input>
                            <x-select label="Sex" id="sex" :options="$sex" option-value="value" option-text="text">
                            </x-select>
                            <x-input label="Mobile" id="mobile" placeholder="Mobile" required></x-input>
                            <x-input label="Email" id="email" type='email' placeholder="Email" required></x-input>
                            {{-- <x-button class="is-primary is-pulled-right mt-3" type="submit" label="Submit">
                    </x-button> --}}
                        </fieldset>
                    </div>
                    <div class="step-content">
                        <fieldset>
                            <qualification-select></qualification-select>
                        </fieldset>
                    </div>
                    <div class="step-content">
                        <p>Payment feature coming soon...</p>
                    </div>
                    <div class="step-content">
                        <h5>Application completed.</h5>
                        <p>A link will be sent to your email to access the online assessment.</p>
                    </div>
                </x-steps>
            </form>
        </x-card>
    </div>
</div>
@endsection
