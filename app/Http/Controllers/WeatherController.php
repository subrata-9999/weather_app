<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city = $request->input('city');

        // Check if the city exists in the database
        $cityRecord = City::where('name', $city)->first();
        if (!$cityRecord) {
            return back()->with('error', 'City not found in the database.');
        }
        echo $cityRecord->name;
        
        $curl = curl_init();
        
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://open-weather13.p.rapidapi.com/city/{$cityRecord->name}/EN",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: open-weather13.p.rapidapi.com",
                "x-rapidapi-key: afbb33b377msh00d5a45f9bf04e1p111d02jsn3d1fefeb682a"
            ],
        ]);
        
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            return back()->with('error', "cURL Error #: $err");
        } else {
            
            $weatherData = json_decode($response, true);
            if (isset($weatherData['cod']) && $weatherData['cod'] == 200) {
                return view('weather', [
                    'city' => $weatherData['name'],
                    'weather' => $weatherData['weather'][0]['description'],
                    'temperature' => $weatherData['main']['temp'],
                    'feels_like' => $weatherData['main']['feels_like'],
                    'humidity' => $weatherData['main']['humidity'],
                    'wind_speed' => $weatherData['wind']['speed'],
                ]);
            } else {
                return back()->with('error', 'Unable to fetch weather data.');
            }
        }
    }
}
