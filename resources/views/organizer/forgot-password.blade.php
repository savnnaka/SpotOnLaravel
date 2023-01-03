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
            <h2 class="mt-3">Reset Password (Organizer)</h2>
            <div class="col-md-5">

                <form action="{{route('organizer.forgot.password.link')}}" method="POST" autocomplete="off">

                    @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
    
                    @if(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif

                    @csrf
                    <p>Enter your Email Address</p>
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" 
                        value="{{ old('email')}}">
                        <span class="text-danger">@error('email'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary">Send Reset Password Link</button>
                    </div>
                </form>
                    <br>
                    <a href="{{route('organizer.login')}}">Login</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>