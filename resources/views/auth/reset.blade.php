


<!doctype html>
<html lang="en">
<head>
    <title>Register</title>
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

                        </div>
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4 text-center">Reset Password</h3>
                            </div>
                        </div>
                        <form action="{{route('password.reset')}}" class="signin-form" method="post">
                            @csrf
                            <div class="form-group mt-3">
                                <input name="email" type="email" class="form-control" required value="">
                                <label class="form-control-placeholder" for="username">Email</label>
                            </div>
                            <div class="form-group">
                                <input id="password-field" name="password" type="password" class="form-control" required value="{{old('password')}}">
                                <label class="form-control-placeholder" for="password">Password</label>
                                <span id="eye-btn" class="fa fa-fw fa-eye field-icon toggle-password">
                                </span>
                            </div>
                            <div class="form-group">
                                <input id="password-field" name="password_confirmation" type="password" class="form-control" required>
                                <label class="form-control-placeholder" for="password">Confirm Password</label>
                                <span id="eye-btn" class="fa fa-fw fa-eye field-icon toggle-password">
                                </span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">
                                    Reset Password
                                </button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset("frontend/assets/js/jquery.min.js")}}"></script>
<script src="{{asset("frontend/assets/js/bootstrap.min.js")}}"></script>
<script>
 
        $("#eye-btn").click(function(){
            if($("#password-field").attr("type")=="password"){
                $("#password-field").attr("type","text")
            }else{
                 $("#password-field").attr("type","password")
            }
            
        })
</script>
</body>
</html>






