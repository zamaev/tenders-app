@extends('layouts/auth')

@section('title')
  Login
@endsection

@section('content')
  <main class="form-signin w-100 m-auto">
    <form method="post" action="{{ route('login') }}">
      <h1 class="h3 mb-3 fw-normal">Login</h1>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @csrf
      <div class="form-floating">
        <input name="email" type="email" class="form-control bnb" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input name="password" type="password" class="form-control bnt" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
      <div class="mb-3 mt-3">
        <a href="{{ route('register') }}">go to register</a>
      </div>
      <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
    </form>
  </main>
@endsection
