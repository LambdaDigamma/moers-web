<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\AppleMapSnapshot;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;

class EventController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        SEOTools::setTitle('Veranstaltungen');

        return view('pages.events.index', []);
    }

    public function show(Event $event)
    {
        SEOTools::setTitle($event->name);
        SEOTools::setDescription($event->description);

        $eventLd = JsonLdMulti::newJsonLd();
        $eventLd->setType('Event');
        $eventLd->setTitle($event->name);
        $eventLd->setDescription($event->description);

        if ($event->extras && $event->extras->get('street')) {
            $eventLd->addValues([
                'address' => [
                    "@type" => "PostalAddress",
                    "addressLocality" => "Germany",
                    "postalCode" => $event->extras->get('postcode'),
                    "streetAddress" => $event->extras->get('street'),
                    "addressCountry" => "DE",
                ]
            ]);
        }

        $eventLd->addValues([
            'startDate' => $event->start_date->tz('UTC'),
            'endDate' => $event->end_date,
        ]);
            
        if (! $event->isOnline) {
            $eventLd->addValue("eventAttendanceMode", "https://schema.org/OfflineEventAttendanceMode");
            $eventLd->addValues([
                'location' => [
                    '@type' => 'VirtualLocation',
                    // 'url' => 'https://operaonline.stream5.com/'
                ]
            ]);

        } else {
            $eventLd->addValue("eventAttendanceMode", "https://schema.org/OnlineEventAttendanceMode");
        }

        if ($event->extras && $event->extras->get('location')) {
            $address = "";
            $address .= $event->extras->get('street', '');
            $address .= " " . $event->extras->get('postcode', '');
            $address .= " " . $event->extras->get('place', '');

            $snapshot = AppleMapSnapshot::signedURL($address, [
                'z' => '17',
                'lang' => 'de-DE',
                'scale' => 2,
                'poi' => 0,
                'colorScheme' => 'light',
                'size' => "600x400",
                'annotations' => [
                    [
                        'point' => "center",
                        'color' => '2563EB',
                        'markerStyle' => 'large',
                    ]
                ]
            ]);
        }

        // $event->load(['organisation'])
        
        return view('pages.events.show', [
            'event' => $event,
            'snapshot' => $snapshot ?? null,
        ]);
    }
}
