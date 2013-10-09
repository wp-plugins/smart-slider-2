<?php
nextendimport('nextend.form.element.list');

class NextendElementFontMatrixChooser extends NextendElementList {
    
    function fetchElement() {
    
        nextendimportsmartslider2('nextend.smartslider.settings');
        NextendSmartSliderFontSettings::initAdminFonts();
        
        $this->_xml->addChild('option', 'None')->addAttribute('value', '');
        
        foreach($GLOBALS['nextendfontmatrix'] as $k => $v) {
            $this->_xml->addChild('option', $v)->addAttribute('value', $k);
        }
        return parent::fetchElement();
    }
}

