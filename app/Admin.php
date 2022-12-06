<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Admin extends Authenticatable implements HasMedia
{
    use HasMediaTrait;
    use Notifiable;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($callback) {
            self::flushCache($callback->id);
        });
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $placeHolders = [
            '[Admin Name]'          => $this->name ?? '',
            '[Reset Password Link]' => url(config('app.url') . route('admin.password.reset', $token, false)),
        ];
        Email::sendEmail('admin.reset_link', $placeHolders, $this->email ?? '');
    }

    /**
     * Get the admin avatar URL
     *
     * @return string URL
     */
    public function getAvatarUrlAttribute()
    {
        if (!empty($this->getMedia('admin')->first())) {
            return $this->getMedia('admin')->first()->getUrl('thumb');
        } else {
            return asset(config('constants.IMAGE_PATH.GENERAL_IMAGE') . config('constants.DEFAULT_IMAGE_NAME.AVATAR'));
        }
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_FILL, 250, 250)
            ->background('white')->nonQueued();

        $this->addMediaConversion('medium')
            ->fit(Manipulations::FIT_FILL, 500, 500)
            ->background('white')->nonQueued();
    }

    public function medias()
    {
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\Admin");
    }

    // *
    //  * Automatically creates hash for the admin password.
    //  *
    //  * @param  string  $value
    //  * @return void

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'admin_permission');
    }

    /**
     * Get all the settings
     *
     * @return mixed
     */
    public static function getPermissions($admin)
    {
        return Cache::rememberForever('admin_' . $admin, function () use ($admin) {
            $permissions = self::with('permissions')->findOrFail($admin)->toArray();

            return array_column($permissions['permissions'], 'permission_key', 'id');
        });
    }

    /**
     * Flush the cache
     */
    public static function flushCache($admin)
    {
        Cache::forget('admin_' . $admin);
    }
}
