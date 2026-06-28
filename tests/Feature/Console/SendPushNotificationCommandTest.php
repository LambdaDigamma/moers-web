<?php

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\MessageTarget;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\SendReport;
use Laravel\Prompts\Key;
use Laravel\Prompts\Prompt;
use Mockery\MockInterface;

afterEach(function (): void {
    Prompt::interactive(false);
});

function bindPushMessagingMock(): MockInterface
{
    $messaging = Mockery::mock(Messaging::class);

    app()->instance(Messaging::class, $messaging);

    return $messaging;
}

/**
 * @param  array<int, string>  $tokens
 */
function successfulPushReport(array $tokens): MulticastSendReport
{
    return MulticastSendReport::withItems(array_map(
        static fn (string $token): SendReport => SendReport::success(
            MessageTarget::with(MessageTarget::TOKEN, $token),
            ['name' => 'projects/moers-festival/messages/'.sha1($token)],
        ),
        $tokens,
    ));
}

/**
 * @return array<int, string>
 */
function pushPromptKeys(string $value, string $submitKey = Key::ENTER): array
{
    return [
        ...mb_str_split($value),
        $submitKey,
    ];
}

it('sends a notification to an allowed topic with a deep link payload', function () {
    $capturedPayload = null;
    $capturedDryRun = null;
    $messaging = bindPushMessagingMock();

    $messaging
        ->shouldReceive('send')
        ->once()
        ->withArgs(function ($message, bool $dryRun) use (&$capturedPayload, &$capturedDryRun): bool {
            $capturedPayload = $message->jsonSerialize();
            $capturedDryRun = $dryRun;

            return true;
        })
        ->andReturn(['name' => 'projects/moers-festival/messages/topic-message']);

    $messaging->shouldNotReceive('sendMulticast');

    $this->artisan('push-notifications:send --topic=all_de --title=Update --body="Schedule changed" --url=moersfestival:///events/123 --no-interaction')
        ->assertExitCode(Command::SUCCESS);

    expect($capturedDryRun)->toBeFalse()
        ->and($capturedPayload['topic'])->toBe('all_de')
        ->and($capturedPayload['data'])->toBe([
            'title' => 'Update',
            'body' => 'Schedule changed',
            'deep_link' => 'moersfestival:///events/123',
        ])
        ->and($capturedPayload['apns']['payload']['aps']['alert'])->toBe([
            'title' => 'Update',
            'body' => 'Schedule changed',
        ])
        ->and($capturedPayload['apns']['payload']['aps']['sound'])->toBe('default')
        ->and($capturedPayload['apns']['payload']['deep_link'])->toBe('moersfestival:///events/123')
        ->and($capturedPayload['android']['priority'])->toBe('high')
        ->and($capturedPayload)->not->toHaveKey('notification');
});

it('sends one multicast message to deduplicated tokens', function () {
    $capturedPayload = null;
    $capturedTokens = null;
    $capturedDryRun = null;
    $messaging = bindPushMessagingMock();

    $messaging->shouldNotReceive('send');

    $messaging
        ->shouldReceive('sendMulticast')
        ->once()
        ->withArgs(function ($message, array $tokens, bool $dryRun) use (&$capturedPayload, &$capturedTokens, &$capturedDryRun): bool {
            $capturedPayload = $message->jsonSerialize();
            $capturedTokens = $tokens;
            $capturedDryRun = $dryRun;

            return true;
        })
        ->andReturnUsing(fn ($message, array $tokens, bool $_dryRun): MulticastSendReport => successfulPushReport($tokens));

    $this->artisan('push-notifications:send --token=token-a --token=token-b,token-a --title=Update --body="Hello tokens" --no-interaction')
        ->assertExitCode(Command::SUCCESS);

    expect($capturedDryRun)->toBeFalse()
        ->and($capturedTokens)->toBe(['token-a', 'token-b'])
        ->and($capturedPayload['data'])->toBe([
            'title' => 'Update',
            'body' => 'Hello tokens',
        ])
        ->and($capturedPayload)->not->toHaveKey('token')
        ->and($capturedPayload)->not->toHaveKey('notification');
});

