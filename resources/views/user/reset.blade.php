<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <h2 class="mt-3">Reset Password (User)</h2>
            <div class="col-md-5">
                
                <form action="{{route('user.reset.password')}}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
    
                    @if(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif

                    <div class="mb-3">
                      <label for="email" class="form-label">Email address</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" 
                      value="{{ $email ?? old('email')}}">
                      <span class="text-danger">@error('email'){{$message}}@enderror</span>
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" name="password" 
                        placeholder="Password">
                      <span class="text-danger">@error('password'){{$message}}@enderror</span>
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm password</label>
                        <input type="password" class="form-control" id="cpassword" name="password_confirmation" 
                          placeholder="Password">
                        <span class="text-danger">@error('password'){{$message}}@enderror</span>
                      </div>
                    <button type="submit" class="btn btn-primary mb-2">Reset Password</button>
                  </form>

                  <br>
                  <p class="mt-2">Login?</p>
                  <a href="{{route('user.login')}}">Login here</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>