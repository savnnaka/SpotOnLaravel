<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Registration</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <h2 class="mt-3">Organizer Registration</h2>
            <div class="col-md-5">

                @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif

                @if(Session::has('error'))
                <div class="alert alert-danger">{{Session::get('error')}}</div>
                @endif
                
                <form action="{{route('organizer.create')}}" method="POST">
                    @csrf

                    <div class="mb-3">
                      <label for="name" class="form-label">What's the name of your organization?</label>
                      <input type="name" class="form-control" id="name" name="name" placeholder="Name" value="{{old('name')}}">
                      <span class="text-danger">@error('name'){{$message}}@enderror</span>
                  </div>

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full name of yours</label>
                        <input type="name" class="form-control" id="fullname" name="fullname" placeholder="Full name" value="{{old('fullname')}}">
                        <span class="text-danger">@error('fullname'){{$message}}@enderror</span>
                    </div>

                    <div class="mb-3">
                      <label for="email" class="form-label">Type in your Email Address</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{old('email')}}">
                      <span class="text-danger">@error('email'){{$message}}@enderror</span>
                    </div>
                    <div class="mb-3">
                      <label for="city" class="form-label">Where's your organization at?</label>
                      <input type="city" class="form-control" id="city" name="city" placeholder="city" value="{{old('city')}}">
                      <span class="text-danger">@error('city'){{$message}}@enderror</span>
                    </div>
                    <div class="mb-3">
                      <label for="phone" class="form-label">Your orga's Phone number</label>
                      <input type="tel" class="form-control" id="phone" name="phone"
                      placeholder="Phone" value="{{old('phone')}}">
                      <span class="text-danger">@error('phone'){{$message}}@enderror</span>
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label">Very safe Password</label>
                      <input type="password" class="form-control" id="password" name="password" 
                        placeholder="Password">
                      <span class="text-danger">@error('password'){{$message}}@enderror</span>
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm your password</label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Password">
                        <span class="text-danger">@error('cpassword'){{$message}}@enderror</span>
                      </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <p class="mt-2">Are you already a registered organization?</p>
                    <a href="{{route('organizer.login')}}">Login here</a>
                  </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>