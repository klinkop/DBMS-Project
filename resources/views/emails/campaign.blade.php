<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->email_subject }}</title>
</head>

<body>
    <p>{!! $campaign->email_body_html !!}</p>

    {{-- tracking pixel --}}
    {{-- <img src="{{ route('campaigns.trackOpen', $campaign->id) }}?email={{ $campaign->recipients-> }}" width="1" height="1"
        style="display: none;" /> --}}
</body>

</html>
