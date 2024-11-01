<?php
class Wpha_Custom_Nav_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	
			// pree($depth);
	
			global $wpha_customization, $wpha_img_preloader;
			
			$wpha_options = get_option('wpha_options', array());
	
			$current_item_settings = array_key_exists('disable_hover', $wpha_options)?array():wpha_get_config_settings_by_item($item->ID);
			pre($wpha_customization);
	
			$wpha_main_close = $wpha_customization['menu-bullet-closed'];
			$wpha_main_open = $wpha_customization['menu-bullet-opened'];
			$wpha_sub_menu = $wpha_customization['sub-menu-bullet-closed'];
			
			$wpha_main_close_img = $wpha_customization['menu-bullet-closed-img'];
			$wpha_main_open_img = $wpha_customization['menu-bullet-opened-img'];
			$wpha_sub_menu_img = $wpha_customization['sub-menu-bullet-closed-img'];
			
			$closed_img = wpha_is_image($wpha_main_close) && $wpha_main_close_img? "<img src='$wpha_main_close_img' class='close' />" : '';
			$opened_img = wpha_is_image($wpha_main_open) && $wpha_main_open_img?  "<img src='$wpha_main_open_img' class='open' style='display:none;' />" : '';
			$sub_list_img = wpha_is_image($wpha_sub_menu) && $wpha_sub_menu_img?  "<img src='$wpha_sub_menu_img' class='' />" : '';
			
			$closed_fa = wpha_is_fa($wpha_main_close) && $wpha_main_close? "<i class='fa close $wpha_main_close'></i>" : '';
			$opened_fa = wpha_is_fa($wpha_main_open) && $wpha_main_open?  "<i class='fa open $wpha_main_open' style='display:none;'></i>" : '';
			$sub_list_fa = wpha_is_fa($wpha_sub_menu) && $wpha_sub_menu?  "<i class='fa $wpha_sub_menu'></i>" : '';
			
	
			$classes = $item->classes;
	
			$id = "menu-item-".$item->ID;
			$url = $item->url;
			$classes[] = $id;
			$classes_str = implode(' ', $classes);
	
			$fa_icon = $depth == 0 ? $closed_fa.$opened_fa : $sub_list_fa;
			$img_bullet = $depth == 0 ? $closed_img.$opened_img : $sub_list_img;
			
			$attribs = array();
			
			//pree($current_item_settings);
			if(!empty($current_item_settings) && array_key_exists('background', $current_item_settings)){
				if($current_item_settings['background']!=''){
					//unset($current_item_settings['background']);
					foreach($current_item_settings as $attrib=>$value){					
						$attribs[] = 'data-'.$attrib.'="'.$value.'"';
						
						if(array_key_exists('background_img', $current_item_settings) && $current_item_settings['background_img']!=''){
							$wpha_img_preloader[] = '<img class="wp_hamburger_preloaded_images" src="'.$current_item_settings['background_img'].'" style="display:none !important" />';
						}
					}
				}
			}
	
			$output .= '<li id="'.$id.'" class="'.$classes_str.'" '.implode(' ', $attribs).'><a href="'.$url.'">'.$fa_icon.'  '.$img_bullet.' '.$item->title.'</a>';
	  
	   }
	
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		
		$output .= "</li> \n";
	
	
	   }
}
class Wpha_config_Nav_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		//pree($args);
		global $wpha_url, $wpha_customization;
		
		$current_item_settings = wpha_get_config_settings_by_item($item->ID);
		
		//pree($current_item_settings);
		
		
		$classes = $item->classes;
		
		$id = "menu-item-".$item->ID;
		$classes[] = $id;
		$classes_str = implode(' ', $classes);
		
		
		
		$output .= "<li id='$id' class='$classes_str' data-id='$item->ID'> <span class='title'>$item->title</span>";
		
		ob_start();
		
		$use_clr_string = __('Use Background Color', 'wp-hamburger');
		$use_img_string = __('Use Background Image', 'wp-hamburger');
		$bg_img_string = __('Set Background Image', 'wp-hamburger');
		$bg_clr_string = __('Set Background Color', 'wp-hamburger');
		$fg_clr_string = __('Set Text Color', 'wp-hamburger');
		$reset_string = __('Reset', 'wp-hamburger');
		
		
		if(is_admin()){
		?>
		
		
		<span class="input_wrapper ml-3" style="display:">
		
		<input type="radio" value="color" name="wpha-configuration[hover_settings][<?php echo $item->ID; ?>][background]" title="<?php echo $use_clr_string; ?>" <?php checked($current_item_settings['background'] == 'color'); ?>>
		<input type="color" name="wpha-configuration[hover_settings][<?php echo $item->ID; ?>][background_color]" id="" title="<?php echo $bg_clr_string; ?>" value="<?php echo $current_item_settings['background_color'] ; ?>">
		
		<input type="radio" value="image" name="wpha-configuration[hover_settings][<?php echo $item->ID; ?>][background]" id="" title="<?php echo $use_img_string; ?>" <?php checked($current_item_settings['background'] == 'image'); ?>>
		
        <?php if($current_item_settings['background_img']): ?>
        <img src="<?php echo $current_item_settings['background_img'] ; ?>" class="wpha_background_img_selection" title="<?php echo $bg_img_string; ?>" />
        <?php else: ?>
        <span class="wpha_background_img_selection"><i class="fas fa-image" title="<?php echo $bg_img_string; ?>"></i></span>
        <?php endif; ?>
        
		<input type="hidden" name="wpha-configuration[hover_settings][<?php echo $item->ID; ?>][background_img]" value="<?php echo $current_item_settings['background_img'] ; ?>">
		
		<i class="fas fa-font"></i><input type="color" name="wpha-configuration[hover_settings][<?php echo $item->ID; ?>][foreground_color]" id="" title="<?php echo $fg_clr_string; ?>" value="<?php echo $current_item_settings['foreground_color'] ; ?>">
		
		<i class="fa fa-redo ml-3 wpha_reset_single_hover" title="<?php echo $reset_string ?>"></i>
		</span>
		
		
		<?php
		
		}
		
		$content = ob_get_clean();
		
		
		$output .= $content;
	
	}
	
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
	
		$output .= "</li> \n";
	
	
	}
}