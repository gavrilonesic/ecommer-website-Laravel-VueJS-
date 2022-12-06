<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedirectUrl extends Model
{
    use SoftDeletes;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;

    protected $fillable = ['old_url', 'new_url','domain'];

    public static function deleteOrCreate($oldUrl, $newUrl)
    {

        $url = Self::where('old_url', $newUrl)->first();
        if (empty($url)) {
            return Self::create(['old_url' => $oldUrl, 'new_url' => $newUrl]);
        } else {
            Self::create(['old_url' => $oldUrl, 'new_url' => $newUrl]);
            return $url->delete();
        }
    }

}
