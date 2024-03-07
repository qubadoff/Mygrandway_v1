<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Support\Api;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function countries(Request $request): Api
    {
        return api(Country::query()->when(
            value: $request->get('search'),
            callback: fn ($query,$value) => $query->where('name', 'LIKE', "%{$value}%")
        )->paginate($request->perPage()))->setMessage('Countries fetched successfully');
    }

    public function cities(Request $request, Country $country): Api
    {
        return api($country->cities()->when(
            value: $request->get('search'),
            callback: fn ($query,$value) => $query->where('name', 'LIKE', "%{$value}%")
        )->paginate($request->perPage()))->setMessage('Cities fetched successfully');
    }
}
