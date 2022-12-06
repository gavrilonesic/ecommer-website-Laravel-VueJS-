<?php

namespace App;

use App\Email;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'big_id','first_name', 'last_name', 'email', 'password', 'mobile_no', 'gender', 'is_guest', 'shipping_service_name', 'shipping_account_number', 'shipping_note','is_reset_email_sent'
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

    public function orders()
    {
        return $this->hasMany('App\Order')->active();
    }

    public function coupons()
    {
        return $this->belongsToMany('App\Coupon');
    }

    public function wishlists()
    {
        return $this->belongsToMany('App\Product', 'wishlists');
    }

    public function userAddress()
    {
        return $this->hasMany('App\UserAddress');
    }

    // /**
    //  * Automatically creates hash for the admin password.
    //  *
    //  * @param  string  $value
    //  * @return void
    //  */
    // public function setPasswordAttribute($value)
    // {
    //     if (!empty($value)) {
    //         $this->attributes['password'] = Hash::make($value);
    //     }
    // }

    /**
     * Get the user name
     *
     * @return string URL
     */
    public function getNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    /**
     * Get the admin avatar URL
     *
     * @return string URL
     */
    public function getAvatarUrlAttribute()
    {
        return asset(config('constants.IMAGE_PATH.GENERAL_IMAGE') . config('constants.DEFAULT_IMAGE_NAME.AVATAR'));
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_FILL, config('constants.THUMB_IMAGE.WIDTH'), config('constants.THUMB_IMAGE.HEIGHT'))
            ->background('white')->nonQueued();

        $this->addMediaConversion('medium')
            ->fit(Manipulations::FIT_FILL, config('constants.MEDIUM_IMAGE.WIDTH'), config('constants.MEDIUM_IMAGE.HEIGHT'))
            ->background('white')->nonQueued();
    }

    public function medias()
    {
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\User");
    }

    public function whishlist()
    {
         return $this->hasMany('App\Wishlist');
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
            '[Customer Name]'       => $this->name ?? '',
            '[Reset Password Link]' => url("/password/reset/" . $token . '/' . $this->email),
        ];
        Email::sendEmail('customer.reset_link', $placeHolders, $this->email ?? '');
    }

}
