<!DOCTYPE html>
<html>
<head>
    <title>Site Services</title>
</head>
<body>
    <h1>Site Services</h1>
    <br>
    @foreach ($websites as $website)
        <h1>Website: {{ $website['url'] }}</h1>
        <h2>Services:</h2>
        <ul>
            @foreach ($website['services'] as $service)
                <li>{{ $service }}</li>
            @endforeach
        </ul>
    @endforeach
</body>
</html>
