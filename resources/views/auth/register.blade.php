@extends('templates.main')

@section('content')
    <h1>Register</h1>
    <div class="card form-container-card">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    name="name"
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    aria-describedby="name"
                    value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <small>{{ $message }}</small>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    name="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    aria-describedby="email"
                    value="{{ old('email') }}">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <small>{{ $message }}</small>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    name="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <small>{{ $message }}</small>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control" id="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
@endsection
