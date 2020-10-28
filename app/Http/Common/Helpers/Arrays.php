<?php

namespace App\Http\Common\Helpers;

class Arrays
{
    /**
     * Push a key value pair to a multidimensional array.
     *
     * @param array $array Array containing the children.
     * @param string $key Key of the new value.
     * @param string $value Value to be used.
     * @return array
     */
    public static function addKeyToChildren(array $array, string $key, $value = ''): array
    {
        foreach ($array as &$child) {
            if (is_array($child)) {
                $child[$key] = $value;
            }
        }

        return $array;
    }
}
