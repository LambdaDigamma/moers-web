<?php

namespace Modules\Waste\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;
use Modules\Waste\Models\RubbishStreet;

class RubbishController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('q')->trim()->toString();
        $operator = config('database.default') === 'pgsql' ? 'ilike' : 'like';

        $streets = RubbishStreet::query()
            ->current()
            ->when($search !== '', function (Builder $query) use ($search, $operator) {
                $query->where(function (Builder $innerQuery) use ($search, $operator) {
                    foreach ($this->searchVariants($search) as $variant) {
                        $innerQuery->orWhere('name', $operator, '%'.$variant.'%');
                    }
                });
            })
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name', 'street_addition']);

        return inertia('rubbish/index', [
            'filters' => [
                'q' => $search,
            ],
            'streets' => $streets,
        ]);
    }

    /**
     * @return array<int, string>
     */
    protected function searchVariants(string $search): array
    {
        $variants = [$search];
        $replacements = [
            'ae' => 'ä',
            'oe' => 'ö',
            'ue' => 'ü',
            'ss' => 'ß',
            'ä' => 'ae',
            'ö' => 'oe',
            'ü' => 'ue',
            'ß' => 'ss',
        ];

        foreach ($replacements as $from => $to) {
            foreach ($variants as $variant) {
                $variants[] = str_ireplace($from, $to, $variant);
            }
        }

        return array_values(array_unique(array_filter($variants)));
    }

    public function show(RubbishStreet $street): Response
    {
        $streetSlug = $this->streetSlug($street->name);
        $year = now()->year;
        $icsUrl = "https://abfallkalender.enni.de/ics-kalender/{$streetSlug}";

        $pickupGroups = $street->pickupItems()
            ->groupBy(fn ($item) => $item['date'])
            ->map(fn ($items, $date) => [
                'date' => $date,
                'items' => collect($items)->values()->all(),
            ])
            ->values()
            ->all();

        return inertia('rubbish/show', [
            'street' => [
                'id' => $street->id,
                'name' => $street->name,
                'street_addition' => $street->street_addition,
            ],
            'pickupGroups' => $pickupGroups,
            'downloads' => [
                'pdf_download_url' => "https://abfallkalender.enni.de/pdf-kalender/{$streetSlug}",
                'pdf_view_url' => 'https://abfallkalender.enni.de/assets/addons/pdfout/vendor/web/viewer.html?file='.rawurlencode("/pdf-kalender/{$streetSlug}"),
                'full_pdf_url' => "https://abfallkalender.enni.de/media/abfallkalender_{$year}.pdf",
                'ics_download_url' => $icsUrl,
                'ics_subscribe_url' => $icsUrl,
                'apple_calendar_url' => "webcal://abfallkalender.enni.de/ics-kalender/{$streetSlug}",
                'google_calendar_url' => "https://calendar.google.com/calendar/r?cid=webcal://abfallkalender.enni.de/ics-kalender/{$streetSlug}",
                'outlook_calendar_url' => "https://outlook.office.com/calendar/0/addfromweb?url={$icsUrl}",
            ],
        ]);
    }

    protected function streetSlug(string $streetName): string
    {
        return Str::of(Str::lower($streetName))
            ->replace(['ä', 'ö', 'ü', 'ß'], ['ae', 'oe', 'ue', 'ss'])
            ->slug('-')
            ->toString();
    }
}
