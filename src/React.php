<?php

namespace Patlamontagne\PhpReact;

use Closure;

class React
{
    protected static $className = 'react-component';

    protected static $props;

    protected static $version;

    protected static $placeholder;

    protected static $component;

    protected static $shared_props = [];

    public static function render(string $component, array $props = [], string $placeholder = '')
    {
        self::setPlaceholder($placeholder);
        self::setComponent($component);
        self::setProps($props);

        echo self::getMarkup();
    }

    public static function share($key, $value = null)
    {
        global $react_shared_data;

        if (!isset($react_shared_data)) {
            $react_shared_data = [];
        }

        if (is_array($key)) {
            $react_shared_data = array_merge($react_shared_data, $key);
        } else {
            array_set($react_shared_data, $key, $value);
        }
    }

    public static function version(string $version = '')
    {
        self::$version = $version;
    }

    protected static function setPlaceholder(string $placeholder)
    {
        self::$placeholder = $placeholder;
    }

    protected static function setComponent(string $component)
    {
        self::$component = $component;
    }

    protected static function setProps(array $props)
    {
        global $react_shared_data;

        if (!isset($react_shared_data)) {
            $react_shared_data = [];
        }

        $props = array_merge($props, $react_shared_data);

        array_walk_recursive($props, function (&$prop) {
            if ($prop instanceof Closure) {
                $prop = $prop();
            }
        });

        self::$props = $props;
    }

    protected static function getMarkup()
    {
        $className = self::$className;
        $placeholder = self::$placeholder;

        $data = htmlspecialchars(
            json_encode([
                'props'     => self::$props,
                'version'   => self::$version,
                'component' => self::$component,
            ]),
            ENT_QUOTES,
            'UTF-8',
            true
        );

        return "<div class=\"{$className}\" data-react=\"{$data}\">{$placeholder}</div>";
    }
}
