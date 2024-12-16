<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href={{ asset('auth/style.css') }} rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 form-block px-4">
                <div class="col-lg-8 col-md-6 col-sm-8 col-xs-12 form-box">
                    <div class="text-center mb-3 mt-5">
                        <img src={{ asset('auth/logo.png') }} width="150px">
                    </div>
                    <h4 class="text-center mb-4">
                        Login into account
                    </h4>
                    <form action="{{ route('admin.login') }}" method="POST">
                        @csrf
                        <div class="form-input">
                            <span><i class="fa fa-phone"></i></span>
                            <input type="number" name="email" placeholder="phone number" value="{{ old('email') }}" tabindex="10" required>
                        </div>
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                        {{-- <span class="text-danger">
                            @if (session('error'))
                                {{ session('error') }}
                            @endif
                        </span> --}}
                        <div class="form-input">
                            <span><i class="fa fa-key"></i></span>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <label class="">Do you have a problem</label>
                                <a href="reset.html" class="forget-link">
                                    Forgot password?
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-block">
                                Login
                            </button>
                        </div>

                        <div class="text-center mb-5">
                            Enjoy with us
                            <a class="register-link" href=></a>
                        </div>

                </div>
            </form>
            </div>
            <div class="col-lg-6 d-none d-lg-block image-container"></div>
        </div>
    </div>
</body>
</html>
