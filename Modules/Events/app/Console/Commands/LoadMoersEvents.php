<?php

namespace Modules\Events\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Modules\Events\Jobs\LoadMoersEvent;
use Swis\JsonApi\Client\Interfaces\DocumentInterface;

class LoadMoersEvents extends Command
{
    protected $signature = 'events:load-moers-events';

    protected $description = 'Load all events for the next month from moers backend.';

    public function handle(): int
    {
        $url = 'https://www.moers.de/jsonapi/node/event';
        $count = 0;

        do {
            $document = Http::asJsonApi()
                ->get($url)
                ->jsonApi();

            $count += $this->handleDocument($document);

            $url = $document->getLinks()->next?->getHref();

            // Explicitly free memory early
            unset($document);
        } while ($url);

        $this->info("Dispatched {$count} events.");

        return Command::SUCCESS;
    }

    private function handleDocument(DocumentInterface $document): int
    {
        $count = 0;

        foreach ($document->getData() as $event) {
            LoadMoersEvent::dispatch($event->getLinks()->self->getHref());

            $count++;
        }

        return $count;
    }
}
