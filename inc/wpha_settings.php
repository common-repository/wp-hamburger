<?php	
	global $wpha_data, $wpha_pro, $wpha_url, $wpha_premium_link, $wpha_customization, $wpha_default_bullet_img, $wpha_skins_styles;

			
    $wpha_options = get_option('wpha_options', array());
	
	//pree($wpha_options);
	
	$wpha_configuration = get_option('wpha-configuration', array());
	$wpha_configuration = is_array($wpha_configuration)?$wpha_configuration:array();
	

	//$wpha_customization = get_option('wpha-customization', array());
	$wpha_customization = is_array($wpha_customization)?$wpha_customization:array();
	
    $wpha_menus = wp_get_nav_menus(); 
    $img_recomend_string = __('Note: Leave blank to use image bullet from media library.', 'wp-hamburger');
	
	$image_bullet_msg = __('Click here to use image bullet from media library.', 'wp-hamburger');
	//pree($wpha_menus);
	

	//pree($wpha_configuration['wpha-menu']);
	//pree($wpha_configuration);
	//pree($wpha_customization);
	
	$wpha_positions = array('default', 'absolute', 'fixed', 'relative');
?>



<div class="wrap wpha-wrapper">
<h2><?php echo $wpha_data['Name'].' '.($wpha_premium_link?'('.$wpha_data['Version'].($wpha_pro?') Pro':')'):'').' - '.__('Settings', 'wp-hamburger'); ?></h2>
<?php if(!$wpha_pro): ?>
            <a style="float:right; position:relative; top:-40px; display:none;" href="<?php echo esc_url($wpha_premium_link); ?>" target="_blank"><?php _e('Go Premium', 'wp-hamburger'); ?></a>
<?php endif; ?>

    <h2 class="nav-tab-wrapper">
        <a class="nav-tab nav-tab-active"><?php _e("Configuration",'wp-hamburger'); ?></a>
        <a class="nav-tab"><?php echo (!$wpha_pro && $wpha_premium_link)?__("Premium Features",'wp-hamburger'):__("Customization",'wp-hamburger'); ?></a>
        <a class="nav-tab float-right <?php echo $wpha_premium_link?'':'d-none'; ?>" target="_blank" href="https://wordpress.org/support/plugin/wp-hamburger/"><?php _e("Help",'wp-hamburger'); ?></a>

    </h2>

	<div class="nav-tab-content wpha_in_action settings_section mt-2">


        <!-- Main Section -->

        <div class="wpha_folders">

            <div class="row">

                <div class="col-12 text-dark">
                
                
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">     
<?php wp_nonce_field( 'wp_hamburger_action', 'wp_hamburger_field' ); ?>
<input type="hidden" name="wpha_tn" value="<?php echo isset($_GET['t'])?esc_attr($_GET['t']):'0'; ?>" />
<div class="form-group">
<label for="wpha-menu"><?php _e('Menus', 'wp-hamburger'); ?>:</label>
<?php if(!empty($wpha_menus)): ?>                
<select name="wpha-configuration[wpha-menu]" id="wpha-menu" class="form-control">
<option value=""><?php _e('Select', 'wp-hamburger'); ?></option>
<?php foreach($wpha_menus as $menus): ?>
    <option value="<?php echo $menus->slug; ?>" <?php echo selected(array_key_exists('wpha-menu', $wpha_configuration)?$wpha_configuration['wpha-menu']==$menus->slug:''); ?>><?php echo $menus->name; ?></option>
<?php endforeach; ?>    
</select>
<small class="form-text text-muted"><?php _e('This selection will make menu items appear in hamburger menu.', 'wp-hamburger'); ?></small>
<?php

		
	$menu_slug = array_key_exists('wpha-menu', $wpha_configuration)? $wpha_configuration['wpha-menu'] : '';
?>	

<div class="row mt-3">

    <div class="col-md-12 pr-4 wpha_config_men_container">
    
    <div class="menu_ul">

    <?php
    
    
	if($menu_slug){
	    wpha_config_menu($menu_slug);
	}
    
    ?>
    
    </div>
    
    <div class="spinner-border text-primary" role="status">
    <span class="sr-only"><?php _e('Loading...', 'wp-hamburger'); ?></span>
    </div>
    
    </div>
