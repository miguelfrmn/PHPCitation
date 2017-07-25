<?php
namespace PHPCitation;

class I18n {
    
    private static $strings = [
        'Available at' => 'Available at',
        'Date accessed' => 'Date accessed',
    ];

    public static function set($key, $value = null) {
        if (is_array($key)) {
            self::$strings = $key;
            return;
        }

        self::$strings[$key] = $value;
    }

    public static function get($key = null) {
        if (empty($key)) {
            return self::$strings;
        }

        if (empty(self::$strings[$key])) {
            return null;
        }

        return self::$strings[$key];

    }

}

