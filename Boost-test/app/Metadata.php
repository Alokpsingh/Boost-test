<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{

    public function video()
    {
        return $this->belongsTo('App\Video', 'video_id');
    }

}