</div>



<button type="submit" class="btn btn-sm btn-secondary mt-4"><?php _e('Save Changes', 'wp-hamburger'); ?></button>
<?php endif; ?>

</div>           



</form>
                </div>


            </div>

        </div>

        <!--        Sidebar section-->
        <div class="wpha_log">
            <div class="row">

                <div class="col-12 text-center">
                    <?php _e('Optional Settings', 'wp-hamburger'); ?>
                </div>


            </div>



            <hr class="bg-warning"/>

            <div class="row nopadding wpha-options">
                <?php if(!$wpha_pro && $wpha_premium_link): ?>
                    <a class="btn btn-warning btn-sm mx-auto" href="<?php echo esc_url($wpha_premium_link); ?>" target="_blank" title="<?php echo __('Click here for Premium Version', 'wp-hamburger'); ?>"><?php echo __('Go Premium', 'wp-hamburger'); ?></a>
                <?php endif; ?>


                <div class="alert alert-secondary fade in alert-dismissible d-none mx-auto mt-4" style="width: 90%">
                    <button type="button" class="close" data-dismiss="alert" aria-label="<?php echo __('Close', 'wp-hamburger'); ?>">
                        <span aria-hidden="true" style="font-size:20px">×</span>
                    </button>    <strong><?php echo __('Success!', 'wp-hamburger'); ?></strong> <?php echo __('Options are updated successfully.', 'wp-hamburger'); ?>
                </div>

                <ul class="col col-md-12 mt-4">


<?php if(!$wpha_pro && $wpha_premium_link): ?>
                    <li class="premium-features"></li>
<?php endif; ?>

                    <li>
                        <label for="wpha_options_hide_desktop">
                            <input type="checkbox" name="wpha_options[hide_desktop]" value="hide_desktop" id="wpha_options_hide_desktop" <?php echo checked(array_key_exists('hide_desktop', $wpha_options)); ?> />
                            <?php echo __("Hide on Desktop", 'wp-hamburger'); ?> <i class="fa fa-desktop"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li>
                    
                    <li>
                        <label for="wpha_options_scroll_hide_desktop">
                            <input type="checkbox" name="wpha_options[scroll_hide_desktop]" value="scroll_hide_desktop" id="wpha_options_scroll_hide_desktop" <?php echo checked(array_key_exists('scroll_hide_desktop', $wpha_options)); ?> />
                            <?php echo __("Hide on scroll (Desktop)", 'wp-hamburger'); ?> <i class="fa fa-desktop"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li>

  					<li>
                        <label for="wpha_options_hide_mobile">
                            <input type="checkbox" name="wpha_options[hide_mobile]" value="hide_mobile" id="wpha_options_hide_mobile" <?php echo checked(array_key_exists('hide_mobile', $wpha_options)); ?> />
                            <?php echo __('Hide on Mobile', 'wp-hamburger'); ?> <i class="fa fa-mobile-alt"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li>
                    <li>
                        <label for="wpha_options_scroll_hide_mobile">
                            <input type="checkbox" name="wpha_options[scroll_hide_mobile]" value="scroll_hide_mobile" id="wpha_options_scroll_hide_mobile" <?php echo checked(array_key_exists('scroll_hide_mobile', $wpha_options)); ?> />
                            <?php echo __('Hide on scroll (Mobile)', 'wp-hamburger'); ?> <i class="fa fa-mobile-alt"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li>



                    
                     <li>
                        <label for="wpha_options_disable_fontawesome">
                            <input type="checkbox" name="wpha_options[disable_fontawesome]" value="disable_fontawesome" id="wpha_options_disable_fontawesome" <?php echo checked(array_key_exists('disable_fontawesome', $wpha_options)); ?> />
                            <?php echo __('Disable FontAwesome', 'wp-hamburger'); ?> <i class="fas fa-flag"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li>           
<?php
	$skins = array_keys($wpha_skins_styles);
