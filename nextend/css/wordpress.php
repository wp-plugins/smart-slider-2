<?php

class NextendCssWordPress extends NextendCss {

    function serveCSSFile($url) {
        /*if(substr($url, 0, 4) != 'http'){
            $url = site_url($url);
        }*/
        if ($this->_echo) {
            parent::serveCSSFile($url);
        } else {
            parent::serveCSSFile($url);
        }
    }

    function serveCSS($clear = true) {
        if ($this->_css != '') {
            parent::serveCSS($clear);
        }
    }

}