<?php

namespace App\Console\Commands;

use App\Imports\ImportRubbishScheduleItems;
use Illuminate\Console\Command;
use Modules\Rubbish\Models\RubbishScheduleItem;

class UpdateRubbishScheduleItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rubbish:update-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the rubbish schedule items';

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
     * @return int
     */
    public function handle()
    {
        $this->info("Starting rubbish schedule import");
        
        $collection = (new ImportRubbishScheduleItems)
            ->toCollection('ABFK-2021-schedule.csv', 'local')
            ->first();

            // dd($collection->count());
        
        $schedule = $this->withProgressBar($collection, function ($data) {
            $date = $data->get('datum');
            $deleted = $data->get('del') === '1';

            if ($date && !$deleted) {
                // dd("teasfkldfjas");
                RubbishScheduleItem::updateOrCreate(
                    ['date' => $data->get('datum')],
                    [
                        'residual_tours' => $data->get('restabfall'),
                        'organic_tours' => $data->get('biotonne'),
                        'paper_tours' => $data->get('papiertonne'),
                        'plastic_tours' => $data->get('gelber_sack'),
                        'cuttings_tours' => $data->get('gruenschnitt'),
                    ]
                );
            }



            // dispatch(new SendCalendarInvitation(
            //     $user->get('vorname') ?? $user->get('first_name') ?? $user->get('firstname') ?? null,
            //     $user->get('email') ?? $user->get('mail') ?? null,
            //     $template,
            //     $request->get('count')
            // ));
        });

        return 0;
    }
}