?> 

                  	<li>
                        <label for="wpha_options_skins">
                            <?php echo __('Skins', 'wp-hamburger'); ?>: <select name="wpha_options[skins]" data-name="skins" id="wpha_options_skins">
                            	<?php foreach($skins as $skin): $label = ucwords($skin); ?>
                            	<option <?php echo selected(array_key_exists('skins', $wpha_options) && $wpha_options['skins']==$skin); ?> value="<?php echo $skin; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                             
                            <i class="fa fa-paint-brush"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li>  
                     
                     
                  	<li>
                        <label for="wpha_options_disable_hover">
                            <input type="checkbox" name="wpha_options[disable_hover]" value="disable_hover" id="wpha_options_disable_hover" <?php echo checked(array_key_exists('disable_hover', $wpha_options)); ?> />
                            <?php echo __('Disable Hover Effects', 'wp-hamburger'); ?> <i class="fa fa-bars"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li>  
                                       
                     <li class="admin-features"></li>
                    
                     <li>
                        <label for="wpha_options_disable_bootstrap">
                            <input type="checkbox" name="wpha_options[disable_bootstrap]" value="disable_bootstrap" id="wpha_options_disable_bootstrap" <?php echo checked(array_key_exists('disable_bootstrap', $wpha_options)); ?> />
                            <?php echo __('Disable Bootstrap', 'wp-hamburger'); ?> <i class="fab fa-bootstrap"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li>    
                    
 
                    <li class="developer-features"></li> 
                  	<li>
                        <label for="wpha_positions">
                            <?php echo __('Position', 'wp-hamburger'); ?>: <select name="wpha_options[position]" data-name="position" id="wpha_positions" class="w-25">
                            	<?php foreach($wpha_positions as $position): $label = ucwords($position); ?>
                            	<option <?php echo selected(array_key_exists('position', $wpha_options) && $wpha_options['position']==$position); ?> value="<?php echo $position; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                             
                            <i class="fab fa-fly"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li> 
                    
                  	<li>
                        <label for="wpha_dom">
                            <?php echo __('DOM Position', 'wp-hamburger'); ?>: <input name="wpha_options[dom]" data-name="dom" class="w-25" id="wpha_dom" value="<?php echo array_key_exists('dom', $wpha_options)?$wpha_options['dom']:''; ?>" type="text" />
                            	
                             
                            <i class="fa fa-crosshairs"></i>

                            <i class="fas fa-check"></i>

                        </label>

                    </li>                     
                                                                      

                        </ul>

                    </li>
  
                </ul>



             
<?php if(!$wpha_pro && $wpha_premium_link): ?>
                <ul class="col col-md-12 mt-4">
                    <li class="promotions"></li>
                    <li style="text-align:center;">
                        <a style="float: none" href="https://wordpress.org/plugins/gulri-slider" target="_blank" title="<?php echo __('Image Slider', 'wp-hamburger'); ?>"><img src="<?php echo $wpha_url; ?>img/gslider.gif" /></a>
                    </li>
                </ul>
<?php endif; ?>                     
            </div>
       

        </div>


    </div>

    <div class="nav-tab-content hide other_section mt-2">
    
        <div class="row">
        
            <div class="col-12 text-dark">
            
                
                <form id="wpha_customization_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                	<input type="hidden" name="wpha_tn" value="<?php echo isset($_GET['t'])?esc_attr($_GET['t']):'0'; ?>" />
					<?php wp_nonce_field( 'wp_hamburger_action', 'wp_hamburger_field' ); ?>
                    
                    <div class="form-group">
                    <label for="wpha-font-family"><?php _e('Font Family', 'wp-hamburger'); ?>:</label>

                    <input type="text" name="wpha-customization[font-family]" id="wpha-font-family" class="form-control w-25" value="<?php echo $wpha_customization['font-family']; ?>" />

                    <small class="form-text text-muted"><?php _e('Example: Arial', 'wp-hamburger'); ?> (<?php _e('Leave empty for default', 'wp-hamburger'); ?>)<br />
					<?php _e('Example: inherit', 'wp-hamburger'); ?> (<?php _e('Use as parent wrappers', 'wp-hamburger'); ?>)</small>		
                    </div>

                    <div class="wpha-humburger-demo">
                        <i class="fa fa-bars"></i>
                    </div>
                    
                    <hr />

					 <div class="form-group">
                    <strong><label for="wpha-background"><?php _e('Menu Background', 'wp-hamburger'); ?>:</label></strong>

