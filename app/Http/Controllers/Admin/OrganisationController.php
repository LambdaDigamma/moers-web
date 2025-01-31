<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEvent;
use App\Http\Requests\UpdateEventPage;
use App\Models\AdvEvent;
use App\Models\Entry;
use App\Models\Page;
use App\Repositories\PageRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Modules\Organisation\Models\Organisation;
use Redirect;
use Request;

class OrganisationController extends Controller
{
    private $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
        $this->pageRepository = $pageRepository;
    }

    public function index()
    {
        return Inertia::render('Admin/Organisations/Index', [
            'filters' => Request::all('search'),
            'organisations' => Organisation::with(['mainGroup', 'entry'])
                ->orderByDesc('name')
                ->filter(Request::only('search'))
                ->paginate(9)
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Organisations/Create');
    }

    public function edit(Organisation $organisation)
    {
        return Inertia::render('Admin/Organisations/Edit', [
            'organisation' => $organisation,
            'events' => $organisation->events()
                ->future()
                ->chronological()->get()
        ]);
    }

    public function createEvent(Organisation $organisation)
    {
        return Inertia::render('Admin/Organisations/CreateEvent', [
            'organisation' => $organisation,
            'entries' => Entry::all(),
        ]);
    }

    public function storeEvent(Organisation $organisation, UpdateEvent $request)
    {
        $validated = $request->validated();

        $event = AdvEvent::create($validated);

        if (Request::has('header_image') && Request::hasFile('header_image')) {
            $event->addMediaFromRequest('header_image')
                  ->toMediaCollection('header');
        }

        $organisation->events()->save($event);

        $page = $this->createPage($event->name);

        $event->page()->associate($page);
        $event->save();

        return Redirect::route('admin.organisations.events.edit', [$organisation->id, $event->id]);
    }

    public function editEvent(Organisation $organisation, AdvEvent $event, string $lang = "de")
    {
        app()->setLocale($lang);

        $event->load('page', 'page.blocks');

        return Inertia::render('Admin/Organisations/EditEvent', [
            'lang' => $lang,
            'organisation' => $organisation,
            'event' => $event,
            'page' => $event->page
        ]);
    }

    public function updateEvent(Organisation $organisation, AdvEvent $event, UpdateEvent $request, string $lang = "de")
    {
        $validated = $request->validated();

        app()->setLocale($lang);

        if ($lang != "de") {
            $event->setTranslation('name', $lang, $request->get('name'));
            $event->setTranslation('description', $lang, $request->get('description'));
            $event->setTranslation('category', $lang, $request->get('category'));
            $event->save();
        } else {
            $event->update($validated);
        }

        if (Request::has('header_image') && Request::hasFile('header_image')) {
            $event->clearMediaCollection('header');
            $event->addMediaFromRequest('header_image')
                  ->toMediaCollection('header');
        }

        return Redirect::route('admin.organisations.events.edit', [$organisation->id, $event->id, $lang]);
    }

    public function updatePage(Organisation $organisation, AdvEvent $event, UpdateEventPage $request, string $lang = "de")
    {
        app()->setLocale($lang);

        if (is_null($event->page)) {
            $page = $this->createPage($event->name);
            $event->page()->associate($page);
            $event->save();
        }

        $this->pageRepository->update(Page::find($event->page->id), $request->validated(), $lang);

        return Redirect::route('admin.organisations.events.edit', [$organisation->id, $event->id, $lang]);
    }

    public function destroy(Organisation $organisation)
    {
        $organisation->delete();

        return Redirect::back()->with('success', 'Organisation gelöscht.');
    }

    public function restore(Organisation $organisation)
    {
        $organisation->restore();

        return Redirect::back()->with('success', 'Organisation wiederhergestellt.');
    }

    public function createPage($eventName): Page
    {
        $slug = Str::of($eventName)
            ->slug('-')
            ->append('-')
            ->append(Carbon::now()->format('mdyHis'))->__toString();

        return Page::create([
            'title' => $eventName,
            'slug' => $slug
        ]);
    }

}
