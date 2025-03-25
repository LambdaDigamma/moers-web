<?php

namespace Database\Factories;

use App\Blocks\TipTapTextWithMedia;
use App\Models\PageBlock;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageBlockFactory extends Factory
{
    protected $model = PageBlock::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->sentence(3),
        ];
    }

    public function published(): PageBlockFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => now(),
            ];
        });
    }

    public function expired(): PageBlockFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'expired_at' => now(),
            ];
        });
    }

    public function imageBlock()
    {
        return $this
            ->state(fn () => [
                'type' => 'single-image',

            ])
            ->afterCreating(function (PageBlock $block) {
                $url = 'https://source.unsplash.com/random/1200x800';
                $block
                    ->addMediaFromUrl($url)
                    ->withCustomProperties([
                        'de' => ['alt' => 'Das ist eine Bildbeschreibung.'],
                        'en' => ['alt' => 'That is a description.'],
                    ])
                    ->toMediaCollection('media');
            });
    }

    public function heroBlock($data = null): PageBlockFactory
    {
        return $this
            ->state(fn () => [
                'type' => PageBlock::$typeHero,
                'data' => $data,
            ]);
    }

    public function tipTapText($data = null): PageBlockFactory
    {
        if (is_null($data)) {
            return $this->state(fn () => [
                'type' => PageBlock::$typeTipTapText,
                'data' => [
                    'de' => [
                        'text' => [
                            'type' => 'doc',
                            'content' => [
                                [
                                    'type' => 'paragraph',
                                    'content' => [
                                        [
                                            'type' => 'text',
                                            'text' => 'Es geht an Pfingsten um nichts weniger als den Kampf um die Zukunft! Denn alles überziehende organische Ungeheuer crashen verstohlen unser gewohntes kulturelles Leben, stehlen unser soziales Miteinander. Und sie haben Kunst, Bildung und Kultur in Flammen gesetzt.',
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'paragraph',
                                    'content' => [
                                        [
                                            'type' => 'text',
                                            'text' => 'Bereits vor einem Jahr stachen wir in die wilde See, um die Utopie Moers vor den feuerspeienden Bestien zu beschützen. Genau genommen sind wir schon seit einem halben Jahrhundert in dieser Mission unterwegs – gemeinsam mit euch. Hey, lasst und das doch mal feiern!',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
        } else {
            return $this
                ->state(fn () => [
                    'type' => PageBlock::$typeTipTapText,
                    'data' => $data,
                ]);
        }
    }

    public function tipTapTextIllustration($data = null)
    {
        if (is_null($data)) {
            return $this->state(fn () => [
                'type' => PageBlock::$typeTipTapTextWithIllustration,
                'data' => [
                    'de' => [
                        'text' => [
                            'type' => 'doc',
                            'content' => [
                                [
                                    'type' => 'paragraph',
                                    'content' => [
                                        [
                                            'type' => 'text',
                                            'text' => 'Es geht an Pfingsten um nichts weniger als den Kampf um die Zukunft! Denn alles überziehende organische Ungeheuer crashen verstohlen unser gewohntes kulturelles Leben, stehlen unser soziales Miteinander. Und sie haben Kunst, Bildung und Kultur in Flammen gesetzt.',
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'paragraph',
                                    'content' => [
                                        [
                                            'type' => 'text',
                                            'text' => 'Bereits vor einem Jahr stachen wir in die wilde See, um die Utopie Moers vor den feuerspeienden Bestien zu beschützen. Genau genommen sind wir schon seit einem halben Jahrhundert in dieser Mission unterwegs – gemeinsam mit euch. Hey, lasst und das doch mal feiern!',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
        } else {
            return $this
                ->state(fn () => [
                    'type' => PageBlock::$typeTipTapTextWithIllustration,
                    'data' => $data,
                ]);
        }
    }

    public function tipTapTextWithMedia($data = null)
    {
        return $this
            ->state(fn () => [
                'type' => TipTapTextWithMedia::typeIdentifier(),
                'data' => $data,
            ]);
    }

}
