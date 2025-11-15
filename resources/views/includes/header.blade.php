<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" sizes="16x16" type="image/png">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('font/poppins.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <title>@yield('title', 'Toolancer')</title>
</head>

<body>

    <header class="header">
        <!-- <div class="topHeader" style="height:50px;background:#000;"></div> -->
        <div class="container">
            <nav class="menuBar navbar-expand-lg rounded-pill p-1">
                <div class="row align-items-center">
                    <div class="col-lg-3 text-center position-relative">
                        <a class="navbar-brand" href="#">
                            <img src="img/logo.png" class="img-fluid" />
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="#ffffff"
                                class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="col-lg-9">
                        <div class="collapse navbar-collapse  justify-content-end" id="navbar">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="./">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="about-us.php">About us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="export-tools.php">Export Tools</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="category.php">Category</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact-us.php">Contact Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link arrowLink text-white" data-bs-toggle="offcanvas"
                                        data-bs-target="#loginslide" href="#">Sign Up
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link arrowLink text-white" href="admin/login.php">Login
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Offcanvas: Login / Signup -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="loginslide" aria-labelledby="loginslideLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="loginslideLabel">Login / Signup</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            {{-- show success message --}}
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="SignUp">
                <form id="signupForm" action="{{ route('signup.submit') }}" method="post" novalidate>
                    @csrf
                    <h2>SignUp</h2><br>

                    <div class="form-group icon_input mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="UserName" value="{{ old('name') }}" required maxlength="255">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group icon_input mb-3">
                        <input type="text" name="displayName"
                            class="form-control @error('displayName') is-invalid @enderror" placeholder="Display Name"
                            value="{{ old('displayName') }}" maxlength="255">
                        @error('displayName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group icon_input mb-3">
                        <input type="email" name="email" id="UserEmail"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter email"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group icon_input mb-3">
                        <input type="text" name="mobile"
                            class="form-control @error('mobile') is-invalid @enderror"
                            placeholder="Enter Mobile Number" value="{{ old('mobile') }}" pattern="[0-9]{10}"
                            maxlength="10">
                        @if ($errors->has('mobile'))
                            <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
                        @else
                            <div class="form-text">Enter 10 digit mobile number (optional).</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <textarea rows="4" class="form-control @error('message') is-invalid @enderror" name="message"
                            placeholder="Message">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary arrowLink">Submit</button>
                </form>
            </div>
        </div>
    </div>
