<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class CameraController extends Controller
{
    public function index()
    {
        $data = [
            [
                "title" => "Haagstr-Kastell-Klosterstr",
                "point" => "51.450945, 6.625564",
                "PanoID" => 1930
            ],
            [
                "title" => "Klosterstraße",
                "point" => "51.451183, 6.625737",
                "PanoID" => 1204
            ],
            [
                "title" => "Kastell",
                "point" => "51.450580, 6.625298",
                "PanoID" => 1931
            ],
            [
                "title" => "Altes Landratsamt",
                "point" => "51.450159, 6.624992",
                "PanoID" => 1932
            ],
            [
                "title" => "Haagstraße",
                "point" => "51.450066, 6.628353",
                "PanoID" => 2307
            ],
            [
                "title" => "Uerdingerstr./Haagstr",
                "point" => "51.450221, 6.629005",
                "PanoID" => 1938
            ],
            [
                "title" => "Kiosk West",
                "point" => "51.450707, 6.629218",
                "PanoID" => 1933
            ],
            [
                "title" => "Steinstraße",
                "point" => "51.450877, 6.628442",
                "PanoID" => 1216
            ],
            [
                "title" => "Steinstraße",
                "point" => "51.451018, 6.627881",
                "PanoID" => 1213
            ],
            [
                "title" => "Steinstraße/Burgstraße",
                "point" => "51.451115, 6.627412",
                "PanoID" => 1212
            ],
            [
                "title" => "Burgstraße",
                "point" => "51.450781, 6.627148",
                "PanoID" => 1195
            ],
            [
                "title" => "Steinstraße",
                "point" => "51.451246, 6.627098",
                "PanoID" => 1217
            ],
            [
                "title" => "Pfefferstraße",
                "point" => "51.451876, 6.626842",
                "PanoID" => 1211
            ],
            [
                "title" => "Steinstraße",
                "point" => "51.451457, 6.626454",
                "PanoID" => 1215
            ],
            [
                "title" => "Pfefferstraße",
                "point" => "51.451938, 6.626457",
                "PanoID" => 1210
            ],
            [
                "title" => "Kirchstraße/Pfefferstraße",
                "point" => "51.451986, 6.626227",
                "PanoID" => 1201
            ],
            [
                "title" => "Kirchstraße",
                "point" => "51.452285, 6.626351",
                "PanoID" => 1202
            ],
            [
                "title" => "Kirchstraße/Friedrichstraße",
                "point" => "51.452530, 6.626689",
                "PanoID" => 1200
            ],
            [
                "title" => "Kirchstraße",
                "point" => "51.452833, 6.626791",
                "PanoID" => 1203
            ],
            [
                "title" => "Wallzentrum/Kirchstraße",
                "point" => "51.453022, 6.627016",
                "PanoID" => 1220
            ],
            [
                "title" => "Unterwallstraße/Neuer Wall",
                "point" => "51.453171, 6.627628",
                "PanoID" => 1939
            ],
            [
                "title" => "Friedrichstraße",
                "point" => "51.452433, 6.626988",
                "PanoID" => 1197
            ],
            [
                "title" => "Friedrichstraße",
                "point" => "51.452091, 6.627387",
                "PanoID" => 1196
            ],
            [
                "title" => "Steinstraße",
                "point" => "51.451576, 6.625789",
                "PanoID" => 1214
            ],
            [
                "title" => "Neumarkt",
                "point" => "51.452368, 6.625682",
                "PanoID" => 1206
            ],
            [
                "title" => "Hans-Dieter-Hüsch-Platz/Wallzentrum",
                "point" => "51.451775, 6.627988",
                "PanoID" => 1198
            ],
            [
                "title" => "Neustraße",
                "point" => "51.451798, 6.624649",
                "PanoID" => 1207
            ],
            [
                "title" => "Neustraße",
                "point" => "51.451917, 6.624054",
                "PanoID" => 1208
            ],
            [
                "title" => "Neustraße",
                "point" => "51.452099, 6.623268",
                "PanoID" => 1209
            ],
            [
                "title" => "Neustraße",
                "point" => "51.452184, 6.622826",
                "PanoID" => 1934
            ],
            [
                "title" => "Zum Alten Brauhaus",
                "point" => "51.452336, 6.622233",
                "PanoID" => 1935
            ],
            [
                "title" => "Altmarkt",
                "point" => "51.451530, 6.626131",
                "PanoID" => 1194
            ],
            [
                "title" => "Rathausvorplatz",
                "point" => "51.453268, 6.626469",
                "PanoID" => 1936
            ],
            [
                "title" => "Moerser Schloss",
                "point" => "51.449827, 6.624706",
                "PanoID" => 1937
            ],
            [
                "title" => "Neumarkt",
                "point" => "51.451698, 6.625235",
                "PanoID" => 1205
            ],
            [
                "title" => "Hans-Dieter-Hüsch-Platz",
                "point" => "51.451752, 6.627585",
                "PanoID" => 1199
            ],
            [
                "title" => "Schlossausstellung",
                "point" => "51.449449, 6.624501",
                "PanoID" => 3169
            ],
            [
                "title" => "Hanns-Dieter-Hüsch-Bildungszentrum",
                "point" => "51.453113, 6.631724",
                "PanoID" => 3171
            ],
            [
                "title" => "VHS Vorplatz",
                "point" => "51.452966, 6.63131",
                "PanoID" => 3172
            ],
            [
                "title" => "Bahnhofsvorplatz",
                "point" => "51.450403, 6.640946",
                "PanoID" => 3165
            ],
            [
                "title" => "Rathauspark",
                "point" => "51.453679, 6.62541",
                "PanoID" => 3166
            ]
        ];
    }
}
