<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
          href="https://preview.colorlib.com/theme/bootstrap/login-form-15/css/A.style.css.pagespeed.cf.AxmTFBrhes.css">
</head>
<body>
<section class="m-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="wrap">
                    <div class="login-wrap p-4 p-md-5">
                        <div>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <p>
                                        <span class="btn btn-danger">{{$error}}</span>
                                    </p>
                                @endforeach
                            @endif
                            @if (Session::has('status'))
                              
                                    <p>
                                        <span class="btn btn-success">{{Session::get('status')}}</span>
                                    </p>
                               
                            @endif

                        </div>
                        <form action="{{route('password.email')}}" class="signin-form" method="post">
                            @csrf
                            <div class="form-group mt-3">
                                <input name="email" type="email" class="form-control" value="{{old('email')}}">
                                <label class="form-control-placeholder" for="username">Email</label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary">
                                    Send Passsword Reset Link
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>