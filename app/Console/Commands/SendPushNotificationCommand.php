<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\PushNotificationTopic;
use Illuminate\Console\Command;
use InvalidArgumentException;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\SendReport;
use Throwable;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;
use function Laravel\Prompts\textarea;

class SendPushNotificationCommand extends Command
{
    protected $signature = 'push-notifications:send
        {--topic=* : FCM topic to send to. Allowed: all, all_de, all_en}
        {--token=* : Individual FCM registration token}
        {--title= : Notification title}
        {--body= : Notification body}
        {--url= : Optional URL or deep link to open}
        {--dry-run : Validate the payload with FCM without sending}
        {--interactive : Prompt for missing values and confirm before sending}';

    protected $description = 'Send a Firebase Cloud Messaging push notification.';

    private const ALLOWED_URL_SCHEMES = ['moersfestival', 'https', 'http'];

    public function handle(): int
    {
        try {
            $dryRun = (bool) $this->option('dry-run');
            [$topics, $tokens, $title, $body, $url, $shouldConfirm] = $this->resolveInput();
        } catch (InvalidArgumentException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        if ($shouldConfirm && ! $this->confirmSend($topics, $tokens, $title, $body, $url, $dryRun)) {
            $this->warn('Push notification cancelled.');

            return self::SUCCESS;
        }

        $message = $this->buildMessage($title, $body, $url);

        try {
            $messaging = app(Messaging::class);

            foreach ($topics as $topic) {
                $messaging->send($message->toTopic($topic->value), $dryRun);
                $this->line($this->pastTenseAction($dryRun)." topic [{$topic->value}].");
            }

            if ($tokens !== []) {
                $report = $messaging->sendMulticast($message, $tokens, $dryRun);

                if ($report->hasFailures()) {
                    $this->reportTokenFailures($report->failures()->getItems());

                    return self::FAILURE;
                }

                $this->line($this->pastTenseAction($dryRun).' '.count($tokens).' token(s).');
            }
        } catch (Throwable $throwable) {
            report($throwable);

            $this->error('FCM request failed: '.$throwable->getMessage());

            return self::FAILURE;
        }

        $this->info($this->pastTenseAction($dryRun).' '.count($topics).' topic message(s) and '.count($tokens).' token message(s).');

        return self::SUCCESS;
    }

    /**
     * @return array{
     *     0: array<int, PushNotificationTopic>,
     *     1: array<int, string>,
     *     2: string,
     *     3: string,
     *     4: string|null,
     *     5: bool
     * }
     */
    private function resolveInput(): array
    {
        $canPrompt = (bool) $this->option('interactive') || $this->input->isInteractive();
        $didPrompt = false;

        $topicValues = $this->optionValues('topic');
        $tokens = $this->optionValues('token');

        if ($topicValues === [] && $tokens === [] && $canPrompt) {
            [$topicValues, $tokens] = $this->promptForRecipients();
            $didPrompt = true;
        }

        if ($topicValues === [] && $tokens === []) {
            throw new InvalidArgumentException('Provide at least one --topic or --token recipient.');
        }

        $topics = $this->resolveTopics($topicValues);

        $title = $this->stringOption('title');
        if ($title === null && $canPrompt) {
            $title = text(
                label: 'Notification title',
                required: true,
            );
            $didPrompt = true;
        }

        if ($title === null) {
            throw new InvalidArgumentException('The --title option is required.');
        }

        $body = $this->stringOption('body');
        if ($body === null && $canPrompt) {
            $body = textarea(
                label: 'Notification body',
                required: true,
            );
            $didPrompt = true;
        }

        if ($body === null) {
            throw new InvalidArgumentException('The --body option is required.');
        }

        $url = $this->stringOption('url');
        if ($url === null && $canPrompt && ((bool) $this->option('interactive') || $didPrompt)) {
            $url = text(
                label: 'URL to open',
                placeholder: 'moersfestival:///events/123',
                required: false,
                hint: 'Optional. Leave empty to open the app normally.',
            );
            $url = trim($url) !== '' ? trim($url) : null;
            $didPrompt = true;
        }

        if ($url !== null && ! $this->hasAllowedUrlScheme($url)) {
            throw new InvalidArgumentException('The --url option must start with one of these schemes: '.implode(', ', self::ALLOWED_URL_SCHEMES).'. Example: moersfestival:///events/123.');
        }

        return [
            $topics,
            $tokens,
            $title,
            $body,
            $url,
            (bool) $this->option('interactive') || $didPrompt,
        ];
    }

    /**
     * @return array{0: array<int, string>, 1: array<int, string>}
     */
    private function promptForRecipients(): array
    {
        $recipientType = select(
            label: 'Where should the notification be sent?',
            options: [
                'topics' => 'Topics',
                'tokens' => 'Device tokens',
                'both' => 'Topics and device tokens',
            ],
            default: 'topics',
        );

        $topics = [];
        $tokens = [];

        if (in_array($recipientType, ['topics', 'both'], true)) {
            $topics = multiselect(
                label: 'Select FCM topics',
                options: PushNotificationTopic::promptOptions(),
                default: [PushNotificationTopic::All->value],
                required: 'Select at least one topic.',
            );
        }

        if (in_array($recipientType, ['tokens', 'both'], true)) {
            $tokens = $this->normalizeValues([
                text(
                    label: 'Device token(s)',
                    required: true,
                    hint: 'Separate multiple tokens with commas or whitespace.',
                ),
            ]);
        }

        return [$topics, $tokens];
    }

    /**
     * @param  array<int, string>  $topicValues
     * @return array<int, PushNotificationTopic>
     */
    private function resolveTopics(array $topicValues): array
    {
        $topics = [];

        foreach ($topicValues as $topicValue) {
            $topic = PushNotificationTopic::tryFrom($topicValue);

            if ($topic === null) {
                throw new InvalidArgumentException('Unsupported topic ['.$topicValue.']. Allowed topics: '.implode(', ', PushNotificationTopic::values()).'.');
            }

            $topics[$topic->value] = $topic;
        }

        return array_values($topics);
    }

    /**
     * @return array<int, string>
     */
    private function optionValues(string $option): array
    {
        $values = $this->option($option);

        if (! is_array($values)) {
            $values = [$values];
        }

        return $this->normalizeValues($values);
    }

    /**
     * @param  array<int, mixed>  $values
     * @return array<int, string>
     */
    private function normalizeValues(array $values): array
    {
        $normalized = [];

        foreach ($values as $value) {
            foreach (preg_split('/[\s,]+/', (string) $value, -1, PREG_SPLIT_NO_EMPTY) ?: [] as $part) {
                $part = trim($part);

                if ($part !== '') {
                    $normalized[$part] = $part;
                }
            }
        }

        return array_values($normalized);
    }

    private function stringOption(string $option): ?string
    {
        $value = $this->option($option);

        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value !== '' ? $value : null;
    }

    private function buildMessage(string $title, string $body, ?string $url): CloudMessage
    {
        $data = [
            'title' => $title,
            'body' => $body,
        ];

        if ($url !== null) {
            $data['deep_link'] = $url;
        }

        $apnsPayload = [
            'aps' => [
                'alert' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'sound' => 'default',
            ],
        ];

        if ($url !== null) {
            $apnsPayload['deep_link'] = $url;
        }

        return CloudMessage::new()
            ->withData($data)
            ->withApnsConfig(ApnsConfig::fromArray([
                'headers' => [
                    'apns-priority' => '10',
                ],
                'payload' => $apnsPayload,
            ]))
            ->withAndroidConfig(AndroidConfig::fromArray([
                'priority' => 'high',
            ]));
    }

    /**
     * @param  array<int, PushNotificationTopic>  $topics
     * @param  array<int, string>  $tokens
     */
    private function confirmSend(array $topics, array $tokens, string $title, string $body, ?string $url, bool $dryRun): bool
    {
        $topicList = array_map(
            static fn (PushNotificationTopic $topic): string => $topic->value,
            $topics,
        );

        $this->newLine();
        $this->line('Review push notification');
        $this->line('Mode: '.($dryRun ? 'Dry run (validate only)' : 'Live send'));
        $this->line('Topics: '.($topicList !== [] ? implode(', ', $topicList) : 'none'));
        $this->line('Tokens: '.count($tokens));
        $this->line('Title: '.$title);
        $this->line('Body: '.$body);
        $this->line('URL: '.($url ?? 'none'));
        $this->newLine();

        return confirm(
            label: $dryRun ? 'Validate this notification with FCM?' : 'Send this notification now?',
            default: false,
        );
    }

    /**
     * @param  array<int, SendReport>  $failures
     */
    private function reportTokenFailures(array $failures): void
    {
        $this->error('FCM reported '.count($failures).' token failure(s).');

        foreach ($failures as $failure) {
            $message = $failure->error()?->getMessage() ?? 'Unknown error';
            $this->error($failure->target()->value().': '.$message);
        }
    }

    private function hasAllowedUrlScheme(string $url): bool
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);

        return is_string($scheme) && in_array(strtolower($scheme), self::ALLOWED_URL_SCHEMES, true);
    }

    private function pastTenseAction(bool $dryRun): string
    {
        return $dryRun ? 'Validated' : 'Sent';
    }
}