<div class="btn-group" role="group">
					
					<i class="fas fa-palette" style="font-size:20px; color:#B95206; margin:6px;"></i>
                    <input title="<?php _e('Full Screen Menu Background Color', 'wp-hamburger'); ?>" type="color" name="wpha-customization[background]" id="wpha-background" class="form-control" value="<?php echo $wpha_customization['background']; ?>" /> 
                    
                    

                    <i class="fas fa-adjust" style="font-size:20px; color:#666; margin:6px;"></i>
                    <input title="<?php _e('Opacity: from 0.1 to 0.9', 'wp-hamburger'); ?>" type="text" name="wpha-customization[background_opacity]" id="wpha-menu-bg-opacity" class="form-control w-25" value="<?php echo (array_key_exists('background_opacity', $wpha_customization)?$wpha_customization['background_opacity']:''); ?>" />
</div>
<a class="wpha_option_reset"><i title="<?php _e('Reset', 'wp-hamburger'); ?>" class="fa fa-redo"></i></a>

					<small class="form-text text-muted"><?php _e('Background color for hamburger menu and full screen on click.', 'wp-hamburger'); ?></small>

                    </div>  
                                        
                      
                    
                 
                    
                    <div class="form-group">
                    <strong><label for="wpha-foreground"><?php _e('Hamburger Icon', 'wp-hamburger'); ?>:</label></strong>
<div class="btn-group" role="group">
					<i class="fa fa-bars" style="font-size:20px; color:#999; margin:6px;"></i>
                    <input title="<?php _e('Hamburger Icon Background Color', 'wp-hamburger'); ?>" type="color" name="wpha-customization[ham_background]" class="form-control" value="<?php echo $wpha_customization['ham_background']; ?>" /> 

					<i class="fas fa-palette" style="font-size:20px; color:#B95206; margin:6px;"></i>
                    <input title="<?php _e('Hamburger Icon Color', 'wp-hamburger'); ?>" type="color" name="wpha-customization[foreground]" id="wpha-foreground" class="form-control" value="<?php echo $wpha_customization['foreground']; ?>" />
</div>                    
                    <a class="wpha_option_reset"><i title="<?php _e('Reset', 'wp-hamburger'); ?>" class="fa fa-redo"></i></a>

                    <small class="form-text text-muted"><?php _e('Foreground color for hamburger icon.', 'wp-hamburger'); ?></small>
                    </div>


                    <div class="wpha-menu-item-demo">
                        <ul>
                            <li>
                                Menu 1
                                <ul>
                                    <li>Sub Menu 1</li>
                                    <li>Sub Menu 2</li>
                                    <li>Sub Menu 3</li>
                                </ul>

                            </li>
                            <li>Menu 2</li>
                            <li>Menu 3</li>
                            <li>Menu 4</li>
                            <li>Menu 5</li>
                        </ul>
                    </div>
                    <hr />                            
                    
                    <div class="form-group">
                    <strong><label for="wpha-menu-color"><?php _e('First Level Menu Items', 'wp-hamburger'); ?>:</label></strong>

<div class="btn-group" role="group">
					
					<i class="fas fa-palette" style="font-size:20px; color:#B95206; margin:6px;"></i>
                    <input title="<?php _e('Color', 'wp-hamburger'); ?>" type="color" name="wpha-customization[menu-color]" id="wpha-menu-color" class="form-control" value="<?php echo $wpha_customization['menu-color']; ?>" />
                    
                    

                    <i class="fas fa-text-height" style="font-size:20px; color:#C00; margin:6px;"></i>
                    <input title="<?php _e('Font Size: 12px', 'wp-hamburger'); ?>" type="text" name="wpha-customization[menu-font-size]" id="wpha-menu-font-size" class="form-control w-25" value="<?php echo $wpha_customization['menu-font-size']; ?>" />
