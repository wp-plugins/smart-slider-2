<?php

nextendimportsmartslider2('nextend.smartslider.storage');

class NextendSmartSliderSettings {

    static $settings = null;

    static function getAll() {
        if (self::$settings === null) {
            self::$settings = json_decode(NextendSmartSliderStorage::get('settings'), true);
            if (self::$settings === null)
                self::$settings = array();
        }
        return self::$settings;
    }

    static function get($key, $default = null) {
        if (self::$settings === null)
            self::getAll();
        if (!array_key_exists($key, self::$settings))
            return $default;
        return self::$settings[$key];
    }

}

class NextendSmartSliderLayoutSettings {

    static $settings = null;

    static function getAll() {
        if (self::$settings === null) {
            self::$settings = json_decode(NextendSmartSliderStorage::get('layout'), true);
            if (self::$settings === null)
                self::$settings = array();
        }
        return self::$settings;
    }

    static function get($key, $default = null) {
        if (self::$settings === null)
            self::getAll();
        if (!array_key_exists($key, self::$settings))
            return $default;
        return self::$settings[$key];
    }

}

class NextendSmartSliderFontSettings {

    static $settings = null;

    static function getAll() {
        if (self::$settings === null) {
            self::$settings = json_decode(NextendSmartSliderStorage::get('font'), true);
            if (self::$settings === null)
                self::$settings = array();
        }
        return self::$settings;
    }

    static function get($key, $default = null) {
        if (self::$settings === null)
            self::getAll();
        if (!array_key_exists($key, self::$settings))
            return $default;
        return self::$settings[$key];
    }
    
    static function initAdminFonts(){
        $data = self::getAll();
        $GLOBALS['nextendfontmatrix'] = array();
        if (is_array($data)) {
            foreach ($data AS $k => $v) {
                preg_match('/sliderfont(custom)?([0-9]*)$/', $k, $matches);
                if (count($matches)) {
                    $GLOBALS['nextendfontmatrix'][$matches[0]] = $data[$matches[0].'customlabel'];
                }
            }
        }
    }

}

class NextendSmartSliderJoomlaSettings {

    static $settings = null;

    static function getAll() {
        if (self::$settings === null) {
            self::$settings = json_decode(NextendSmartSliderStorage::get('joomla'), true);
            if (self::$settings === null)
                self::$settings = array();
        }
        return self::$settings;
    }

    static function get($key, $default = null) {
        if (self::$settings === null)
            self::getAll();
        if (!array_key_exists($key, self::$settings))
            return $default;
        return self::$settings[$key];
    }

}