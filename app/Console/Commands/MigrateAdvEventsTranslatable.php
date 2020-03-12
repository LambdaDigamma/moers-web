<?php

namespace App\Console\Commands;

use App\AdvEvent;
use Illuminate\Console\Command;

class MigrateAdvEventsTranslatable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data_migration:translatable_events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This moves all AdvEvents from using no specified language to use a translatable field.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $events = AdvEvent::all();

        $events->each(function ($item) {
            $item->name = $item->getOriginal("name");
            $item->description = $item->getOriginal("description");
            $item->category = $item->getOriginal("category");
            $item->save();
        });

    }
}
