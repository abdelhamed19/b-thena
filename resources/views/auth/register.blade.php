<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href={{ asset('auth/style.css') }}  rel="stylesheet" type="text/css">
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
						Create an account
					</h4>
					<form action="{{ route('admin.register') }}" method="POST">
                        @csrf
						<div class="form-input">
							<span><i class="fa fa-user-o"></i></span>
							<input type="text" name="name" placeholder="Full Name" required>
						</div>
						<div class="form-input">
							<span><i class="fa fa-envelope-o"></i></span>
							<input type="email" name="email" placeholder="Email Address" tabindex="10"required>
						</div>
						<div class="form-input">
							<span><i class="fa fa-key"></i></span>
							<input type="password" name="password" placeholder="Password" required>
						</div>
						<div class="form-input">
							<span><i class="fa fa-key"></i></span>
							<input type="password" name="password_confirmation" placeholder="Confirm Password" required>
						</div>

						<div class="mb-3">
							<button type="submit" class="btn btn-block">
								Register
							</button>
						</div>

						<div class="text-center mb-5">
							Already have an account
							<a class="login-link" href="{{ route('login.view') }}">Login here</a>
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-6 d-none d-lg-block image-container"></div>
		</div>
	</div>
</body>
</html>
