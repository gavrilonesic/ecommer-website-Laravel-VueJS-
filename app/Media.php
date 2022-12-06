<?php

namespace App;

use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
}
