<?php

class NextendSmartsliderAdminViewSliders_slides extends NextendView {

    function editAction($tpl) {
        NextendSmartSliderFontSettings::initAdminFonts();
        $this->render($tpl);
    }

}

?>
