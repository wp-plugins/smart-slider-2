<?php

class NextendSmartsliderAdminViewSliders_generator extends NextendView{

    function editAction($tpl) {
        NextendSmartSliderFontSettings::initAdminFonts();
        $this->render($tpl);
    }
}
?>
