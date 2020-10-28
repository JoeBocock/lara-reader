<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $guarded = [];

    /**
     * Gather all feeds with their items.
     *
     * @return void
     */
    public function getAllWithItems(): array
    {
        $feeds = $this->all();

        foreach ($feeds as $feed) {
            $pariedFeeds[] = [
                'title' => $feed->title,
                'link' => $feed->link,
                'items' => $feed->items,
            ];
        }

        return $pariedFeeds ?? [];
    }

    /**
     * Setup a child relationship
     *
     * @return void
     */
    public function items()
    {
        return $this->hasMany(FeedItem::class);
    }
}
