<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class EventsExploration extends Component
{
    public ?string $search = "abcd";
    public bool $attendance_offline = true;
    public bool $attendance_online = true;
    public bool $only_free = false;
    public $filteredEvents = [];
    public $categories = [];

    public $todayEvents = [];
    public $todayUpcoming = [];
    public $nextUpcoming = [];

    public function mount()
    {
        $this->generateCategories();
    }

    public function render()
    {
        $this->filteredEvents = Event::query()
            ->filter(['search' => $this->search])
            ->get();

        return view('livewire.events-exploration');
    }

    public function resetSearch()
    {
        $this->search = null;
    }

    private function loadOverview()
    {
        $this->todayEvents = Event::query()
            ->active()
            ->chronological()
            ->get();

        $todayUpcoming = Event::query()
            ->today()
            ->chronological()
            ->upcomingToday()
            ->get();
        
        $nextUpcoming = Event::query()
            ->nextDays()
            ->chronological()
            ->get();
    }

    private function generateCategories()
    {
        $this->categories = Cache::remember('event_categories', 1, function () {
            return collect([
                "Ausstellungen",
                "Feste",
                "Gesundheit",
                "Kino",
                "Kirchen",
                "Literatur",
                "Märkte",
                "Sitzungen",
                "Treffen",
                "Weiterbildung",
                "Ausflüge",
                "Bastelveranstaltung",
                "Bilderbuchkino",
                "Event und Aktion",
                "Information",
                "Information und Weiterbildung",
                "Jugend- und Kindertheater",
                "Kinder- und Jugendveranstaltung",
                "Kinderveranstaltung",
                "Kino und Film",
                "Kleinkunst/Kabarett",
                "Krimi",
                "Kunst",
                "Musik und Konzerte",
                "Open Air",
                "Recht",
                "Sport und Aktivität",
                "Theater und Bühne",
                "Vereine",
                "Volksfest und Party",
                "Vortrag",
                "Umzüge",
                "Konzerte / Theater / Musik",
                "Stadtführungen",
            ])->map(function ($category) {
                return [
                    'category' => $category,
                    'image' => $this->addParams($this->imageForCategory($category)),
                ];
            });
        });
    }

    private function addParams(?string $url): ?string
    {
        if ($url == null) {
            return null;
        }
        return $url . "?auto=format&w=256&amp;h=256&amp;q=80";
    }

    private function imageForCategory($category): ?string
    {
        switch ($category) {
            case 'Theater und Bühne':
                return 'https://images.unsplash.com/photo-1514306191717-452ec28c7814';
            case 'Lesung':
                return 'https://images.unsplash.com/photo-1635782013905-182c5dc10cae';
            case 'Ausstellungen':
                return 'https://images.unsplash.com/photo-1503293050619-6048ffad0dc5';
            case 'Vortrag':
                return 'https://images.unsplash.com/photo-1498189263721-d42d6bcc2ad1';
            case 'Musik und Konzerte':
                return 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6';
            case 'Stadtführungen':
                return 'https://images.unsplash.com/photo-1615206680639-7467e145fa9f';
            case 'Feste':
                return 'https://images.unsplash.com/photo-1472653431158-6364773b2a56';
            case 'Gesundheit':
                return 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528';
            case 'Kino':
                return 'https://images.unsplash.com/photo-1478720568477-152d9b164e26';
            case 'Kirchen':
                return 'https://images.unsplash.com/photo-1473177104440-ffee2f376098';
            case 'Literatur':
                return 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d';
            case 'Märkte':
                return 'https://images.unsplash.com/photo-1600618202813-ee7fca1fcc2b';
            case 'Sitzungen':
                return 'https://images.unsplash.com/photo-1552581234-26160f608093';
            case 'Treffen':
                return 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f';
            case 'Weiterbildung':
                return 'https://images.unsplash.com/photo-1581726690015-c9861fa5057f';
            case 'Ausflüge':
                return 'https://images.unsplash.com/photo-1496950866446-3253e1470e8e';
            case 'Bastelveranstaltung':
                return 'https://images.unsplash.com/photo-1452860606245-08befc0ff44b';
            case 'Bilderbuchkino':
                return 'https://images.unsplash.com/photo-1579273168832-1c6639363dad';
            case 'Event und Aktion':
                return 'https://images.unsplash.com/photo-1485846234645-a62644f84728';
            case 'Information':
                return 'https://images.unsplash.com/photo-1504711331083-9c895941bf81';
            case 'Information und Weiterbildung':
                return 'https://images.unsplash.com/photo-1509062522246-3755977927d7';
            case 'Jugend- und Kindertheater':
                return 'https://images.unsplash.com/photo-1630050525402-06c617847d27';
            case 'Kinder- und Jugendveranstaltung':
                return 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5';
            case 'Kinderveranstaltung':
                return 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5';
            case 'Kino und Film':
                return 'https://images.unsplash.com/photo-1561722798-9a732d141027';
            case 'Kleinkunst/Kabarett':
                return 'https://images.unsplash.com/photo-1543062591-e3c0fdb97350';
            case 'Krimi':
                return 'https://images.unsplash.com/photo-1595540545309-13c92aa63079';
            case 'Kunst':
                return 'https://images.unsplash.com/photo-1569172122301-bc5008bc09c5';
            case 'Open Air':
                return 'https://images.unsplash.com/photo-1511916417-9779dc923704';
            case 'Recht':
                return 'https://images.unsplash.com/photo-1589391886645-d51941baf7fb';
            case 'Vereine':
                return 'https://images.unsplash.com/photo-1518604964608-053f9db26a16';
            case 'Volksfest und Party':
                return 'https://images.unsplash.com/photo-1501238295340-c810d3c156d2';
            case 'Umzüge':
                return 'https://images.unsplash.com/photo-1616836641508-3486b884a259';
            case 'Konzerte / Theater / Musik':
                return 'https://images.unsplash.com/photo-1563841930606-67e2bce48b78';
            case 'Sport und Aktivität':
                return 'https://images.unsplash.com/photo-1517649763962-0c623066013b';
            default:
                return null;
        }
    }
}
