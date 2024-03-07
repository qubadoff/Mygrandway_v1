<?php

namespace App\Http\Controllers\Api\Support;

use App\Http\Controllers\Controller;
use App\Models\SupportData;
use Illuminate\Http\JsonResponse;

class SupportController extends Controller
{
    public function index(): JsonResponse
    {
        $data = SupportData::where('id', 1)->first();

        return response()->json([
            "email" => $data->email,
            "phone" => $data->phone
        ]);
    }
}
