<?php

if(!function_exists('nextend_init_ajax')){
    add_action('wp_ajax_nextend', 'nextend_init_ajax');
    function nextend_init_ajax() {
        nextendimport('nextend.ajax.ajax');
        exit;
    }
}

function nextend_smart_slider2(){
    nextendimportsmartslider2('nextend.smartslider.admin.controller');
    
    $controller = new NextendSmartsliderAdminController('com_smartslider2');
    $controller->initBase();
    $controller->run();
}


add_action( 'admin_head', 'nextend_smartslider2_icons' );
function nextend_smartslider2_icons() {
?>
    <style type="text/css" media="screen">
    #toplevel_page_nextend-smart-slider2 .wp-menu-image {
        background: url(<?php echo plugin_dir_url(__FILE__) ?>images/icon.png) no-repeat 1px -33px !important;
    }
    #toplevel_page_nextend-smart-slider2:hover .wp-menu-image, 
    #toplevel_page_nextend-smart-slider2.wp-has-current-submenu .wp-menu-image {
        background-position: 1px -1px !important;
    }
    </style>
    <?php
}