</div>
<a class="wpha_option_reset"><i title="<?php _e('Reset', 'wp-hamburger'); ?>" class="fa fa-redo"></i></a>
                    </div>   
                    

                    
                    
 					<div class="form-group">
                    <label for="wpha-menu-bullet" class="d-block"><?php _e('Menu Items Bullet (First Level)', 'wp-hamburger'); ?>:</label>

                    <input type="text" name="wpha-customization[menu-bullet-closed]" id="wpha-menu-bullet-closed" class=" w-25" value="<?php echo $wpha_customization['menu-bullet-closed']; ?>" />
                    <img title="<?php echo $image_bullet_msg; ?>" class="wpha_img_bullet" src="<?php echo $wpha_customization['menu-bullet-closed-img']?$wpha_customization['menu-bullet-closed-img']:$wpha_default_bullet_img; ?>" /><input type="hidden" name="wpha-customization[menu-bullet-closed-img]" value="<?php echo $wpha_customization['menu-bullet-closed-img']; ?>" /> <a class="wpha_option_reset"><i title="<?php _e('Reset', 'wp-hamburger'); ?>" class="fa fa-redo"></i></a> <b>(<?php _e('Recommended:', 'wp-hamburger'); ?> 32px X 32px)</b>
                    
                    
                    <small class="form-text text-muted"><?php _e('Example:', 'wp-hamburger'); ?> disclosure-closed outside<br />
<i style="float: left; font-size:20px !important; position:relative; left: -8px; top:0;" class="fa fa-caret-right"></i><?php _e('FontAwesome:', 'wp-hamburger'); ?> <a target="_blank" href="https://fontawesome.com/v5.14.0/icons?d=gallery&m=free&q=caret">fa-caret-right</a></small><ul class="bullet-example"><li style="list-style:disclosure-closed outside; margin:0; padding:0;">&nbsp;</li></ul>
                    
                    <small class="text-muted wpha_img_recomend_string">
                        <?php echo $img_recomend_string ?> 
                    </small>

                    <br>
                    

                    <input type="text" name="wpha-customization[menu-bullet-opened]" id="wpha-menu-bullet-opened" class=" w-25 mt-2" value="<?php echo $wpha_customization['menu-bullet-opened']; ?>" />
                    <img title="<?php echo $image_bullet_msg; ?>" class="wpha_img_bullet" src="<?php echo $wpha_customization['menu-bullet-opened-img']?$wpha_customization['menu-bullet-opened-img']:$wpha_default_bullet_img; ?>" /><input type="hidden" name="wpha-customization[menu-bullet-opened-img]" value="<?php echo $wpha_customization['menu-bullet-opened-img']; ?>" /> <a class="wpha_option_reset"><i title="<?php _e('Reset', 'wp-hamburger'); ?>" class="fa fa-redo"></i></a> <b>(<?php _e('Recommended:', 'wp-hamburger'); ?> 32px X 32px)</b>
                    

                    <small class="form-text text-muted"><?php _e('Example:', 'wp-hamburger'); ?> disclosure-open outside<br />
                        <i style="float: left; font-size:20px !important; position:relative; left: -14px; top:0;" class="fa fa-caret-down"></i><?php _e('FontAwesome:', 'wp-hamburger'); ?> <a target="_blank" href="https://fontawesome.com/v5.14.0/icons?d=gallery&m=free&q=caret">fa-caret-down</a>

                        </small><ul class="bullet-example" style="left:5px;"><li style="list-style:disclosure-open outside; margin:0; padding:0;">&nbsp;</li></ul>
                    
                    <small class="text-muted wpha_img_recomend_string">
                    <?php echo $img_recomend_string; ?> 

                    </small>
                    </div>   
                    
                    <hr />
 
 
                     <div class="form-group">
                    <strong><label for="wpha-sub-menu-color"><?php _e('Second Level Menu Items', 'wp-hamburger'); ?>:</label></strong>

<div class="btn-group" role="group">
					
					<i class="fas fa-palette" style="font-size:20px; color:#B95206; margin:6px;"></i>
                    <input title="<?php _e('Color', 'wp-hamburger'); ?>" type="color" name="wpha-customization[sub-menu-color]" id="wpha-sub-menu-color" class="form-control" value="<?php echo $wpha_customization['sub-menu-color']; ?>" />
                    
                    

                    <i class="fas fa-text-height" style="font-size:20px; color:#C00; margin:6px;"></i>
                    <input title="<?php _e('Font Size: 12px', 'wp-hamburger'); ?>" type="text" name="wpha-customization[sub-menu-font-size]" id="wpha-sub-menu-font-size" class="form-control w-25" value="<?php echo $wpha_customization['sub-menu-font-size']; ?>" />
