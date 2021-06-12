@extends('templates.main')

@section('content')
    <h1 class="mt-4">Login</h1>
    <div class="card form-container-card">
        <form method="POST" action="{{ route('login') }}">
            @csrf
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
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
@endsection
