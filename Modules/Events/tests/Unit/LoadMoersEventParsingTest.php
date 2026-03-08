<?php

use Modules\Events\Jobs\LoadMoersEvent;

it('extracts rich content and organiser details from a moers event page', function () {
    $html = <<<'HTML'
    <html>
        <body>
            <main>
                <h1>Gemeinsam schauen - Wo sind denn alle?</h1>
                <p>ab 18.30 Uhr im Studio (Eintritt frei)</p>
                <p>Gemeinsam schauen ! Hier beim Schlosstheater anmelden</p>
                <p>Hochhaus mit schwebenden orangenen Kugeln in der Luft.</p>
                <p>von Emil Borgeest und Leo Meier</p>
                <p>Gut sichtbar prangt er an der Wand.</p>
                <p>Event details</p>
                <p>Veranstaltungsdatum</p>
                <p>11.03.2026 - 18:30 Uhr - 21:30 Uhr</p>
                <p>Veranstaltungsort</p>
                <p>Kastell 9</p>
                <p>47441 Moers</p>
                <p>Veranstaltungsort</p>
                <p>Schloss</p>
                <p>Veranstalter</p>
                <p>Firma</p>
                <p>Schlosstheater Moers GmbH</p>
                <p>Adresse</p>
                <p>Kastell 6</p>
                <p>47441 Moers</p>
                <p>Telefon</p>
                <p>0 28 41 / 88 34 - 110</p>
                <p>E-Mail</p>
                <p>Info@Schlosstheater-Moers.de</p>
                <p>Internetseite</p>
                <p>https://www.schlosstheater-moers.de</p>
            </main>
        </body>
    </html>
    HTML;

    $job = new LoadMoersEvent('https://example.com/event');
    $parsed = $job->parseEventPageHtml($html, 'Gemeinsam schauen - Wo sind denn alle?');

    expect($parsed['subtitle'])->toBe('ab 18.30 Uhr im Studio (Eintritt frei)')
        ->and($parsed['description'])->toContain('Gemeinsam schauen ! Hier beim Schlosstheater anmelden')
        ->and($parsed['description'])->toContain('von Emil Borgeest und Leo Meier')
        ->and($parsed['location'])->toBe('Schloss')
        ->and($parsed['street'])->toBe('Kastell 9')
        ->and($parsed['postcode'])->toBe('47441')
        ->and($parsed['place'])->toBe('Moers')
        ->and($parsed['organizer'])->toBe('Schlosstheater Moers GmbH')
        ->and($parsed['organizer_street'])->toBe('Kastell 6')
        ->and($parsed['organizer_postcode'])->toBe('47441')
        ->and($parsed['organizer_place'])->toBe('Moers')
        ->and($parsed['organizer_phone'])->toBe('0 28 41 / 88 34 - 110')
        ->and($parsed['organizer_email'])->toBe('Info@Schlosstheater-Moers.de')
        ->and($parsed['organizer_website'])->toBe('https://www.schlosstheater-moers.de');
});
