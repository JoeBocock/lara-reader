<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedItem extends Model
{
    protected $guarded = [];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
