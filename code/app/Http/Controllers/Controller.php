<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * gets the distance from api
     */
    protected function getDistance($origin, $destination)
    {
        $googleApiKey = Config::get('constants.GOOGLE_API_KEY');
        $apiContent = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $origin . "&destinations=" . $destination . "&key=" . $googleApiKey);
        $data = json_decode($apiContent);

        if ($data->rows[0]->elements[0]->status == 'NOT_FOUND' || !$data)
            return false;
        $distanceValue = (int) $data->rows[0]->elements[0]->distance->value;
        //$distanceValue = 46731;
        return ($distanceValue / 1000) . ' Km';
    }
}
