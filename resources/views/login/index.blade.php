<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | CINTA</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    {{-- Link ke CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-gradient-primary d-flex align-items-center justify-content-center vh-100" style="background-color: rgb(34, 34, 106);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-lg-4 col-md-8 col-sm-10">

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
                        <div class="mt-3 mb-0 text-center">
                            <img src="/images/aisin.png" height="50px" style="margin-bottom: 40px;">
                        </div>

                        <div class="form-floating mt-0">
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="name@example.com" autofocus required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password"
                                class="form-control @error('email') is-invalid @enderror" id="password"
                                placeholder="Password" value="{{ old('email') }}" required>
                            <label for="password">Password</label>
                            @error('email')
                                <div class="feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <br>

                        {{-- <div class="form-check text-start my-3">
                        <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Remember me
                        </label>
                    </div> --}}
                        <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
                        <div class="mt-4 text-center mb-1">
                            <small class="mt-3 mb-3 text-body-secondary">&copy;2023-IT Development</small>
                            {{-- <a href="/register">Register Now!</a> --}}
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>
    <script src="dashboard.js"></script>
    <script src="/js/dashboard.js"></script>

</body>

</html>