</div>
<a class="wpha_option_reset"><i title="<?php _e('Reset', 'wp-hamburger'); ?>" class="fa fa-redo"></i></a>

                    </div>   
                                                          
                                           
                    
               
    				<div class="form-group">
                    <label for="wpha-sub-menu-bullet" class="d-block"><?php _e('Menu Items Bullet (Second Level)', 'wp-hamburger'); ?>:</label>

                    <input type="text" name="wpha-customization[sub-menu-bullet-closed]" id="wpha-sub-menu-bullet-closed" class="w-25" value="<?php echo $wpha_customization['sub-menu-bullet-closed']; ?>" />
                    <img title="<?php echo $image_bullet_msg; ?>" class="wpha_img_bullet" src="<?php echo $wpha_customization['sub-menu-bullet-closed-img']?$wpha_customization['sub-menu-bullet-closed-img']:$wpha_default_bullet_img; ?>" /><input type="hidden" name="wpha-customization[sub-menu-bullet-closed-img]" value="<?php echo $wpha_customization['sub-menu-bullet-closed-img']; ?>" /> <a class="wpha_option_reset"><i title="<?php _e('Reset', 'wp-hamburger'); ?>" class="fa fa-redo"></i></a> <b>(<?php _e('Recommended:', 'wp-hamburger'); ?> 32px X 32px)</b>
                    

                    <small class="form-text text-muted"><?php _e('Example:', 'wp-hamburger'); ?> square outside<br />
                    <i style="float: left; font-size:10px !important; position:relative; left: -14px; top:6px;" class="fa fa-square"></i><?php _e('FontAwesome:', 'wp-hamburger'); ?> <a target="_blank" href="https://fontawesome.com/v5.14.0/icons?d=gallery&m=free&q=square">fa-square</a></small><ul class="bullet-example"><li style="list-style:square outside; margin:0; padding:0;">&nbsp;</li></ul>
                
                    <small class="text-muted wpha_img_recomend_string">
                        <?php echo $img_recomend_string; ?> 
                    </small>
                </div>  
                    
                    <hr />
                    
                    <div class="form-group">
                    <label for="wpha-css"><?php _e('Custom CSS Styles', 'wp-hamburger'); ?>:</label>

                    <textarea name="wpha-customization[css]" id="wpha-css" class="form-control w-50"><?php echo $wpha_customization['css']; ?></textarea>

                    <small class="form-text text-muted"><?php _e('This css styles section will overwrite default rules.', 'wp-hamburger'); ?> (<?php _e('Leave empty for no effects', 'wp-hamburger'); ?>)</small>
                    </div>  
                    
                                                      
                                        
                    <button type="submit" class="btn btn-secondary w-25"><?php _e('Save Changes', 'wp-hamburger'); ?></button>
                </form>
            </div>
        
        
        </div>



    </div>



    

    <div class="modal wpha_load_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ajax_load_modalLabel" >
        <div class="modal-dialog" role="document" style="max-width: 50px;">
            <div class="modal-content" style="margin-top: 45vh; width: max-content">

                <img src="<?php echo $wpha_url; ?>img/loader.gif" style="width: 50px; height: 50px"/>

            </div>
        </div>
    </div>

</div>


<script type="text/javascript" language="javascript">

    jQuery(document).ready(function($){


<?php if(isset($_GET['t']) || isset($_POST['wpha_tn'])):


			$wpha_tn = isset($_POST['wpha_tn']) ? esc_attr($_POST['wpha_tn']) : esc_attr($_GET['t']);

?>
			$('.nav-tab-wrapper .nav-tab:nth-child(<?php echo $wpha_tn+1; ?>)').click();

<?php endif; ?>

    });

</script>
<style type="text/css">
hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}
.php-error #adminmenuback, .php-error #adminmenuwrap {
    margin-top: 0;
}
</style>