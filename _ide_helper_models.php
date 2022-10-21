<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Activity
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property string $value
 * @property string|null $color
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @mixin \Eloquent
 */
	class Activity extends \Eloquent {}
}

namespace App{
/**
 * App\Admin
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property string $firstname
 * @property string $lastname
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @mixin \Eloquent
 */
	class Admin extends \Eloquent {}
}

namespace App{
/**
 * App\Client
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $street
 * @property string $street_nr
 * @property string $postcode
 * @property string $phone_number
 * @property string $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @mixin \Eloquent
 */
	class Client extends \Eloquent {}
}

namespace App{
/**
 * App\DailyActivity
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property array $time_slots
 * @property array $main_activities
 * @property array $scaled_activities
 * @property array $scaled_activities_scores
 * @property string $date_today
 * @property array $colors
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity query()
 * @mixin \Eloquent
 */
	class DailyActivity extends \Eloquent {}
}

namespace App{
/**
 * App\DailyQuestion
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property array $questions
 * @property array $scores
 * @property array $mentor_scores
 * @property string|null $mentor_id
 * @property \Illuminate\Support\Carbon|null $filled_at
 * @property \Illuminate\Support\Carbon|null $mentor_filled_at
 * @property bool $filled
 * @property bool $mentor_filled
 * @property-read \App\Client|null $client
 * @method static \Illuminate\Database\Eloquent\Builder|DailyQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyQuestion query()
 * @mixin \Eloquent
 */
	class DailyQuestion extends \Eloquent {}
}

namespace App{
/**
 * App\Mentor
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $street
 * @property string $street_nr
 * @property string $postcode
 * @property string $phone_number
 * @property string $city
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor query()
 * @mixin \Eloquent
 */
	class Mentor extends \Eloquent {}
}

namespace App{
/**
 * App\Question
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property string $question
 * @property-read Client|null $client
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @mixin \Eloquent
 */
	class Question extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property int $active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Client|null $client
 * @property-read \App\Mentor|null $mentor
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

