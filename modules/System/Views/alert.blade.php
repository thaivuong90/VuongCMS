<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $title }}</title>
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
			<a href="#">{{ $title }}</a><br />
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<div class="alert alert-{{ $type }}">
					<p>{{ $message }}</p>
				</div>
				@csrf
				<div class="row">
					<!-- /.col -->
					<div class="col-4">
						<a href="{{ route('system.create') }}" class="btn btn-default btn-block">{{ trans('common.button.back') }}</a>
					</div>
					@if($type === 'success' && isset($slug))
					<div class="col-6">
						<a href="{{ system_route('system.login', ['slug' => $slug]) }}" class="btn btn-primary btn-block">{{ trans('common.button.signin') }}</a>
					</div>
					@else
					<div class="col-8">
						<a href="{{ system_route('system.confirmation') }}" class="btn btn-primary btn-block">{{ trans('common.button.activate_resend') }}</a>
					</div>
					@endif
					<!-- /.col -->
				</div>
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