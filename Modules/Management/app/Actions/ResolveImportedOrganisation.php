<?php

namespace Modules\Management\Actions;

use Illuminate\Support\Str;
use Modules\Management\Models\Organisation;

class ResolveImportedOrganisation
{
    public function handle(
        string $name,
        ?string $externalSource = null,
        ?string $externalId = null,
        ?string $externalUrl = null,
        ?string $email = null,
        ?string $phone = null,
        ?string $websiteUrl = null,
        ?string $street = null,
        ?string $postcode = null,
        ?string $city = null,
        int $threshold = 90,
    ): Organisation {
        $organisation = $this->findByExternalId(
            externalSource: $externalSource,
            externalId: $externalId,
        );
        $matchedByExternalId = $organisation !== null;

        if (! $organisation) {
            $organisation = $this->findExistingOrganisation(
                name: $name,
                threshold: $threshold,
            );
        }

        if (! $organisation) {
            return Organisation::create([
                'name' => $this->squish($name),
                'slug' => $this->uniqueSlug($name),
                'description' => $this->squish($name),
                'external_source' => $externalSource,
                'external_id' => $externalId,
                'external_url' => $externalUrl,
                'email' => $email,
                'phone' => $phone,
                'website_url' => $websiteUrl,
                'street' => $street,
                'postcode' => $postcode,
                'city' => $city,
            ]);
        }

        $this->fillMissingImportedFields(
            organisation: $organisation,
            externalSource: $externalSource,
            externalId: $externalId,
            externalUrl: $externalUrl,
            email: $email,
            phone: $phone,
            websiteUrl: $websiteUrl,
            street: $street,
            postcode: $postcode,
            city: $city,
            overwriteExistingImportedFields: $matchedByExternalId,
        );

        return $organisation;
    }

    private function findByExternalId(?string $externalSource, ?string $externalId): ?Organisation
    {
        if (! $externalSource || ! $externalId) {
            return null;
        }

        return Organisation::query()
            ->where('external_source', $externalSource)
            ->where('external_id', $externalId)
            ->first();
    }

    private function findExistingOrganisation(string $name, int $threshold): ?Organisation
    {
        $squishedName = $this->squish($name);
        $organisation = Organisation::query()
            ->whereRaw('lower(name) = ?', [Str::lower($squishedName)])
            ->first();

        if ($organisation) {
            return $organisation;
        }

        $slug = Str::slug($squishedName);
        if ($slug !== '') {
            $organisation = Organisation::query()->where('slug', $slug)->first();

            if ($organisation) {
                return $organisation;
            }
        }

        return $this->findFuzzyMatch($squishedName, $threshold);
    }

    private function findFuzzyMatch(string $name, int $threshold): ?Organisation
    {
        $canonicalName = $this->canonicalName($name);
        $bestMatch = null;
        $bestScore = 0.0;

        Organisation::query()
            ->orderBy('id')
            ->each(function (Organisation $organisation) use ($canonicalName, $threshold, &$bestMatch, &$bestScore): void {
                similar_text($canonicalName, $this->canonicalName($organisation->name), $score);

                if ($score >= $threshold && $score > $bestScore) {
                    $bestScore = $score;
                    $bestMatch = $organisation;
                }
            });

        return $bestMatch;
    }

    private function fillMissingImportedFields(
        Organisation $organisation,
        ?string $externalSource,
        ?string $externalId,
        ?string $externalUrl,
        ?string $email,
        ?string $phone,
        ?string $websiteUrl,
        ?string $street,
        ?string $postcode,
        ?string $city,
        bool $overwriteExistingImportedFields,
    ): void {
        $attributes = [
            'external_source' => $externalSource,
            'external_id' => $externalId,
            'external_url' => $externalUrl,
            'email' => $email,
            'phone' => $phone,
            'website_url' => $websiteUrl,
            'street' => $street,
            'postcode' => $postcode,
            'city' => $city,
        ];

        $updates = [];

        foreach ($attributes as $key => $value) {
            if ($value === null) {
                continue;
            }

            if ($overwriteExistingImportedFields || blank($organisation->{$key})) {
                $updates[$key] = $value;
            }
        }

        if ($updates !== []) {
            $organisation->update($updates);
        }
    }

    private function uniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name) ?: 'organisation';
        $slug = $baseSlug;
        $suffix = 2;

        while (Organisation::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    private function canonicalName(string $name): string
    {
        $canonical = Str::of($name)
            ->ascii()
            ->lower()
            ->replace('&', ' und ')
            ->replaceMatches('/\b(e\.?\s*v\.?|gmbh|ug|ag|gbr|kg|mbh|e\.?\s*k\.?)\b/u', ' ')
            ->replaceMatches('/[^a-z0-9]+/u', ' ')
            ->squish()
            ->toString();

        return $canonical !== '' ? $canonical : $this->squish($name);
    }

    private function squish(string $value): string
    {
        return Str::of($value)->squish()->toString();
    }
}
