<?php


use App\Support\Api;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\Pure;
use Predis\ClientInterface;
use MatanYadaev\EloquentSpatial\Objects\Point;

#[Pure]
function api($data = [], $success = true, $code = 200, array $extra = []): Api
{
    return Api::make(...func_get_args());
}


function isDebug(): bool
{
    return App::hasDebugModeEnabled();
}

/**
 * @param null $key
 * @param null $value
 * @param ?int $expire
 * @return bool|null|string|Illuminate\Redis\Connections\Connection|ClientInterface|\Illuminate\Support\Facades\Redis
 * @noinspection PhpMissingReturnTypeInspection
 */
function redis($key = null, $value = null, int $expire = null)
{
    $redis = Illuminate\Support\Facades\Redis::connection();

    if (func_num_args() == 3) {
        return $redis->set($key, $value, 'EX', $expire);
    } elseif ($key != null && $value != null) {
        return $redis->set($key, $value);
    } elseif (func_num_args() === 1) {
        return $redis->get($key);
    } else {
        return $redis;
    }
}

function validationException(array $messages = [])
{
    throw ValidationException::withMessages($messages);
}

function responseException($response)
{
    if (is_object($response) && method_exists($response, 'toResponse')) {
        $response = $response->toResponse();
    }
    throw new HttpResponseException($response);
}


function distanceSqlExpression(
    Point $point,
    string $as  = 'distance',
    $latitudeColumn  = 'latitude',
    $longitudeColumn = 'longitude'
) : string
{
    return /**@lang SQL */ "
        ROUND(111.111 * DEGREES(
                ACOS(
                    LEAST(
                        1.0,
                        COS(
                            RADIANS( $latitudeColumn )) * COS(
                            RADIANS( {$point->latitude} )) * COS(
                            RADIANS( $longitudeColumn - {$point->longitude} )) + SIN(
                            RADIANS( $latitudeColumn )) * SIN(RADIANS( {$point->latitude} )
                        )
                    )
                )
           ),
        4) AS {$as}";
}

function getDistanceBetweenTwoPoints(Point $point1,Point $point2): float
{
    $earthRadius = 6371;

    $lat1 = $point1->latitude;
    $lon1 = $point1->longitude;
    $lat2 = $point2->latitude;
    $lon2 = $point2->longitude;

    // Convert latitude and longitude from degrees to radians
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Calculate the differences between the coordinates
    $latDiff = $lat2 - $lat1;
    $lonDiff = $lon2 - $lon1;

    // Calculate the distance using the Haversine formula
    $a = sin($latDiff / 2) * sin($latDiff / 2) + cos($lat1) * cos($lat2) * sin($lonDiff / 2) * sin($lonDiff / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return round($earthRadius * $c,2);
}
