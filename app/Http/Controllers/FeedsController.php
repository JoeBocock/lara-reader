<?php

namespace App\Http\Controllers;

use App\Http\Common\RSSHandler;
use App\Http\Requests\StoreFeedRequest;

class FeedsController extends Controller
{
    public function store(StoreFeedRequest $request, RSSHandler $handler)
    {
        $feedItems = $handler->convertToDBFormat($request->url);

        return response()->json($feedItems);
    }
}
