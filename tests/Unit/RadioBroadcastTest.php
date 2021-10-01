<?php

use App\Models\RadioBroadcast;
use Illuminate\Support\Carbon;

it('can be created', function () {

    $broadcast = RadioBroadcast::create([
        'title' => 'Some title',
        'description' => 'Some description',
        'uid' => '1234567890-uid',
        'starts_at' => '2021-09-01 18:04:00',
        'ends_at' => '2021-09-01 18:56:00',
        'attach' => 'https://picsum.photos/200/300',
        'url' => 'https://example.org',
    ]);

    expect($broadcast)->title->toBe('Some title')
        ->and($broadcast->description)->toBe('Some description')
        ->and($broadcast->uid)->toBe('1234567890-uid')
        ->and($broadcast->starts_at->toDateTimeString())->toBe('2021-09-01 18:04:00')
        ->and($broadcast->ends_at->toDateTimeString())->toBe('2021-09-01 18:56:00')
        ->and($broadcast->attach)->toBe('https://picsum.photos/200/300')
        ->and($broadcast->url)->toBe('https://example.org');
        
});

it('it can be scoped', function () {

    RadioBroadcast::create([
        'title' => 'Some title',
        'uid' => '123456789',
        'starts_at' => Carbon::now()->addDays(1),
    ]);

    RadioBroadcast::create([
        'title' => 'Some title',
        'uid' => '012345678',
        'starts_at' => Carbon::now()->subDays(1),
    ]);

    expect(RadioBroadcast::query()->upcoming()->count())->toBe(1);

});