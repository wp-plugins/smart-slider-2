<?php

class NextendSmartsliderAdminControllerSettings extends NextendSmartsliderAdminController {

    function NextendSmartsliderAdminControllerSettings($key) {
        parent::NextendSmartsliderAdminController($key);

    }

    function defaultAction($form = 'default') {
        if ($this->canDo('core.admin')) {
            $settingsModel = $this->getModel('settings');
            if (NextendRequest::getInt('save')) {
                if ($settingsModel->save()) {
                    header('LOCATION: ' . $this->route('controller=settings'));
                    exit;
                }
            }
            $this->display($form, 'default');
        }else{
            $this->noaccess();
        }
    }

    function layoutAction() {
        $this->defaultAction('layout');
    }

    function fontAction() {
        $this->defaultAction('font');
    }

    function joomlaAction() {
        if(nextendIsJoomla()) $this->defaultAction('joomla');
    }

}
