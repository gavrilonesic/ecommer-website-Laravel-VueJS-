<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Sds extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'telephone', 'website', 'product', 'company_name','ip'
    ];
}
