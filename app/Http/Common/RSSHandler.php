<?php

namespace App\Http\Common;

use App\Feed;
use SimpleXMLElement;
use Illuminate\Support\Facades\Validator;
use App\Http\Common\Interfaces\RSSHandlerInterface;

class RSSHandler extends BaseRSSHandler implements RSSHandlerInterface
{
    /**
     * Version indicator used for checking the current RSS version.
     *
     * @var string
     */
    protected $version = '2.0';

    /**
     * Container for the current feed XML object.
     *
     * @var SimpleXMLElement
     */
    private $xmlFeed;

    /**
     * Container for the formatted return data pulled from the xml link.
     *
     * @var array
     */
    private $data = [];

    /**
     * Process the feed into a storable object
     *
     * @param string $url
     * @return void
     */
    public function convertToDBFormat(string $url)
    {
        $this->xmlFeed = simplexml_load_file($url);

        if (!$this->xmlFeed->attributes()->version[0] || !$this->versionMatches($this->xmlFeed->attributes()->version[0])) {
            $this->error('RSS feed version not supported.');

            return $this->getFeed();
        }

        $this->data['feed'] = new Feed;
        $this->data['feed']['title'] = $this->xmlFeed->channel->title;
        $this->data['feed']['link'] = $this->xmlFeed->channel->link;

        foreach ($this->xmlFeed->channel->item as $feedItem) {
            $item = [];

            $item['title'] = $feedItem->title;
            $item['link'] = $feedItem->link;
            $item['description'] = $feedItem->description;
            $item['publish_date'] = $feedItem->pubDate;

            if ($this->isValidFeedItem($item)) {
                $this->data['items'][] = $item;
            }
        }

        return $this->data;
    }

    /**
     * Build a standard error object and request the return
     *
     * @param string $message
     * @return void
     */
    private function error(string $message) : void
    {
        $this->data = [
            'success' => false,
            'message' => $message,
        ];
    }

    /**
     * return the current feed object
     *
     * @return array
     */
    private function getFeed() : array
    {
        return $this->feed;
    }

    public function isValidFeedItem(array $item): bool
    {
        $validator = Validator::make($item, [
            'title' => 'required|string|max_length[255]',
            'title' => 'required|string|url',
            'description' => 'required|string',
            'publish_date' => 'required',
        ]);

        return $validator->errors()->count() > 0;
    }
}
