<?php

it('publishes the sitemap location in robots.txt', function () {
    expect(file_get_contents(public_path('robots.txt')))
        ->toContain('Sitemap: https://moers.app/sitemap.xml');
});
