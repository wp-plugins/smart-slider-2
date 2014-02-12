<?php

class NextendSliderCache {
    
    var $slider = null;
    
    function NextendSliderCache($slider){
    
        nextendimport('nextend.css.css');
        nextendimport('nextend.javascript.javascript');
        nextendimport('nextend.fonts.google');
        
        $this->slider = $slider;
        
        $sliderid = $slider->_sliderid;
        
        $recache = false;
        $cached = json_decode(NextendSmartSliderStorage::get('slidercache'.$sliderid), true);
        
        if(is_array($cached)){
            if(NextendSmartSliderStorage::get('sliderchanged'.$sliderid) == 1){
                $recache = true;
            }else if(isset($cached['time']) && isset($cached['expire']) && $cached['time'] < time()-$cached['expire']*60*60){
                $recache = true; 
            }
        }else{
            $recache = true; 
        }
        //$recache = true;
        if($recache){
            $data = $this->render();
            $cached = array(
                'time' => time(),
                'data' => $data
            );
            if($this->slider->_generatorParams->get('enabled', 0)){          
                $generatorcached = json_decode(NextendSmartSliderStorage::get('generator'.$sliderid), true);
                if(is_array($generatorcached)){
                    $cached['time'] = $generatorcached['time'];
                    $cached['expire'] = $this->slider->_generatorParams->get('cachetime', '24');
                }
            }
            
            NextendSmartSliderStorage::set('slidercache'.$sliderid, json_encode($cached));
            NextendSmartSliderStorage::set('sliderchanged'.$sliderid, '0');
        }else{
            $data = $cached['data'];
        }
        
        
        $this->cssurl = $data['css'];
        if(nextendIsWordPress()){
            add_action('nextend_css', array( $this, 'addCSS'));
        }elseif(nextendIsMagento()){
            Nextend_SmartSlider2_Model_Observer::$sliders[] = array($this, 'addCSS');
        }else{
            $this->addCSS();
        }
        
        $js = NextendJavascript::getInstance();
        foreach($data['js']['core'] AS $j){
            $js->addJsFile($j);
        }
        if(isset($data['libraries']) && count($data['libraries'])){
            foreach($data['libraries'] AS $library => $jss){
                $js->loadLibrary($library);
                if(!empty($jss['js'])) $js->addLibraryJs($library, $jss['js']);
                if(count($jss['jsfiles'])){
                    foreach($jss['jsfiles'] AS $j){
                        $js->addLibraryJsFile($library, $j);
                    }
                }
            }
        }
        
        if(isset($data['fonts']) && count($data['fonts'])){
            $google = NextendFontsGoogle::getInstance();
            foreach($data['fonts'] AS $k => $v){
                $style = explode(',', $v[0]);
                $subset = explode(',', $v[1]);
                for($i = 0; $i < count($style); $i++){
                    $google->addFont($k, $style[$i], $subset[$i]);
                }
            }
        }
        
        echo $data['html'];
    }
    
    function render(){
        $data = array(
            'css' => '',
            'js' => array(),
            'fonts' => array(),
            'html' => '' 
        );
        
        $this->css = $css = NextendCss::getInstance();
        $tmpCSScacheTime = $css->_cache->_cacheTime;
        $css->_cache->_cacheTime = 'static';
        $cssFiles = $css->_cssFiles;
        
        $js = NextendJavascript::getInstance();
        $jsFiles = array();
        $jsFiles['core'] = $js->_jsFiles;
        $jsFiles['libraries'] = array();
        foreach($js->_loadedLibraries AS $k => $v){
            $jsFiles['libraries'][$k] = array();
            $jsFiles['libraries'][$k]['jsfiles'] = $v->_jsFiles;
            $jsFiles['libraries'][$k]['js'] = $v->_js;
        }
        
        $google = NextendFontsGoogle::getInstance();
        $fonts = $google->_fonts;
        
        ob_start();
        $this->slider->render(true);
        $this->id = $this->slider->getId();
        $data['html'] = preg_replace_callback('/<style.*?>(.*?)<\/style>/s',array($this, 'inlineCSS'),ob_get_clean());
        $data['fonts'] = array_diff($google->_fonts, $fonts);
        
        
        $extracssfiles = array_diff($css->_cssFiles, $cssFiles);
        $css->_cssFiles = $cssFiles;
        
        foreach($extracssfiles AS $f){
            $css->addCssFile($f, $this->id);
        }        
        
        $css->_cacheGroup[$this->id]->_cacheTime = 'static';
        
        $data['css'] = $css->generateCSS($this->id, false);
        
        $css->_cache->_cacheTime = $tmpCSScacheTime;
        
        $data['js']['core'] = array_diff($js->_jsFiles, $jsFiles['core']);
        foreach($js->_loadedLibraries AS $k => $v){
            if(isset($jsFiles['libraries'][$k])){
                $data['libraries'][$k]['jsfiles'] = array_diff($v->_jsFiles, $jsFiles['libraries'][$k]['jsfiles']);
                $data['libraries'][$k]['js'] = str_replace($data['libraries'][$k]['js'], '', $v->_js);
            }else{
                $data['libraries'][$k]['jsfiles'] = $v->_jsFiles;
                $data['libraries'][$k]['js'] = $v->_js;
            }
        }
        
        return $data;
    }
    
    function addCSS(){
        $css = NextendCss::getInstance();
        $css->serveCSSFile($this->cssurl);
    }
    
    function inlineCSS($matches){
        $this->css->addCssFile($matches[1], $this->id);
        return '';
    }
}