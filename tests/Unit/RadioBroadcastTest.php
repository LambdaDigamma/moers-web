<?php

use App\Models\RadioBroadcast;

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