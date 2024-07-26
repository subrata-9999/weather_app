<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Weather App</h1>
        <form action="{{ route('getWeather') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <button type="submit" class="btn btn-primary">Get Weather</button>
        </form>

        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif

        @isset($weather)
            <div class="mt-4">
                <h3>Weather in {{ $city }}</h3>
                <p>Description: {{ $weather }}</p>
                <p>Temperature: {{ $temperature }}°F</p>
                <p>Feels Like: {{ $feels_like }}°F</p>
                <p>Humidity: {{ $humidity }}%</p>
                <p>Wind Speed: {{ $wind_speed }} mph</p>
            </div>
        @endisset
    </div>
</body>
</html>
