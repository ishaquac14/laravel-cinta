<link rel="stylesheet" href="/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<div class="row justify-content-center mt-5">
    <div class="card col-lg-4 mt-5">
        <main class="form-registration w-100 m-auto">
            <form action="/register" method="post">
                @csrf
                <div class="mt-5 mb-0 text-center">
                    <img src="/images/aisin.png" height="50px" style="margin-bottom: 40px;">
                </div>
            
                <div class="form-floating mt-0">
                  <input type="text" name="name" id="name" placeholder="Name" class="form-control @error('name')is-invalid @enderror" value="{{ old('name') }}" required>
                  <label for="name">Name</label>
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-floating mt-0">
                  <input type="text" name="username" class="form-control @error('username')is-invalid @enderror" id="username" placeholder="Username" value="{{ old('username') }}" required>
                  <label for="username">Username</label>
                  @error('username')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-floating mt-0">
                    <input type="email" name="email" class="form-control @error('email')is-invalid @enderror"  id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                    <label for="email">Email address</label>
                    @error('email')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                <div class="form-floating">
                  <input type="password" name="password" class="form-control @error('password')is-invalid @enderror" id="password" placeholder="Password" required>
                  <label for="password">Password</label>
                  @error('password')
                    <div class="invalid-feedback">
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
                <button class="btn btn-success w-100 py-2" type="submit">Register</button>
                <div class="mt-3 text-center mb-4">
                    <small class="mt-3 mb-3 text-body-secondary">&copy;2023-ITD | Already Registered? <a href="/login">Login</a></small>
                </div>
            </form>
        </main>
    </div>
</div>

  
