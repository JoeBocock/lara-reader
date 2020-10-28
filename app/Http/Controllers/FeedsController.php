<?php

namespace App\Http\Controllers;

use App\Feed;
use App\FeedItem;
use Illuminate\Http\Response;
use App\Http\Common\RSSHandler;
use Illuminate\Http\JsonResponse;
use App\Http\Common\Helpers\Arrays;
use App\Http\Requests\StoreFeedRequest;

class FeedsController extends Controller
{
    /**
     * Store a requested RSS feed.
     *
     * @param StoreFeedRequest $request
     * @param RSSHandler $handler
     * @return JsonResponse
     */
    public function store(StoreFeedRequest $request, RSSHandler $handler): JsonResponse
    {
        // Convert the passed RSS URL into usable data
        $handlerResponse = $handler->convertToDBFormat($request->url);

        // If the conversion was not successful, return the error bag with HTTP code.
        if (isset($handlerResponse['success']) && !$handlerResponse['success']) {
            return new JsonResponse($handlerResponse, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Store the Feed
        $feed = Feed::create($handlerResponse['feed']);

        // Key the feed items with their parents ID
        $handlerResponse['items'] = Arrays::addKeyToChildren($handlerResponse['items'], 'feed_id', $feed->id);

        // Bulk insert the data
        FeedItem::insert($handlerResponse['items']);

        // Response to request with created HTTP code and return core object
        return new JsonResponse($feed, Response::HTTP_CREATED);
    }
}
