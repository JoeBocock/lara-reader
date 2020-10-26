<?php

namespace App\Http\Common;

use App\Http\Common\Interfaces\RSSHandlerInterface;

abstract class BaseRSSHandler implements RSSHandlerInterface
{
    public function versionMatches(string $feedVersion): bool
    {
        return $this->version === $feedVersion;
    }

    abstract public function convertToDBFormat(string $url);
}
