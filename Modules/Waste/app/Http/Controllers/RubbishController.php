<?php

namespace Modules\Waste\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
                'ics_url' => 'https://cms.sbm-moers.de/abfk/ical/'.now()->year."-{$street->id}.ics",
                'pdf_url' => "https://cms.sbm-moers.de/abfk/abfallkalender_moers.php?h=0&streetid={$street->id}&rw=0&newjear=".now()->year,
            ],
        ]);
    }
}
