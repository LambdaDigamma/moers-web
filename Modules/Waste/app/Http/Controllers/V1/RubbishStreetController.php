<?php

namespace Modules\Waste\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Modules\Waste\Models\RubbishStreet;

class RubbishStreetController extends Controller
{
    public function index(): JsonResponse
    {
        $queryTerm = trim((string) Request::get('q', ''));
        $operator = config('database.default') === 'pgsql' ? 'ilike' : 'like';

        if (Request::has('all')) {
            $data = RubbishStreet::query()
                ->when($queryTerm !== '', function (Builder $query) use ($operator, $queryTerm) {
                    $query->where(function (Builder $innerQuery) use ($operator, $queryTerm) {
                        foreach ($this->searchVariants($queryTerm) as $variant) {
                            $innerQuery->orWhere('name', $operator, '%'.$variant.'%');
                        }
                    });
                })
                ->orderBy('name')
                ->get();
        } else {
            $data = RubbishStreet::query()
                ->current()
                ->when($queryTerm !== '', function (Builder $query) use ($operator, $queryTerm) {
                    $query->where(function (Builder $innerQuery) use ($operator, $queryTerm) {
                        foreach ($this->searchVariants($queryTerm) as $variant) {
                            $innerQuery->orWhere('name', $operator, '%'.$variant.'%');
                        }
                    });
                })
                ->orderBy('name')
                ->get();
        }

        return new JsonResponse(['data' => $data], 200);
    }

    public function show(RubbishStreet $street): JsonResponse
    {
        return new JsonResponse(['data' => $street->pickupItems()], 200);
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
}
