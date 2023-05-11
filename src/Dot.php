<?php

namespace ReactDot;

use Closure;

class Dot
{
    protected static $props;

    protected static $attributes;

    protected static $children;

    protected static $component;

    public static function render(string $component, array $props = [], string $children = '', string $attributes = '')
    {
        echo self::build($component, $props, $children, $attributes);
    }

    public static function build(string $component, array $props = [], string $children = '', string $attributes = '')
    {
        self::setChildren($children);
        self::setComponent($component);
        self::setProps($props);
        self::setAttributes($attributes);

        return self::getMarkup();
    }

    public static function share($key, $value = null)
    {
        global $react_shared_props;

        if (!isset($react_shared_props)) {
            $react_shared_props = [];
        }

        if (is_array($key)) {
            array_walk_recursive($key, function (&$prop) {
                if ($prop instanceof Closure) {
                    $prop = $prop();
                }
            });

            $react_shared_props = array_merge($react_shared_props, $key);
        } else {
            if ($value instanceof Closure) {
                $value = $value();
            }
            array_set($react_shared_props, $key, $value);
        }
    }

    protected static function setChildren(string $children)
    {
        self::$children = $children;
    }

    protected static function setComponent(string $component)
    {
        self::$component = $component;
    }

    protected static function setProps(array $props)
    {
        global $react_shared_props;

        if (!isset($react_shared_props)) {
            $react_shared_props = [];
        }

        $props = array_merge($props, $react_shared_props);

        array_walk_recursive($props, function (&$prop) {
            if ($prop instanceof Closure) {
                $prop = $prop();
            }
        });

        self::$props = $props;
    }

    protected static function setAttributes(string $attributes)
    {
        self::$attributes = $attributes;
    }

    protected static function getMarkup()
    {
        $attributes = self::$attributes;
        $component = self::$component;
        $children = self::$children;

        $data = "{$attributes} data-dot=\"{$component}\"";

        // convert array and objects to json
        foreach (self::$props as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $value = htmlspecialchars(
                    json_encode($value),
                    ENT_QUOTES,
                    'UTF-8',
                    true
                );
            }

            $data = "{$data} data-prop-{$key}=\"{$value}\"";
        }

        return <<<HTML
                <div {$data}>{$children}</div>
            HTML;
    }
}
