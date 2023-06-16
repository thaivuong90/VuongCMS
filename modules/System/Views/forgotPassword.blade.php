<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ trans('common.title.forgot_password') }}</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ url('common/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="{{ url('common/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ url('common/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="#">{{ trans('common.title.forgot_password') }}</a><br />
		</div>
		<!-- /.login-logo -->
		<div class="card">

			<div class="card-body login-card-body">
				@if (isset($errors) && $errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				@if(isset($message))
				<div class="alert alert-{{ $type }}">
					<span>{{ $message }}</span>
				</div>
				@endif
				<form method="post" action="{{ system_route('system.forgot_password') }}">
					@csrf
					<div class="input-group mb-3">
						<input type="text" name="email" class="form-control" placeholder="{{ trans('common.label.email') }}" value="{{ old('email') }}">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<!-- /.col -->
						<div class="col-6">
							<a href="{{ system_route('system.login') }}" class="btn btn-default btn-block">{{ trans('common.button.close') }}</a>
						</div>
						<div class="col-6">
							<button type="submit" class="btn btn-primary btn-block">{{ trans('common.button.send') }}</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="{{ url('common/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ url('common/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ url('common/dist/js/adminlte.min.js') }}"></script>
</body>

</html>