<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'permission_key', 'parent_id',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function childs()
    {
        return $this->hasMany('App\Permission', 'parent_id', 'id');
    }
}
