<?php

namespace Modules\Events\Console\Commands;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Modules\Events\Jobs\LoadMoersEvent;
use Swis\JsonApi\Client\Interfaces\DocumentInterface;
use Swis\JsonApi\Client\Item;
use Traversable;

class LoadMoersEvents extends Command
{
    protected $signature = 'events:load-moers-events';

    protected $description = 'Load all events for the next month from moers backend.';

    protected Client $client;
    protected $hrefs;
    protected $currentHref;

    protected array $events = [];
    protected array $urls = [];
    protected array $eventUrls = [];

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
    }

    public function handle(): int
    {
        $document = Http::asJsonApi()
            ->get('https://www.moers.de/jsonapi/node/event')
            ->jsonApi();

        $this->handleDocument($document);

        while ($document->getLinks()->next) {
            $this->urls[] = $document->getLinks()->next->getHref();
            $document = Http::asJsonApi()
                ->get($document->getLinks()->next->getHref())
                ->jsonApi();
            $this->handleDocument($document);
        }

        $this->info('Found ' . count($this->eventUrls) . ' events.');

        foreach ($this->eventUrls as $eventUrl) {
            $this->info('Loading event ' . $eventUrl);
            LoadMoersEvent::dispatchSync($eventUrl);
        }

        return 0;
    }

    public function handleDocument(DocumentInterface $document)
    {
        $events = $document->getData();

        foreach ($events as $event) {
            $this->eventUrls[] = $event->getLinks()->self->getHref();
        }
    }

//                if (is_array($eventType) or ($eventType instanceof Traversable)) {
//                    $category = implode(', ', $eventType);
//                } else {
//                    $category = $eventType;
//                }
//
//                $newEvent->category = $category;

}
