<?php

namespace App\Traits;
use Config;

trait LatLngTrait
{
        // function to get  the address
    public function getLatLng($address){
        // Get lat and long by address         
        $prepAddr = str_replace(' ','+',$address);
        $apikey = config('googlemaps.key');
        $geocode=$this->file_get_content_curl('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key='.$apikey);
        $output= json_decode($geocode);
        if($output->status == "ZERO_RESULTS") {
            return false;
        }
        else {
            $LatLon[0] = $output->results[0]->geometry->location->lat;
            $LatLon[1] = $output->results[0]->geometry->location->lng;
            return $LatLon;
        }
    }

    public function file_get_content_curl ($url) 
    {
        // Throw Error if the curl function does'nt exist.
        if (!function_exists('curl_init'))
        { 
            die('CURL is not installed!');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}