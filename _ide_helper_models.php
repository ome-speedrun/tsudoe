<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AdminDiscord
 *
 * @property string $id
 * @property string $discord_id
 * @property string $administrator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Administrator $administrator
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDiscord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDiscord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDiscord query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDiscord whereAdministratorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDiscord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDiscord whereDiscordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDiscord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDiscord whereUpdatedAt($value)
 */
	class AdminDiscord extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Administrator
 *
 * @property string $id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $applications
 * @property-read int|null $applications_count
 * @property-read \App\Models\AdminDiscord|null $discord
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator query()
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereUpdatedAt($value)
 */
	class Administrator extends \Eloquent implements \Illuminate\Contracts\Auth\Authenticatable {}
}

namespace App\Models{
/**
 * App\Models\Application
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Administrator[] $administrators
 * @property-read int|null $administrators_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 */
	class Application extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicationAdministrator
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationAdministrator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationAdministrator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationAdministrator query()
 */
	class ApplicationAdministrator extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Event
 *
 * @property string $id
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EventMeta|null $meta
 * @property-read \App\Models\EventProfile|null $profile
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventHoldingPeriod
 *
 * @property string $id
 * @property string $event_id
 * @property int $order
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon $end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EventMeta|null $meta
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventHoldingPeriod whereUpdatedAt($value)
 */
	class EventHoldingPeriod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventMeta
 *
 * @property string $event_id
 * @property string $site_type
 * @property \Illuminate\Support\Carbon|null $submission_start_at
 * @property \Illuminate\Support\Carbon|null $submission_end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventHoldingPeriod[] $holdingPeriods
 * @property-read int|null $holding_periods_count
 * @method static \Illuminate\Database\Eloquent\Builder|EventMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMeta whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMeta whereSiteType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMeta whereSubmissionEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMeta whereSubmissionStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMeta whereUpdatedAt($value)
 */
	class EventMeta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventProfile
 *
 * @property string $event_id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventProfile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventProfile whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventProfile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventProfile whereUpdatedAt($value)
 */
	class EventProfile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $identifier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

