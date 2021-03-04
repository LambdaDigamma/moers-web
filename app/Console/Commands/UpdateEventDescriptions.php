<?php

namespace App\Console\Commands;

use App\Models\AdvEvent;
use Illuminate\Console\Command;
use Parsedown;

class UpdateEventDescriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:description';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the description field from the page attribute.';

    private Parsedown $parsedown;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->parsedown = new Parsedown();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events = AdvEvent::query()->future()->with(['page', 'page.blocks'])->get();

        $events->each(function ($event) {

            $page = $event->page;

            if ($page != null) {
                $firstMarkdownBlock = $page->blocks->firstWhere('type', 'markdown');
                if ($firstMarkdownBlock !== null) {

                    $germanText = $firstMarkdownBlock->getTranslation('data', 'de')['text'];
                    $englishText = $firstMarkdownBlock->getTranslation('data', 'en', 'de')['text'];

                    $plainGerman = $this->markdownToPlainText($germanText);
                    $plainEnglish = $this->markdownToPlainText($englishText);

                    $event
                        ->setTranslation('description', 'de', $plainGerman)
                        ->setTranslation('description', 'en', $plainEnglish)
                        ->save();

                    $extras = $event->extras;
                    $extras['descriptionEN'] = $plainEnglish;
                    $event->update(['extras' => $extras]);

                    $this->info("Updated description of'" . $event->name . "'." );

                }

            }

        });

        $this->info("All event descriptions have been updated.");

        return true;

    }

    private function markdownToPlainText($input): string
    {
        return strip_tags((new Parsedown)->text($input));
    }

}
