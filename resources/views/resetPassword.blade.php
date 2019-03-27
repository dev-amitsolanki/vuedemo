<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Vue-demo</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
        <!-- <link href="css/custom.css" rel="stylesheet"> -->
        <!-- <script src="js/jquery.min.js"></script> -->
        <!-- <script src="js/bootstrap.min.js"></script> -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
        <style>
        h2 {
  text-align: center;
  margin-left: 0%;
}
.card .form-group .col-md-6,
.card .form-group .col-sm-6 {
  max-width: 100%;
}
.card .btn-primary {
  display: inherit;
  margin: 0 auto;
}
        </style>
    </head>
    <body>
        <div class="col-sm-6 col-md-6 col-xs-12 col-md-offset-3 col-sm-offset-3" style="margin:0 auto; margin-top:10%;">
    <div class="card">
        <div class="card-header">
          <h2>
            Password Reset
            <button type="button" class="btn btn-sm bg-danger float-left">
              <a href="/" style="color:#fff;">Back</a>
            </button>
          </h2>
        </div>
        <form action="{{url('api/password/reset')}}" method="post">
          <div class="card-body">
            <div class="form-group">
              <label for="password">New password</label>
              <input type="hidden" name="email" value="{{$passwordReset->email}}">
              <input type="hidden" name="token" value="{{$passwordReset->token}}">
              <input
                type="password" name="password"
                class="form-control col-md-6"
                placeholder="Enter new password"
              >
              </div>
              <div class="form-group">
              <label for="email">Re-type password</label>
              <input
                type="password" name="confirmation_password"
                class="form-control col-md-6"
                placeholder="Re-enter your password"
              >
              </div>

            <div class="form-group">
              <input type="submit" value="submit" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
</div>
    </body>
</html>
