<?php

namespace FRohlfing\Auth;

use Carbon\Carbon;
use FRohlfing\Base\Traits\AccessesRules;
use FRohlfing\Base\Traits\Searchable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

/**
 * FRohlfing\Auth\User
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $role
 * @property string $api_token
 * @property integer $rate_limit
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @method static create(array $attributes = [])
 * @method static Builder|User search($terms)
 * @method static truncate()
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereUsername($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRole($value)
 * @method static Builder|User whereApiToken($value)
 * @method static Builder|User whereRateLimit($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Builder // Strange! PhpStorm stops Auto Complete function if uncommented, but only in User Model! :-(
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Searchable;

    use AccessesRules {
        getRules as protected _getRules;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'rate_limit'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * The supported (and meaningful) cast types are:
     * int, float, string, bool, object, array, collection, date and datetime
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'rate_limit' => 'int',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Searchable fields.
     *
     * @var array
     */
    protected $searchable = [
        'name',
        'username',
        'email',
        'role',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name'       => 'required|max:255',
        'username'   => 'required|max:255|unique:users,username,{id}',
        'email'      => 'required|email|max:255|unique:users,email,{id}',
        'password'   => 'required|min:#|max:255|confirmed', // the minimum length is set by getRules().
        'role'       => 'required|max:16',
        'rate_limit' => 'int|nullable',
    ];

//    /**
//     * The booting method of the model
//     */
//    public static function boot()
//    {
//        parent::boot();
//
//        // Attach event handler, on creating or updating of the user
//		//static::saving(function($user) {
//		//	/** @var self $user */
//		//});
//
//        // Attach event handler, on creating of the user
//        //static::creating(function($user) {
//        //    /** @var self $user */
//        //});
//
//        // Attach event handler, on updating of the user
//        static::updating(function($user) {
//            /** @var self $user */
//            if (Auth::guest()) {
//                abort(403);
//            }
//            /** @var self $currUser */
//            $currUser = Auth::user();
//            if ($currUser === $user){
//                if ($user->isDirty('role')) {
//                //if ($user->role !== $user->getOriginal('role')) {
//                    abort(403);
//                }
//            }
//            else {
//                if ($currUser->cannot('manage-users')) {
//                    abort(403);
//                }
//                if ($user->role > $currUser->role) {
//                    abort(403);
//                }
//            }
//        });
//    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return config('broadcasting.prefix') . '-user.' . $this->id;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token)
    {
        //$this->notify(new ResetPasswordNotification($token));
        $user = $this;
        Mail::send('auth::emails.reset', compact('token', 'user'), function($message) use($user) {
            /** @var \Illuminate\Mail\Message $message */
            $message->to($user->getEmailForPasswordReset(), $user->name)->subject(__('auth::emails.reset.subject'));
        });
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        //$this->notify(new Notifications\VerifyEmail);
        $user = $this;
        Mail::send('auth::emails.verify', compact('user'), function ($message) use ($user) {
            /** @var \Illuminate\Mail\Message $message */
            $message->to($user->email, $user->name)->subject(__('auth::emails.verify.subject'));
        });

        session()->flash('message', __('auth::verify.sent'));
    }

    /**
     * Get the validation rules.
     *
     * The placeholder {id} is replaced with the ID of the current instances to avoid an Unique Rule Error.
     * Furthermore, the minimum length of the password is set to the configuration value.
     *
     * @return array
     */
    public function getRules()
    {
        $rules = $this->_getRules();
        $rules['password'] = str_replace('min:#', 'min:' . config('auth::password_length'), $rules['password']);

        return $rules;
    }
}
