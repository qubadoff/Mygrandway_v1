<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrencyType;
use Illuminate\Http\JsonResponse;

class CurrencyTypeController extends Controller
{
    public function currencyType(): JsonResponse
    {
        $types = CurrencyType::all();

        return response()->json([
            'currencyTypes' => $types
        ]);
    }
}
