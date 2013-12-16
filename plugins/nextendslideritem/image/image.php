<?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemImage extends plgNextendSliderItemAbstract {

    var $_identifier = 'image';

    var $_title = 'Image';

    function getTemplate() {
        return '<div data-click="{onmouseclick}" data-enter="{onmouseenter}" data-leave="{onmouseleave}"><a href="{url}" target="{target}" style="display: block;background: none !important;" >
          <img src="{image}" onclick="{onclick};" style="display: block; max-width: 100%; {css};width:{width};height:{height};" alt="{alt}" title="{title}" />
        </a></div>';
    }

    function getValues() {
        return array(
            'image' => NextendSmartSliderSettings::get('placeholder'),
            'size' => 'auto|*|',
            'link' => '#|*|_self',
            'url' => '',
            'target' => '_self',
            'width' => 'auto',
            'height' => 'auto',
            'css' => '',
            'alt' => 'Image not available',
            'title' => '',
            'onclick' => '',
            'onmouseclick' => '',
            'onmouseenter' => '',
            'onmouseleave' => ''
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemImage');