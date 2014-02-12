<?php
if(NEXTEND_SMART_SLIDER2_BASE == 'nextend-smart-slider2-full'){

    add_action('admin_menu', 'nextend_smart_slider2_update_page');
    
    function nextend_smart_slider2_update_page() {
    	add_submenu_page('nextend-smart-slider2', 'Nextend Smart Slider 2 License', 'License', 'manage_options', __FILE__, 'nextend_smart_slider2_settings_page');
    }
    
    function nextend_smart_slider2_settings_page() {
    ?>
    <div>
    <h2>Nextend Smart Slider 2</h2>
    <?php
      if(isset($_POST['nextend_smart_slider2_license'])){
          $_POST['nextend_smart_slider2_license'] = trim($_POST['nextend_smart_slider2_license']);
          if(base64_encode(base64_decode($_POST['nextend_smart_slider2_license'])) === $_POST['nextend_smart_slider2_license']){
              update_option('nextend_smart_slider2_license', $_POST['nextend_smart_slider2_license']);
          }else{
             echo '<div class="error"><strong><p>The validity of license key failed</p></strong></div>';
          }
      }
    ?>
    
    <form method="post" action="<?php echo admin_url("admin.php?page=nextend-smart-slider2-full/update.php"); ?>">
    <p>If you fill out the license key field, you will be able to use the the WordPress plugin updater with Nextend Smart Slider 2.</p>
    <p>You can get your license key in the <a target="_blank" href="http://www.nextendweb.com/availabledownloads/">Download area</a> at Nextendweb.com</p>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">License key</th>
            <td><input type="text" style="width: 400px;" name="nextend_smart_slider2_license" value="<?php echo get_option('nextend_smart_slider2_license', ''); ?>" /></td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    
    </form>
    </div>
    <?php 
    } 
}else{
    add_action('admin_menu', 'nextend_smart_slider2_update_page');
    
    function nextend_smart_slider2_update_page() {
    	add_submenu_page('nextend-smart-slider2', 'Nextend Smart Slider 2 License', 'Get Full', 'manage_options', __FILE__, 'nextend_smart_slider2_settings_page');
    }
    
    function nextend_smart_slider2_settings_page() {
        wp_redirect( admin_url('admin.php?page=nextend-smart-slider2&controller=sliders&view=sliders_full&action=full'), 301 );
        exit;
    }
}
