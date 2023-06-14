<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ trans('common.title.system_register') }}</title>
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
    <a href="#">{{ trans('common.title.system_register') }}</a><br />
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      @if (isset($errors) && $errors->any())
      <div class="alert alert-danger">
        <ul style="list-style: none; padding:0; margin: 0">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form action="{{ route('system.store') }}" method="post">
        @csrf
        <p class="login-box-msg">{{ trans('common.label.info') }}</p>
        <div class="mb-3">
          <input type="text" name="name" class="form-control" placeholder="{{ trans('common.label.name') }}">
        </div>
        <div class="mb-3">
          <input type="text" name="url" class="form-control" placeholder="{{ trans('common.label.url') }}">
        </div>
        <div class="mb-3">
          <input type="text" name="username" class="form-control" placeholder="{{ trans('common.label.username') }}">
        </div>
        <div class="mb-3">
          <input type="text" name="cccd" class="form-control" placeholder="{{ trans('common.label.cccd') }}">
        </div>
        <div class="mb-3">
          <input type="text" name="phone" class="form-control" placeholder="{{ trans('common.label.phone') }}">
        </div>
        <p class="login-box-msg">{{ trans('common.label.account') }}</p>
        <div class="mb-3">
          <input type="text" name="email" class="form-control" placeholder="{{ trans('common.label.email') }}">
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="{{ trans('common.label.password') }}">
        </div>
        <div class="mb-3">
          <input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('common.label.password_confirmation') }}">
        </div>
        <div class="row">
          <div class="col-6">
            <button type="button" onclick="window.location.reload()" class="btn btn-default btn-block">{{ trans('common.button.clear') }}</button>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">{{ trans('common.button.next') }}</button>
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