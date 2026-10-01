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

## 2026-10-01: Existing container component fails ESLint

`resources/js/components/default-container.tsx` has an unused `props` variable at line 4. The variable is also present in `HEAD`. ESLint fails with `@typescript-eslint/no-unused-vars`, which prevents a clean frontend lint result.

Reproduce with:

```sh
./.infrastructure/scripts/mcp-wait.sh ./vendor/bin/spin run --skip-pull -T node npx eslint resources/js/components/default-container.tsx
```

Forward the remaining element props to the container, or remove the unused variable if these props are not supported.
