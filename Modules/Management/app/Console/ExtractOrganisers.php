<?php

namespace Modules\Management\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Modules\Events\Models\Event;
use Modules\Management\Models\Organisation;

class ExtractOrganisers extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'management:extract-organisers {--threshold=85 : Similarity threshold for fuzzy matching (0-100)} {--dry-run : Run without making changes to the database}';

    /**
     * The console command description.
     */
    protected $description = 'Extract organisers from events extras and move them to the organisations table.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $threshold = (int) $this->option('threshold');
        $dryRun = (bool) $this->option('dry-run');

        if ($dryRun) {
            $this->info('Dry run mode: No changes will be saved.');
        }

        $events = Event::whereNotNull('extras->organizer')->get();
        $this->info("Found {$events->count()} events with organisers.");

        $processedCount = 0;
        $createdCount = 0;
        $linkedCount = 0;

        foreach ($events as $event) {
            $organizerRaw = $event->extras->get('organizer');
            if (! $organizerRaw) {
                continue;
            }

            // Sometimes organisers are separated by newline (venue\norganizer)
            $organizerNames = array_map('trim', explode("\n", $organizerRaw));

            // We'll take the LAST one as it usually seems to be the actual organiser if split
            // Based on data like "ENNI Eventhalle\nFestivalbüro des moers festivals"
            $organizerName = end($organizerNames);

            if (empty($organizerName)) {
                continue;
            }

            $organisation = $this->findExistingOrganisation($organizerName, $threshold);

            if (! $organisation) {
                if ($dryRun) {
                    $this->comment("Would create new organisation: {$organizerName}");
                } else {
                    $organisation = Organisation::create([
                        'name' => $organizerName,
                        'slug' => Str::slug($organizerName),
                        'description' => $organizerName, // Placeholder description
                    ]);
                    $createdCount++;
                }
            } else {
                if ($dryRun) {
                    $this->line("Matched existing organisation: {$organisation->name} (for '{$organizerName}')");
                }
            }

            if ($organisation) {
                if ($dryRun) {
                    $this->line("Would link event #{$event->id} to organisation #{$organisation->id}");
                } else {
                    $event->organisation_id = $organisation->id;
                    $event->save();
                    $linkedCount++;
                }
            }

            $processedCount++;
        }

        $this->info('Extraction completed.');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Processed Events', $processedCount],
                ['Organisations Created', $createdCount],
                ['Events Linked', $linkedCount],
            ]
        );

        return 0;
    }

    protected function findExistingOrganisation(string $name, int $threshold): ?Organisation
    {
        // 1. Exact match (case insensitive)
        $exact = Organisation::where('name', 'ilike', $name)->first();
        if ($exact) {
            return $exact;
        }

        // 2. Fuzzy match
        $organisations = Organisation::all();
        $bestMatch = null;
        $bestScore = 0;

        foreach ($organisations as $org) {
            similar_text(Str::lower($name), Str::lower($org->name), $percent);
            if ($percent > $bestScore && $percent >= $threshold) {
                $bestScore = $percent;
                $bestMatch = $org;
            }
        }

        return $bestMatch;
    }
}
