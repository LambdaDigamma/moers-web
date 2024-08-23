<?php

namespace App\Providers;

use App\Charts\ParkingAreaRecentHistory;
use App\Data\Api\EventNodeItem;
use App\Data\Api\MediaCompanyItem;
use App\Models\HelpRequest;
use Bluemmb\Faker\PicsumPhotosProvider;
use Bouncer;
use Faker\Generator;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Request;
use ConsoleTVs\Charts\Registrar as Charts;
use TypeMapper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(Charts $charts)
    {
        $this->registerInertia();
        $this->registerLengthAwarePaginator();

        Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });

        Bouncer::ownedVia(HelpRequest::class, 'creator_id');

        TypeMapper::setMapping('node--event', EventNodeItem::class);
        TypeMapper::setMapping('media--company', MediaCompanyItem::class);

        $charts->register([
            ParkingAreaRecentHistory::class,
        ]);

        $faker = $this->app->make(Generator::class);
        $faker->addProvider(new PicsumPhotosProvider($faker));
    }

    private function registerInertia()
    {
//        Inertia::setRootView('layout');
//
//        Inertia::version(function () {
//            return md5_file(public_path('mix-manifest.json'));
//        });
//
//        Inertia::share([
//            'auth' => function () {
//                return [
//                    'user' => Auth::user() ? [
//                        'id' => Auth::user()->id,
//                        'name' => Auth::user()->name,
//                        'email' => Auth::user()->email,
//                        'notifications_count' => Auth::user()->unreadNotifications()->count()
//                    ] : null,
//                ];
//            },
//            'locale' => function () {
//                return app()->getLocale();
//            },
//            'language' => function () {
//                return translations(
//                    resource_path('lang/'. app()->getLocale() .'.json')
//                );
//            },
//            'flash' => function () {
//                return [
//                    'success' => Session::get('success'),
//                    'error' => Session::get('error'),
//                ];
//            },
//            'menuEntries' => function () {
//                return [
//                    'entries' => true,
//                    'events' => true,
//                    'organisations' => true,
//                    'help' => true,
//                    'polls' => false
//                ];
//            },
//            'errors' => function () {
//                return Session::get('errors')
//                    ? Session::get('errors')->getBag('default')->getMessages()
//                    : (object) [];
//            },
//        ]);
    }

    private function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new class(...array_values($values)) extends LengthAwarePaginator {
                public function only(...$attributes)
                {
                    return $this->transform(function ($item) use ($attributes) {
                        return $item->only($attributes);
                    });
                }

                public function transform($callback)
                {
                    $this->items->transform($callback);

                    return $this;
                }

                public function toArray()
                {
                    return [
                        'data' => $this->items->toArray(),
                        'links' => $this->links(),
                    ];
                }

                public function links($view = null, $data = [])
                {
                    $this->appends(Request::all());

                    $window = UrlWindow::make($this);

                    $elements = array_filter([
                        $window['first'],
                        is_array($window['slider']) ? '...' : null,
                        $window['slider'],
                        is_array($window['last']) ? '...' : null,
                        $window['last'],
                    ]);

                    return Collection::make($elements)->flatMap(function ($item) {
                        if (is_array($item)) {
                            return Collection::make($item)->map(function ($url, $page) {
                                return [
                                    'url' => $url,
                                    'label' => $page,
                                    'active' => $this->currentPage() === $page,
                                ];
                            });
                        } else {
                            return [
                                [
                                    'url' => null,
                                    'label' => '...',
                                    'active' => false,
                                ],
                            ];
                        }
                    })->prepend([
                        'url' => $this->previousPageUrl(),
                        'label' => 'Vorherige',
                        'active' => false,
                    ])->push([
                        'url' => $this->nextPageUrl(),
                        'label' => 'Nächste',
                        'active' => false,
                    ]);
                }
            };
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
