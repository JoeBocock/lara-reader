<?php

namespace App\Http\Common\Interfaces;

interface RSSHandlerInterface
{
    /**
     * Convert a valid RSS feed to a usable database format.
     *
     * @param string $url
     * @return array
     */
    public function convertToDBFormat(string $url);
}
