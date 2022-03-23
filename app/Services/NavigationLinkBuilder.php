<?php

namespace App\Services;

class TravelMode
{
    public const DRIVING = "driving";
    public const WALKING = "walking";
    public const BICYCLING = "bicycling";
    public const TRANSIT = "transit";

    public static function convertInToShort($travelMode): string
    {
        switch ($travelMode)
        {
            case self::DRIVING:
                return "d";
            case self::WALKING:
                return "w";
            case self::TRANSIT:
                return "r";
            case self::BICYCLING:
                return "c";
        }
        return "d";
    }
}

class NavigationLinkBuilder
{
    public static function buildGoogleMapsLink($lat, $lng, $travelmode = TravelMode::DRIVING): string
    {
        $baseUrl = "https://www.google.com/maps/dir/?api=1&";

        return $baseUrl . "destination=$lat,$lng&travelmode=$travelmode";
    }

    public static function buildAppleMapsLink($lat, $lng, $travelmode = TravelMode::DRIVING): string
    {
        $shortTravelMode = TravelMode::convertInToShort($travelmode);
        
        return "https://maps.apple.com/?daddr=$lat,$lng&dirflg=$shortTravelMode";
    }
}