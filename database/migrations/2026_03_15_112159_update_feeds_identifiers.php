<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\News\Models\Feed;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update existing RSS feeds based on their IDs/Names
        // Based on previous DB query:
        // ID 1: Rheinische Post
        // ID 2: Lokalkompass
        // ID 3: NRZ (used as festival news feed by default)

        DB::table('feeds')->where('id', 1)->update(['identifier' => 'rheinische-post']);
        DB::table('feeds')->where('id', 2)->update(['identifier' => 'lokalkompass']);
        DB::table('feeds')->where('id', 3)->update(['identifier' => 'moers-festival-news']);

        // 2. Ensure Instagram feed exists and has the correct identifier
        $instagramFeed = Feed::query()->where('identifier', 'moers-festival-instagram')->first();
        if (! $instagramFeed) {
            // Try to find by name if identifier is missing
            $instagramFeed = Feed::query()
                ->where('name->en', 'Instagram')
                ->orWhere('name->de', 'Instagram')
                ->first();

            if ($instagramFeed) {
                $instagramFeed->update(['identifier' => 'moers-festival-instagram']);
            } else {
                $instagramFeed = Feed::create([
                    'identifier' => 'moers-festival-instagram',
                    'name' => [
                        'en' => 'Instagram',
                        'de' => 'Instagram',
                    ],
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('feeds')->update(['identifier' => null]);
    }
};
