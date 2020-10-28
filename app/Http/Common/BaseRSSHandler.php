<?php

namespace App\Http\Common;

use Illuminate\Support\Facades\Validator;
use App\Http\Common\Interfaces\RSSHandlerInterface;

abstract class BaseRSSHandler implements RSSHandlerInterface
{
    /**
     * Container for any errors.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Build a standard error object and request the return
     *
     * @param string $message
     * @param string $field
     * @return void
     */
    protected function error(string $message, string $field) : array
    {
        // Set a simple identifier
        $this->errors['success'] = false;

        // Format the error layout to mirror laravels error bag to help keep our Javascript clean
        $this->errors['errors'][$field] = [$message];

        // Return errors
        return $this->getErrors();
    }

    /**
     * return the current error set.
     *
     * @return array
     */
    protected function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * Compare a given version to the current XML version.
     *
     * @param string $feedVersion
     * @return boolean
     */
    protected function versionMatches(string $feedVersion): bool
    {
        return $this->version === $feedVersion;
    }

    /**
     * Validate a feed item against the database requirements.
     *
     * @param array $item
     * @return boolean
     */
    protected function isValidFeedItem(array $item): bool
    {
        $validator = Validator::make($item, [
            'title' => 'required|string|min:1|max:255',
            'link' => 'sometimes|string|url',
            'description' => 'sometimes|string|max:2000',
            'publish_date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        return $validator->errors()->count() === 0;
    }

    /**
     * Required to convert an XML feed into a storable format.
     *
     * @param string $url
     * @return void
     */
    abstract public function convertToDBFormat(string $url);
}
