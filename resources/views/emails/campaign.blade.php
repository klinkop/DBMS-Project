<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->email_subject }}</title>
</head>

<body>
    <h1>{{ $campaign->email_subject }}</h1>
    <p>{!! $campaign->email_body_html !!}</p>
</body>

</html>
