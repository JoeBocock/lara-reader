<?php

namespace App\Http\Common;

use SimpleXMLElement;
use App\Http\Common\Interfaces\RSSHandlerInterface;

final class RSSHandler extends BaseRSSHandler implements RSSHandlerInterface
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
            return $this->error('RSS feed version not supported.', 'url');
        }

        $this->data['feed'] = $this->buildFeed($url);

        $this->data['items'] = $this->buildFeedItems();

        if (empty($this->data['items'])) {
            return $this->error('The provided feed has no valid items. Please try a different feed.', 'url');
        }

        return $this->data;
    }

    /**
     * Build a valid feed object.
     *
     * @uses RSSHandler->$xmlFeed
     * @param string $url
     * @return void
     */
    private function buildFeed(string $url): array
    {
        return [
            'title' => $this->xmlFeed->channel->title->__toString() ?? '',
            'link' => $this->xmlFeed->channel->link->__toString() ?? '',
            'origin' => $url ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Build a valid set of feed items.
     *
     * @uses RSSHandler->$xmlFeed
     * @return array
     */
    private function buildFeedItems(): array
    {
        $items = [];
        $date = date('Y-m-d H:i:s');

        foreach ($this->xmlFeed->channel->item as $feedItem) {
            $item = [
                'title' => $feedItem->title->__toString() ?? '',
                'link' => $feedItem->link->__toString() ?? '',
                'description' => strip_tags($feedItem->description->__toString()) ?? '',
                'publish_date' => date('Y-m-d H:i:s', strtotime($feedItem->pubDate->__toString()) ?? 0),
                'created_at' => $date,
                'updated_at' => $date,
            ];

            if ($this->isValidFeedItem($item)) {
                $items[] = $item;
            }
        }

        return $items;
    }
}
