<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->email_subject }}</title>
</head>
<body>
    <p>{!! $campaign->email_body_html !!}</p>
    <p style="display: none;"><strong>Campaign ID:</strong> {{ $campaign->id }}</p>
</body>
</html>
