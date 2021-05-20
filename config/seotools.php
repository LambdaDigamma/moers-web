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
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => $defaultDescription,
            'separator'    => ' | ',
            'keywords'     => ['moers', 'stadt', 'veranstaltungen', 'geschäfte', 'öffnungszeiten', 'abfallkalender', 'moers app', 'stadtapp', 'offene daten'],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
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
            'title'       => $defaultTitle, // set false to total remove
            'description' => $defaultDescription, // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
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
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => $defaultTitle, // set false to total remove
            'description' => $defaultDescription, // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