it('forwards dry-run mode to Firebase', function () {
    $capturedDryRun = null;
    $messaging = bindPushMessagingMock();

    $messaging
        ->shouldReceive('send')
        ->once()
        ->withArgs(function ($message, bool $dryRun) use (&$capturedDryRun): bool {
            $capturedDryRun = $dryRun;

            return true;
        })
        ->andReturn(['name' => 'projects/moers-festival/messages/dry-run']);

    $this->artisan('push-notifications:send --topic=all --title=Update --body="Dry run" --dry-run --no-interaction')
        ->assertExitCode(Command::SUCCESS);

    expect($capturedDryRun)->toBeTrue();
});

it('prompts interactively for recipients, message content, url, and confirmation', function () {
    $capturedPayload = null;
    $capturedDryRun = null;
    $messaging = bindPushMessagingMock();

    Prompt::fake([
        Key::ENTER,
        Key::ENTER,
        ...pushPromptKeys('Interactive title'),
        ...pushPromptKeys('Interactive body', Key::CTRL_D),
        ...pushPromptKeys('moersfestival:///events/interactive'),
        'y',
        Key::ENTER,
    ]);

    $messaging
        ->shouldReceive('send')
        ->once()
        ->withArgs(function ($message, bool $dryRun) use (&$capturedPayload, &$capturedDryRun): bool {
            $capturedPayload = $message->jsonSerialize();
            $capturedDryRun = $dryRun;

            return true;
        })
        ->andReturn(['name' => 'projects/moers-festival/messages/interactive-topic']);

    $messaging->shouldNotReceive('sendMulticast');

    $this->artisan('push-notifications:send --interactive')
        ->assertExitCode(Command::SUCCESS);

    expect($capturedDryRun)->toBeFalse()
        ->and($capturedPayload['topic'])->toBe('all')
        ->and($capturedPayload['data'])->toBe([
            'title' => 'Interactive title',
            'body' => 'Interactive body',
            'deep_link' => 'moersfestival:///events/interactive',
        ]);
});

it('shows the final payload preview before interactive confirmation and allows cancellation', function () {
    $messaging = bindPushMessagingMock();

    Prompt::fake([Key::ENTER]);

    $messaging->shouldNotReceive('send');
    $messaging->shouldNotReceive('sendMulticast');

    $this->artisan('push-notifications:send --interactive --topic=all --title=Preview --body="Final body" --url=https://moers.app/events/123 --dry-run')
        ->expectsOutput('Review push notification')
        ->expectsOutput('Mode: Dry run (validate only)')
        ->expectsOutput('Topics: all')
        ->expectsOutput('Tokens: 0')
        ->expectsOutput('Title: Preview')
        ->expectsOutput('Body: Final body')
        ->expectsOutput('URL: https://moers.app/events/123')
        ->expectsOutput('Push notification cancelled.')
        ->assertExitCode(Command::SUCCESS);
});

it('fails before sending when topic is unsupported', function () {
    app()->bind(Messaging::class, fn () => throw new RuntimeException('Messaging should not be resolved.'));

    $this->artisan('push-notifications:send --topic=other --title=Update --body="No send" --no-interaction')
        ->assertExitCode(Command::FAILURE);
});

it('fails before sending when required input is missing', function (string $command) {
    app()->bind(Messaging::class, fn () => throw new RuntimeException('Messaging should not be resolved.'));

    $this->artisan($command)->assertExitCode(Command::FAILURE);
})->with([
    'recipient' => 'push-notifications:send --title=Update --body="No recipient" --no-interaction',
    'title' => 'push-notifications:send --topic=all --body="No title" --no-interaction',
    'body' => 'push-notifications:send --topic=all --title=Update --no-interaction',
]);

it('fails before sending when url does not use an allowed scheme', function (string $url) {
    app()->bind(Messaging::class, fn () => throw new RuntimeException('Messaging should not be resolved.'));

    $this->artisan('push-notifications:send --topic=all --title=Update --body="Bad URL" --url='.$url.' --no-interaction')
        ->assertExitCode(Command::FAILURE);
})->with([
    'missing scheme' => 'events/123',
    'unsupported scheme' => 'ftp://moers.app/events/123',
]);
