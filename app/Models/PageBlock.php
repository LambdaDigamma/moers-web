<?php

namespace App\Models;

use App\Blocks\AudioPlayer;
use App\Blocks\HeroBlock;
use App\Blocks\ImageCollection;
use App\Blocks\LinkList;
use App\Blocks\TipTapText;
use App\Blocks\TipTapTextWithMedia;
use App\Blocks\VimeoVideo;
use App\Blocks\YoutubeVideo;
use App\Traits\Hideable;
use App\Traits\SerializeChildrenSlots;
use App\Traits\SerializeMedia;
use App\Traits\SerializeTranslations;
use Database\Factories\PageBlockFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use LaravelPublishable\Expirable;
use LaravelPublishable\Publishable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PageBlock extends Model implements HasMedia
{
    use Expirable;
    use HasFactory;
    use Hideable;
    use Publishable;
    use SerializeTranslations;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;
    use SerializeMedia;
    use SerializeChildrenSlots;

    protected $touches = ['page'];
    protected $table = 'mm_page_blocks';
    protected $guarded = ['*', 'id'];
    protected $casts = [
        'data' => 'array',
    ];
    protected $with = ['children'];
    public array $translatable = ['data'];

    public static function newFactory(): PageBlockFactory
    {
        return PageBlockFactory::new();
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function children(): PageBlock|HasMany
    {
        return $this
            ->hasMany(PageBlock::class, 'parent_id', 'id')
            ->orderBy('order');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PageBlock::class, 'parent_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        self::allDefaultMediaCollections()->each(function ($collectionName) {
            $this
                ->addMediaCollection($collectionName)
                ->withResponsiveImages();
        });

        $this
            ->addMediaCollection('media')
            ->withResponsiveImages();

        $this
            ->addMediaCollection('illustrations')
            ->withResponsiveImages();

        $this
            ->addMediaCollection('menu')
            ->withResponsiveImages();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->crop(300, 300)
            ->queued();

        $this->addMediaConversion('thumb')
            ->width(1000)
            ->height(500)
            ->performOnCollections('pdf_items')
            ->queued();
    }

    public static string $typeHero = "hero";
    public static string $typeTipTapText = "tiptap-text";
    public static string $typePanelWithImage = "panel-with-image";
    public static string $typePriceTable = "price-table";
    public static string $typeTeam = "team";
    public static string $typeTipTapTextWithIllustration = "tip-tap-text-with-illustration";
    public static string $typeTipTapTextTwoColumns = "tip-tap-text-two-columns";
    public static string $typeTipTapTextWithImageAndStats = "tip-tap-text-with-image-and-stats";
    public static string $typeFacebookLive = "facebook-live";

    public static function allBlockTypes()
    {
        return [
            'Hero' => HeroBlock::typeIdentifier(),
            'Text' => TipTapText::typeIdentifier(),
            'Text mit Medien (an der Seite)' => TipTapTextWithMedia::typeIdentifier(),
            'Text mit Illustration' => self::$typeTipTapTextWithIllustration,
            'Text (zwei Spalten)' => self::$typeTipTapTextTwoColumns,
            'Text (with Image and Stats' => self::$typeTipTapTextWithImageAndStats,
            'Panel mit Bild' => self::$typePanelWithImage,
            'Festival Preis' => self::$typePriceTable,
            'Team' => self::$typeTeam,
            'Facebook Live' => self::$typeFacebookLive,
            'Vimeo Video' => VimeoVideo::typeIdentifier(),
            'YouTube Video' => YoutubeVideo::typeIdentifier(),
            'Link-Liste' => LinkList::typeIdentifier(),
            'Bild' => ImageCollection::typeIdentifier(),
            'Audio Player' => AudioPlayer::typeIdentifier(),
        ];
    }

    public function generateBlockable()
    {
        $class = self::allBlockables()->get($this->type);
        return new $class($this);
    }

    public static function allBlockables(): Collection
    {
        return collect([
            HeroBlock::class,
            TipTapText::class,
            TipTapTextWithMedia::class,
            VimeoVideo::class,
            YoutubeVideo::class,
            LinkList::class,
            ImageCollection::class,
            AudioPlayer::class,
        ])->keyBy(function ($block) {
            return $block::typeIdentifier();
        });
    }

    public static function allDefaultMediaCollections()
    {
        return self::allBlockables()
            ->values()
            ->map(function ($class) {
                return $class::mediaCollectionNames();
            })
            ->flatten()
            ->unique();
    }

    public function toArray(): array
    {
        $attributes = parent::toArray();

        return array_merge(
            $attributes,
            $this->serializeMediaCollections(),
            $this->serializeChildrenSlots()
        );
    }
}
