<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Activity
 *
 * @property int $id
 * @property int $user_id
 * @property string $associated_table_name
 * @property int $associated_object_index
 * @property string $origin_value
 * @property string $new_value
 * @property int $reward
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Activity newModelQuery()
 * @method static Builder|Activity newQuery()
 * @method static Builder|Activity query()
 * @method static Builder|Activity whereAssociatedObjectIndex($value)
 * @method static Builder|Activity whereAssociatedTableName($value)
 * @method static Builder|Activity whereCreatedAt($value)
 * @method static Builder|Activity whereDescription($value)
 * @method static Builder|Activity whereId($value)
 * @method static Builder|Activity whereNewValue($value)
 * @method static Builder|Activity whereOriginValue($value)
 * @method static Builder|Activity whereReward($value)
 * @method static Builder|Activity whereUpdatedAt($value)
 * @method static Builder|Activity whereUserId($value)
 * @mixin Eloquent
 */
	class Activity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdvEvent
 *
 * @property int                                                                                                $id
 * @property string                                                                                             $name
 * @property string|null                                                                                        $start_date
 * @property string|null                                                                                        $end_date
 * @property string|null                                                                                        $description
 * @property string|null                                                                                        $url
 * @property string|null                                                                                        $image_path
 * @property string|null                 $category
 * @property int|null                    $organisation_id
 * @property int|null                    $entry_id
 * @property int                         $is_published
 * @property array|null                  $extras
 * @property Carbon|null                 $deleted_at
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property-read \App\Models\Entry|null $entry
 * @property-read Organisation|null      $organisation
 * @method static bool|null forceDelete()
 * @method static Builder|AdvEvent newModelQuery()
 * @method static Builder|AdvEvent newQuery()
 * @method static \Illuminate\Database\Query\Builder|AdvEvent onlyTrashed()
 * @method static Builder|AdvEvent query()
 * @method static bool|null restore()
 * @method static Builder|AdvEvent whereCategory($value)
 * @method static Builder|AdvEvent whereCreatedAt($value)
 * @method static Builder|AdvEvent whereDeletedAt($value)
 * @method static Builder|AdvEvent whereDescription($value)
 * @method static Builder|AdvEvent whereEndDate($value)
 * @method static Builder|AdvEvent whereEntryId($value)
 * @method static Builder|AdvEvent whereExtras($value)
 * @method static Builder|AdvEvent whereId($value)
 * @method static Builder|AdvEvent whereImagePath($value)
 * @method static Builder|AdvEvent whereIsPublished($value)
 * @method static Builder|AdvEvent whereName($value)
 * @method static Builder|AdvEvent whereOrganisationId($value)
 * @method static Builder|AdvEvent whereStartDate($value)
 * @method static Builder|AdvEvent whereUpdatedAt($value)
 * @method static Builder|AdvEvent whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|AdvEvent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AdvEvent withoutTrashed()
 * @mixin Eloquent
 * @property int|null                                                                                           $page_id
 * @property string|null                                                                                        $scheduled_at
 * @property-read mixed                                                                                         $header_url
 * @property-read mixed                                                                                         $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null                                                                                      $media_count
 * @property-read \App\Models\Page|null                                                                         $page
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent chronological()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent future()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent nextDays()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent today()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent upcomingToday()
 * @method static Builder|AdvEvent filter(array $filters)
 * @method static \Database\Factories\AdvEventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AdvEvent whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvEvent whereLocales(string $column, array $locales)
 */
	class AdvEvent extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Conversation
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Message[] $messages
 * @property-read int|null $messages_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Conversation newModelQuery()
 * @method static Builder|Conversation newQuery()
 * @method static Builder|Conversation query()
 * @method static Builder|Conversation whereCreatedAt($value)
 * @method static Builder|Conversation whereId($value)
 * @method static Builder|Conversation whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class Conversation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Dataset
 *
 * @property int                                                                         $id
 * @property array                                                                       $name
 * @property string|null                                                                 $source_url
 * @property string|null                                                                 $licence
 * @property string|null                                                                 $categories
 * @property \Illuminate\Support\Carbon|null                                             $created_at
 * @property \Illuminate\Support\Carbon|null                                             $updated_at
 * @property-read mixed                                                                  $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DatasetResource[] $resources
 * @property-read int|null                                                               $resources_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereLicence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereSourceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\DatasetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Dataset whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Dataset whereLocales(string $column, array $locales)
 */
	class Dataset extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DatasetResource
 *
 * @property int                                                                                                $id
 * @property string                                                                                             $name
 * @property string|null                                                                                        $source_url
 * @property string                                                                                             $format
 * @property string|null                                                                                        $error
 * @property int|null                                                                                           $auto_updating_interval
 * @property int                                                                                                $dataset_id
 * @property \Illuminate\Support\Carbon|null                                                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                                                    $updated_at
 * @property-read \App\Models\Dataset                                                                           $dataset
 * @property-read mixed                                                                                         $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null                                                                                      $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereAutoUpdatingInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereDatasetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereSourceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\DatasetResourceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DatasetResource whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|DatasetResource whereLocales(string $column, array $locales)
 */
	class DatasetResource extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Entry
 *
 * @property int $id
 * @property float $lat
 * @property float $lng
 * @property string $name
 * @property string $tags
 * @property string $street
 * @property string $house_number
 * @property string $postcode
 * @property string $place
 * @property string|null $url
 * @property string|null $phone
 * @property string|null $monday
 * @property string|null $tuesday
 * @property string|null $wednesday
 * @property string|null $thursday
 * @property string|null $friday
 * @property string|null $saturday
 * @property string|null $sunday
 * @property string|null $other
 * @property int|null $user_id
 * @property int $is_validated
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Collection|Event[] $events
 * @property-read int|null $events_count
 * @property-read Collection|Organisation[] $organisations
 * @property-read int|null $organisations_count
 * @method static bool|null forceDelete()
 * @method static Builder|Entry newModelQuery()
 * @method static Builder|Entry newQuery()
 * @method static Builder|Entry onlyTrashed()
 * @method static Builder|Entry query()
 * @method static bool|null restore()
 * @method static Builder|Entry whereCreatedAt($value)
 * @method static Builder|Entry whereDeletedAt($value)
 * @method static Builder|Entry whereFriday($value)
 * @method static Builder|Entry whereHouseNumber($value)
 * @method static Builder|Entry whereId($value)
 * @method static Builder|Entry whereIsValidated($value)
 * @method static Builder|Entry whereLat($value)
 * @method static Builder|Entry whereLng($value)
 * @method static Builder|Entry whereMonday($value)
 * @method static Builder|Entry whereName($value)
 * @method static Builder|Entry whereOther($value)
 * @method static Builder|Entry wherePhone($value)
 * @method static Builder|Entry wherePlace($value)
 * @method static Builder|Entry wherePostcode($value)
 * @method static Builder|Entry whereSaturday($value)
 * @method static Builder|Entry whereStreet($value)
 * @method static Builder|Entry whereSunday($value)
 * @method static Builder|Entry whereTags($value)
 * @method static Builder|Entry whereThursday($value)
 * @method static Builder|Entry whereTuesday($value)
 * @method static Builder|Entry whereUpdatedAt($value)
 * @method static Builder|Entry whereUrl($value)
 * @method static Builder|Entry whereUserId($value)
 * @method static Builder|Entry whereWednesday($value)
 * @method static Builder|Entry withTrashed()
 * @method static Builder|Entry withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed $header_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Entry filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry validated()
 * @method static \Database\Factories\EntryFactory factory($count = null, $state = [])
 */
	class Entry extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable, \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Event
 *
 * @property int $id
 * @property array $name
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property array|null $description
 * @property int|null $page_id
 * @property string|null $url
 * @property string|null $image_path
 * @property array|null $category
 * @property int|null $organisation_id
 * @property int|null $place_id
 * @property string|null $platform_id
 * @property \Illuminate\Support\Collection|null $extras
 * @property \Illuminate\Support\Carbon|null $scheduled_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $cancelled_at
 * @property \Illuminate\Support\Carbon|null $archived_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $attendance_mode
 * @property-read mixed $duration
 * @property-read mixed $is_online
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \LambdaDigamma\MMEvents\Models\Ticket> $ticketAssignments
 * @property-read int|null $ticket_assignments_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Event active()
 * @method static \Illuminate\Database\Eloquent\Builder|Event chronological()
 * @method static \Illuminate\Database\Eloquent\Builder|Event collection(string $collectionName)
 * @method static \Illuminate\Database\Eloquent\Builder|Event drafts()
 * @method static \LambdaDigamma\MMEvents\Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Event filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Event future()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event nextDays()
 * @method static \Illuminate\Database\Eloquent\Builder|Event noCollection()
 * @method static \Illuminate\Database\Eloquent\Builder|Event offline()
 * @method static \Illuminate\Database\Eloquent\Builder|Event onlineAndMixed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event onlyLongTermEvents(?int $duration_threshold = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Event onlyOnline()
 * @method static \Illuminate\Database\Eloquent\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event past()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event today()
 * @method static \Illuminate\Database\Eloquent\Builder|Event upcoming()
 * @method static \Illuminate\Database\Eloquent\Builder|Event upcomingToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePlatformId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event withDaysDuration()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withMinutesDuration()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withSecondsDuration()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withoutLongTermEvents(?int $duration_threshold = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Event withoutTrashed()
 */
	class Event extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Group
 *
 * @property integer|null organisation_id
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Poll[] $polls
 * @property-read int|null $polls_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static Builder|Group newModelQuery()
 * @method static Builder|Group newQuery()
 * @method static \Illuminate\Database\Query\Builder|Group onlyTrashed()
 * @method static Builder|Group query()
 * @method static bool|null restore()
 * @method static Builder|Group whereCreatedAt($value)
 * @method static Builder|Group whereDeletedAt($value)
 * @method static Builder|Group whereDescription($value)
 * @method static Builder|Group whereId($value)
 * @method static Builder|Group whereName($value)
 * @method static Builder|Group whereOrganisationId($value)
 * @method static Builder|Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Group withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Group withoutTrashed()
 * @mixin Eloquent
 * @property-read Organisation|null $organisation
 * @property int|null $organisation_id
 * @method static \Database\Factories\GroupFactory factory($count = null, $state = [])
 */
	class Group extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HelpRequest
 *
 * @property int $id
 * @property string $request
 * @property int $quarter_id
 * @property int $creator_id
 * @property int|null $helper_id
 * @property string|null $served_on
 * @property int|null $conversation_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Conversation|null $conversation
 * @property-read User $creator
 * @property-read User|null $helper
 * @property-read Quarter $quarter
 * @method static Builder|HelpRequest filter($filters)
 * @method static Builder|HelpRequest newModelQuery()
 * @method static Builder|HelpRequest newQuery()
 * @method static Builder|HelpRequest notServed()
 * @method static Builder|HelpRequest query()
 * @method static Builder|HelpRequest userHelps()
 * @method static Builder|HelpRequest whereConversationId($value)
 * @method static Builder|HelpRequest whereCreatedAt($value)
 * @method static Builder|HelpRequest whereCreatorId($value)
 * @method static Builder|HelpRequest whereHelperId($value)
 * @method static Builder|HelpRequest whereId($value)
 * @method static Builder|HelpRequest whereQuarterId($value)
 * @method static Builder|HelpRequest whereRequest($value)
 * @method static Builder|HelpRequest whereServedOn($value)
 * @method static Builder|HelpRequest whereUpdatedAt($value)
 * @method static Builder|HelpRequest withoutOwn()
 * @mixin Eloquent
 */
	class HelpRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Message
 *
 * @property int $id
 * @property int $sender_id
 * @property int $conversation_id
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Conversation $conversation
 * @property-read User $sender
 * @method static Builder|Message newModelQuery()
 * @method static Builder|Message newQuery()
 * @method static Builder|Message query()
 * @method static Builder|Message whereContent($value)
 * @method static Builder|Message whereConversationId($value)
 * @method static Builder|Message whereCreatedAt($value)
 * @method static Builder|Message whereId($value)
 * @method static Builder|Message whereSenderId($value)
 * @method static Builder|Message whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property array $title
 * @property array $slug
 * @property int|null $creator_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|PageBlock[] $blocks
 * @property-read int|null $blocks_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Page filter($filters)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static Builder|Page onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page withTrashed()
 * @method static Builder|Page withoutTrashed()
 * @mixin Eloquent
 * @property-read \App\Models\User|null $creator
 * @method static \Database\Factories\PageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLocales(string $column, array $locales)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PageBlock
 *
 * @property int $id
 * @property int $page_id
 * @property string $type
 * @property array $data
 * @property int|null $order
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $translations
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read Page $page
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock newQuery()
 * @method static Builder|PageBlock onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereUpdatedAt($value)
 * @method static Builder|PageBlock withTrashed()
 * @method static Builder|PageBlock withoutTrashed()
 * @mixin Eloquent
 * @method static \Database\Factories\PageBlockFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereLocales(string $column, array $locales)
 */
	class PageBlock extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Poll
 *
 * @property string $question
 * @property string $description
 * @property int|null $group_id
 * @property string|null $ends_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $has_started
 * @property-read mixed $has_user_vote
 * @property-read mixed $is_coming_soon
 * @property-read mixed $is_locked
 * @property-read mixed $is_open
 * @property-read mixed $is_radio
 * @property-read mixed $is_running
 * @property-read mixed $results
 * @property-read mixed $show_results_enabled
 * @property-read Group|null $group
 * @property-read Collection|PollOption[] $options
 * @property-read int|null $options_count
 * @property-read Collection|Vote[] $votes
 * @property-read int|null $votes_count
 * @method static Builder|Poll newModelQuery()
 * @method static Builder|Poll newQuery()
 * @method static Builder|Poll query()
 * @method static Builder|Poll whereCanVisitorsVote($value)
 * @method static Builder|Poll whereCanVoterSeeResult($value)
 * @method static Builder|Poll whereCreatedAt($value)
 * @method static Builder|Poll whereDescription($value)
 * @method static Builder|Poll whereEndsAt($value)
 * @method static Builder|Poll whereGroupId($value)
 * @method static Builder|Poll whereId($value)
 * @method static Builder|Poll whereIsClosed($value)
 * @method static Builder|Poll whereMaxCheck($value)
 * @method static Builder|Poll whereQuestion($value)
 * @method static Builder|Poll whereStartsAt($value)
 * @method static Builder|Poll whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $id
 * @property int $max_check
 * @property int $can_visitors_vote
 * @property int $can_voter_see_result
 * @property string|null $is_closed
 * @property string|null $starts_at
 * @method static Builder|Poll answered()
 * @method static Builder|Poll filter($filters)
 * @method static Builder|Poll unanswered()
 * @method static \Database\Factories\PollFactory factory($count = null, $state = [])
 */
	class Poll extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PollOption
 *
 * @property int $id
 * @property string $name
 * @property int $poll_id
 * @property int $votes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Poll $poll
 * @method static Builder|PollOption newModelQuery()
 * @method static Builder|PollOption newQuery()
 * @method static Builder|PollOption query()
 * @method static Builder|PollOption whereCreatedAt($value)
 * @method static Builder|PollOption whereId($value)
 * @method static Builder|PollOption whereName($value)
 * @method static Builder|PollOption wherePollId($value)
 * @method static Builder|PollOption whereUpdatedAt($value)
 * @method static Builder|PollOption whereVotes($value)
 * @mixin Eloquent
 * @method static \Database\Factories\PollOptionFactory factory($count = null, $state = [])
 */
	class PollOption extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Quarter
 *
 * @property int $id
 * @property string $name
 * @property string $postcode
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Quarter newModelQuery()
 * @method static Builder|Quarter newQuery()
 * @method static Builder|Quarter query()
 * @method static Builder|Quarter whereCreatedAt($value)
 * @method static Builder|Quarter whereId($value)
 * @method static Builder|Quarter whereName($value)
 * @method static Builder|Quarter wherePostcode($value)
 * @method static Builder|Quarter whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class Quarter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RadioBroadcast
 *
 * @property int $id
 * @property string $uid
 * @property array|null $title
 * @property array|null $description
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property string|null $url
 * @property string|null $attach
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast chronological()
 * @method static \Database\Factories\RadioBroadcastFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast future()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast past()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast query()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast upcoming()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereAttach($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioBroadcast whereUrl($value)
 */
	class RadioBroadcast extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StudentInformation
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $nickname
 * @property string $birthday
 * @property string $slogan
 * @property string $motto
 * @property string $strengths
 * @property string $weaknesses
 * @property string $lkA
 * @property string $lkB
 * @property string $highlight
 * @property string $soundtrack
 * @property string $miss_least
 * @property string $miss_most
 * @property string|null $photo_old_path
 * @property string|null $photo_new_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|StudentInformation newModelQuery()
 * @method static Builder|StudentInformation newQuery()
 * @method static Builder|StudentInformation query()
 * @method static Builder|StudentInformation whereBirthday($value)
 * @method static Builder|StudentInformation whereCreatedAt($value)
 * @method static Builder|StudentInformation whereHighlight($value)
 * @method static Builder|StudentInformation whereId($value)
 * @method static Builder|StudentInformation whereLkA($value)
 * @method static Builder|StudentInformation whereLkB($value)
 * @method static Builder|StudentInformation whereMissLeast($value)
 * @method static Builder|StudentInformation whereMissMost($value)
 * @method static Builder|StudentInformation whereMotto($value)
 * @method static Builder|StudentInformation whereName($value)
 * @method static Builder|StudentInformation whereNickname($value)
 * @method static Builder|StudentInformation wherePhotoNewPath($value)
 * @method static Builder|StudentInformation wherePhotoOldPath($value)
 * @method static Builder|StudentInformation whereSlogan($value)
 * @method static Builder|StudentInformation whereSoundtrack($value)
 * @method static Builder|StudentInformation whereStrengths($value)
 * @method static Builder|StudentInformation whereUpdatedAt($value)
 * @method static Builder|StudentInformation whereUserId($value)
 * @method static Builder|StudentInformation whereWeaknesses($value)
 * @mixin Eloquent
 */
	class StudentInformation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tracker
 *
 * @property int $id
 * @property string $device_id
 * @property string|null $name
 * @property string|null $description
 * @property bool $is_enabled
 * @property string|null $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Tracker newModelQuery()
 * @method static Builder|Tracker newQuery()
 * @method static Builder|Tracker query()
 * @method static Builder|Tracker whereCreatedAt($value)
 * @method static Builder|Tracker whereDescription($value)
 * @method static Builder|Tracker whereDeviceId($value)
 * @method static Builder|Tracker whereId($value)
 * @method static Builder|Tracker whereIsEnabled($value)
 * @method static Builder|Tracker whereName($value)
 * @method static Builder|Tracker whereType($value)
 * @method static Builder|Tracker whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class Tracker extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $description
 * @property int $points
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property string|null $provider_id
 * @property string|null $provider
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Silber\Bouncer\Database\Ability> $abilities
 * @property-read int|null $abilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Conversation> $conversations
 * @property-read int|null $conversations_count
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HelpRequest> $helpRequests
 * @property-read int|null $help_requests_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Organisation\Models\Organisation> $organisations
 * @property-read int|null $organisations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Silber\Bouncer\Database\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\StudentInformation|null $studentInformation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIs($role)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAll($role)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsNot($role)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Spatie\PersonalDataExport\ExportsPersonalData {}
}

namespace App\Models{
/**
 * App\Models\Vote
 *
 * @property int $id
 * @property int $user_id
 * @property int $poll_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Vote newModelQuery()
 * @method static Builder|Vote newQuery()
 * @method static Builder|Vote query()
 * @method static Builder|Vote whereCreatedAt($value)
 * @method static Builder|Vote whereId($value)
 * @method static Builder|Vote wherePollId($value)
 * @method static Builder|Vote whereUpdatedAt($value)
 * @method static Builder|Vote whereUserId($value)
 * @mixin Eloquent
 * @property-read Poll $poll
 * @property-read User|null $user
 */
	class Vote extends \Eloquent {}
}

namespace Modules\News\Models{
/**
 * Modules\News\Models\Post
 *
 * @property int $id
 * @property array|null $title
 * @property array|null $summary
 * @property array|null $slug
 * @property int|null $page_id
 * @property array|null $external_href
 * @property string|null $guid
 * @property string|null $source
 * @property int|null $organisation_id
 * @property \Illuminate\Support\Collection|null $extras
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $archived_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \LambdaDigamma\MMFeeds\Models\Feed> $feeds
 * @property-read int|null $feeds_count
 * @property mixed $cta
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Post chronological()
 * @method static \LambdaDigamma\MMFeeds\Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereExternalHref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post withoutTrashed()
 */
	class Post extends \Eloquent {}
}

namespace Modules\Organisation\Models{
/**
 * App\Models\Organisation
 *
 * @property integer|null                                                                                       group_id
 * @property int                                                                                                $id
 * @property string                                                                                             $name
 * @property string                                                                                             $description
 * @property int|null                                                                                           $entry_id
 * @property string|null                                                                                        $tags
 * @property string|null                                                                                        $logo_url
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Entry|null $entry
 * @property-read Collection|AdvEvent[] $events
 * @property-read int|null $events_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static Builder|Organisation newModelQuery()
 * @method static Builder|Organisation newQuery()
 * @method static \Illuminate\Database\Query\Builder|Organisation onlyTrashed()
 * @method static Builder|Organisation query()
 * @method static bool|null restore()
 * @method static Builder|Organisation whereCreatedAt($value)
 * @method static Builder|Organisation whereDeletedAt($value)
 * @method static Builder|Organisation whereDescription($value)
 * @method static Builder|Organisation whereEntryId($value)
 * @method static Builder|Organisation whereGroupId($value)
 * @method static Builder|Organisation whereId($value)
 * @method static Builder|Organisation whereLogoUrl($value)
 * @method static Builder|Organisation whereName($value)
 * @method static Builder|Organisation whereTags($value)
 * @method static Builder|Organisation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Organisation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Organisation withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed                                                                                         $header_path
 * @property-read mixed                                                                                         $logo_path
 * @property-read \App\Models\Group                                                                             $mainGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null                                                                                      $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdvEvent[]                               $publishedEvents
 * @property-read int|null                                                                                      $published_events_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organisation filter($filters)
 * @property int|null $group_id
 * @method static \Modules\Organisation\Database\Factories\OrganisationFactory factory($count = null, $state = [])
 */
	class Organisation extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace Modules\Parking\Models{
/**
 * Modules\Parking\Models\ParkingArea
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $location
 * @property string|null $current_opening_state
 * @property int|null $capacity
 * @property int|null $occupied_sites
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea closed()
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea comparison($geometryColumn, $geometry, $relationship)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea contains($geometryColumn, $geometry)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea crosses($geometryColumn, $geometry)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea disjoint($geometryColumn, $geometry)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea distance($geometryColumn, $geometry, $distance)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea distanceExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea distanceSphere($geometryColumn, $geometry, $distance)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea distanceSphereExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea distanceSphereValue($geometryColumn, $geometry)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea distanceValue($geometryColumn, $geometry)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea doesTouch($geometryColumn, $geometry)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea equals($geometryColumn, $geometry)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea intersects($geometryColumn, $geometry)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea newModelQuery()
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea newQuery()
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea open()
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea orderByDistance($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea orderByDistanceSphere($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea orderByOpeningState()
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea orderBySpatial($geometryColumn, $geometry, $orderFunction, $direction = 'asc')
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea overlaps($geometryColumn, $geometry)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea query()
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea whereCapacity($value)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea whereCreatedAt($value)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea whereCurrentOpeningState($value)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea whereId($value)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea whereLocation($value)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea whereName($value)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea whereOccupiedSites($value)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea whereSlug($value)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea whereUpdatedAt($value)
 * @method static \Limenet\LaravelMysqlSpatial\Eloquent\Builder|ParkingArea within($geometryColumn, $polygon)
 */
	class ParkingArea extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace Modules\Parking\Models{
/**
 * Modules\Parking\Models\ParkingAreaOccupancy
 *
 * @property int $id
 * @property string $occupancy_rate
 * @property int $occupied_sites
 * @property int $capacity
 * @property string|null $opening_state
 * @property int $parking_area_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy whereOccupancyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy whereOccupiedSites($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy whereOpeningState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy whereParkingAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingAreaOccupancy whereUpdatedAt($value)
 */
	class ParkingAreaOccupancy extends \Eloquent {}
}

namespace Modules\Rubbish\Models{
/**
 * App\Models\RubbishScheduleItem
 *
 * @property int $id
 * @property string $date
 * @property array $residual_tours
 * @property array $organic_tours
 * @property array $paper_tours
 * @property array $plastic_tours
 * @property array $cuttings_tours
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|RubbishScheduleItem newModelQuery()
 * @method static Builder|RubbishScheduleItem newQuery()
 * @method static Builder|RubbishScheduleItem query()
 * @method static Builder|RubbishScheduleItem upcoming()
 * @method static Builder|RubbishScheduleItem whereCreatedAt($value)
 * @method static Builder|RubbishScheduleItem whereCuttingsTours($value)
 * @method static Builder|RubbishScheduleItem whereDate($value)
 * @method static Builder|RubbishScheduleItem whereId($value)
 * @method static Builder|RubbishScheduleItem whereOrganicTours($value)
 * @method static Builder|RubbishScheduleItem wherePaperTours($value)
 * @method static Builder|RubbishScheduleItem wherePlasticTours($value)
 * @method static Builder|RubbishScheduleItem whereResidualTours($value)
 * @method static Builder|RubbishScheduleItem whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class RubbishScheduleItem extends \Eloquent {}
}

namespace Modules\Rubbish\Models{
/**
 * App\Models\RubbishStreet
 *
 * @property int $id
 * @property string $name
 * @property string|null $street_addition
 * @property int $residual_tour
 * @property int $organic_tour
 * @property int $paper_tour
 * @property int $plastic_tour
 * @property int $cuttings_tour
 * @property string $year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|RubbishStreet current()
 * @method static Builder|RubbishStreet newModelQuery()
 * @method static Builder|RubbishStreet newQuery()
 * @method static Builder|RubbishStreet query()
 * @method static Builder|RubbishStreet whereCreatedAt($value)
 * @method static Builder|RubbishStreet whereCuttingsTour($value)
 * @method static Builder|RubbishStreet whereId($value)
 * @method static Builder|RubbishStreet whereName($value)
 * @method static Builder|RubbishStreet whereOrganicTour($value)
 * @method static Builder|RubbishStreet wherePaperTour($value)
 * @method static Builder|RubbishStreet wherePlasticTour($value)
 * @method static Builder|RubbishStreet whereResidualTour($value)
 * @method static Builder|RubbishStreet whereStreetAddition($value)
 * @method static Builder|RubbishStreet whereUpdatedAt($value)
 * @method static Builder|RubbishStreet whereYear($value)
 * @mixin Eloquent
 */
	class RubbishStreet extends \Eloquent {}
}

