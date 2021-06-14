@extends('templates.main')

@section('content')
    <h1 class="mt-4">Verify E-mail Address</h1>
        <div class="card form-container-card">
            <p>You must verify your email to access this page.</p>
            <div class="d-flex">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="btn btn-primary" type="submit">Re-Send Verification Email</button>
                </form>
            </div>
        </div>
@endsection
