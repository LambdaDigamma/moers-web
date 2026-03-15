<?php

use App\Console\Commands\GenerateSitemap;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Modules\Events\Console\Commands\LoadMoersEvents;
use Modules\Events\Console\Commands\LoadMoersFestivalEvents;
use Modules\Events\Console\Commands\LoadInstagramPosts;
use Modules\Multimedia\Console\Commands\LoadMediathekFeed;
use Modules\Multimedia\Console\Commands\LoadRadio;
use Modules\News\Console\Commands\ImportAdolfinumNews;
use Modules\News\Console\Commands\ImportExternalPostsCommand;
use Modules\Parking\Console\Commands\UpdateParkingAreas;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Parking
Schedule::command(UpdateParkingAreas::class)->everyFiveMinutes();

// Events
Schedule::command(LoadMoersEvents::class)->everyFourHours();
Schedule::command(LoadMoersFestivalEvents::class)->daily();
Schedule::command(LoadInstagramPosts::class)->everyTenMinutes();

// News & Posts
Schedule::command(ImportExternalPostsCommand::class)->hourly();
Schedule::command(ImportAdolfinumNews::class)->hourly();

// Multimedia
Schedule::command(LoadRadio::class)->everyFiveMinutes();
Schedule::command(LoadMediathekFeed::class)->hourly();

// Sitemap
Schedule::command(GenerateSitemap::class)->hourly();
