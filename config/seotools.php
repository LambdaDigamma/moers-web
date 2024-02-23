<?php
/**
 * @see https://github.com/artesaos/seotools
 */

$defaultTitle = "Mein Moers";
$defaultDescription = "Digitale Bürgerinformation auf Basis von offenen Daten: Geschäfte, Parkplätze, 360° Panoramen, Veranstaltungen, aktuelle Kraftstoffpreise, Abfallkalender und vieles mehr!";

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => $defaultTitle, // set false to total remove
            'description'  => $defaultDescription,
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'separator'    => ' | ',
            'keywords'     => ['moers', 'geschäfte', 'restaurants', 'daten', 'bürger', 'moers festival', 'öffnungszeiten', 'parkplätze', 'veranstaltungen', 'kraftstoffpreise', 'benzin', 'diesel', 'moers app', 'stadt app', 'offene daten'],
            'canonical'    => null, // Set null for using Url::current(), set false to total remove
            'robots'       => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => true,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'title'       => $defaultTitle, // set false to total remove
            'description' => $defaultDescription, // set false to total remove
            'type'        => 'website',
            'site_name'   => 'Mein Moers',
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary',
            'site'        => '@moers_de',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'title'       => $defaultTitle, // set false to total remove
            'description' => $defaultDescription, // set false to total remove
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
