# Papercuts

## 2026-10-01: Existing public event tests fail

These failures occurred before the event title fallback change.

Reproduce with:

```sh
./.infrastructure/scripts/mcp-wait.sh ./vendor/bin/spin run --skip-pull -T php php artisan test --compact Modules/Events/tests/Feature/PublicEventPagesTest.php
```

- `shows filtered public events with available filter options`: The location fixture has no latitude or longitude. PostgreSQL rejects the insert because `locations.lat` cannot be null. The test cannot check the event filters. Add valid coordinates to the fixture, or review the location factory defaults.
- `falls back from legacy preview flags to a date-only schedule on public pages`: The response has a null `event.endDate`, although the fixture specifies an end date. The test fails its date assertion. Review event date handling during the first save; the saving hook reads date accessors that depend on the original start date.

## 2026-10-01: Spin image pull prevents local commands

Running a Spin command without `--skip-pull` can trigger a pull of every Compose image. The pull of `minio/mc:latest` failed with `pull access denied`. This prevents the requested PHP command from starting, even when the PHP image is available locally.

Reproduce with:

```sh
./.infrastructure/scripts/mcp-wait.sh ./vendor/bin/spin run -T php php artisan test --compact Modules/Events/tests/Feature/PublicEventPagesTest.php
```

Use `--skip-pull` when the required images are already available. Review the image source and automatic pull behavior before a fresh environment setup.

## 2026-10-01: Public waste tests use the wrong pagination shape

Two tests in `Modules/Waste/tests/Feature/PublicRubbishPagesTest.php` fail at lines 20 and 32. They expect `streets` to contain one street. The unchanged controller returns a paginator, so the assertion counts 13 pagination fields. This prevents the tests from checking the search results.

Reproduce with:

```sh
./.infrastructure/scripts/mcp-wait.sh ./vendor/bin/spin run --skip-pull -T php php artisan test --compact Modules/Waste/tests/Feature/PublicRubbishPagesTest.php
```

Check `streets.data` and `streets.data.0.name` in these assertions.

## 2026-10-01: Existing container component fails ESLint (resolved 2026-10-02)

`resources/js/components/default-container.tsx` has an unused `props` variable at line 4. The variable is also present in `HEAD`. ESLint fails with `@typescript-eslint/no-unused-vars`, which prevents a clean frontend lint result.

Reproduce with:

```sh
./.infrastructure/scripts/mcp-wait.sh ./vendor/bin/spin run --skip-pull -T node npx eslint resources/js/components/default-container.tsx
```

Resolved: The container now forwards the remaining element props. The focused ESLint check passes.

## 2026-10-02: Event dates use the browser language

With an English browser language, the German event page shows month headings such as `October 2026` and schedules such as `Oct 3, 2026, 10:00 AM`. The labels do not match the surrounding German interface.

Reproduce by opening `/events` with English as the browser language. `getEventMonthGroupLabel()` in `resources/js/lib/events.ts` uses `Intl.DateTimeFormat(undefined, ...)`, and the shared event date components use the browser locale. Set an explicit display locale for the German public pages, or add a consistent language setting.

## 2026-10-02: Missing parking occupancy appears as free capacity

The landing-page parking card and the public parking index use zero occupied spaces when the occupancy is null. A parkhouse with capacity 100 and no occupancy reading appears to have 100 free spaces. The parking detail page correctly shows an unknown value.

Reproduce with an open parking area whose `capacity` is 100 and whose `occupied` is null. Compare the overview and detail views. Review the fallback in `resources/js/components/parking-overview-card.tsx` and `resources/js/pages/parking/index.tsx`; show an unknown value when either reading is missing.
