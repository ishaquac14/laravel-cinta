<link rel="stylesheet" href="/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<div class="row justify-content-center mt-5">
    <div class="col-lg-4">

      @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if (session('loginError'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('loginError') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

        <main class="form-signin w-100 m-auto">
            <form action="/login" method="post">
                @csrf
                <div class="mt-5 mb-0 text-center">
                    <img src="/images/aisin.png" height="50px" style="margin-bottom: 40px;">
                </div>
            
                <div class="form-floating mt-0">
                  <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" autofocus required>
                  <label for="email">Email address</label>
                </div>
                <div class="form-floating">
                  <input type="password" name="password" class="form-control @error('email') is-invalid @enderror" id="password" placeholder="Password" value="{{ old('email') }}" required>
                  <label for="password">Password</label>
                  @error('email')
                    <div class="feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
            
                <div class="form-check text-start my-3">
                  <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                    Remember me
                  </label>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
                <div class="mt-3 text-center">
                    <small class="mt-3 mb-3 text-body-secondary">&copy;2023-ITD | Not Registered? <a href="/register">Register Now!</a></small>
                </div>
            </form>
        </main>
    </div>
</div>

  
