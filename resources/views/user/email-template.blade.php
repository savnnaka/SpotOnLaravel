<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email</title>
</head>
<body>
    {!! $body !!}
    <p>Thank you</p>

<a target="_blank" href="{{$actionLink}}" class="button button--green">Verify Email</a>
<p>If you have troubling clicking the link above, just copy and paste the URL below:</p>
<p>{{$actionLink}}</p>



    
</body>
</html>

