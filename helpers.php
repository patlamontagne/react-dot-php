<?php

if (! function_exists('react_dot')) {
    /**
     * ReactDot helper.
     *
     * @param  string  $component
     * @param  array   $props
     * @param  string  $placeholder
     * @return string
     */
    function react_dot($component, $props = [], $placeholder = '')
    {
        return \ReactDot\Dot::build($component, $props, $placeholder);
    }
}

if (!function_exists('array_set')) {
    function array_set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        foreach ($keys as $i => $key) {
            if (count($keys) === 1) {
                break;
            }

            unset($keys[$i]);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }
}
