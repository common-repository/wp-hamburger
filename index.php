<?php defined( 'ABSPATH' ) or die( 'No fankari bachay!' );
/*
Plugin Name: WP Hamburger
Plugin URI: http://androidbubble.com/blog/wordpress/plugins/wp-hamburger
Description: WP Hamburger is a WordPress plugin with extensive customization possibility.
Author: Fahad Mahmood
Version: 1.6.5
Text Domain: wp-hamburger
Domain Path: /languages
Author URI: https://profiles.wordpress.org/fahadmahmood/
License: GPL2
	
This WordPress Plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version. This free software is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this software. If not, see http://www.gnu.org/licenses/gpl-2.0.html.	
*/


	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	
	global $wpha_data, $wpha_pro, $wpha_premium_link, $wpha_dir, $wpha_levels, $wpha_url, $wpha_options, $wpha_settings_url, $wpha_customization, $wpha_default_bullet_img, $wpha_img_preloader, $wpha_skins_styles;

	$wpha_skins_styles['default']['styles']['font-family'] = '';
	$wpha_skins_styles['default']['styles']['background'] = '#228b9d';
	$wpha_skins_styles['default']['styles']['background_opacity'] = '1';
	$wpha_skins_styles['default']['styles']['ham_background'] = $wpha_skins_styles['default']['styles']['background'];
	$wpha_skins_styles['default']['styles']['foreground'] = '#ffffff';
	$wpha_skins_styles['default']['styles']['menu-color'] = '#ffffff';
	$wpha_skins_styles['default']['styles']['menu-font-size'] = '18px';
	$wpha_skins_styles['default']['styles']['menu-bullet-closed'] = 'none';
	$wpha_skins_styles['default']['styles']['menu-bullet-closed-img'] = '';
	$wpha_skins_styles['default']['styles']['menu-bullet-opened'] = 'none';
	$wpha_skins_styles['default']['styles']['menu-bullet-opened-img'] = '';
	$wpha_skins_styles['default']['styles']['sub-menu-color'] = $wpha_skins_styles['default']['styles']['menu-color'];
	$wpha_skins_styles['default']['styles']['sub-menu-font-size'] = '16px';
	$wpha_skins_styles['default']['styles']['sub-menu-bullet-closed'] = 'none';
	$wpha_skins_styles['default']['styles']['sub-menu-bullet-closed-img'] = '';			
	$wpha_skins_styles['default']['styles']['css'] = '';
	$wpha_skins_styles['default']['options']['position'] = 'fixed';
	
	$wpha_skins_styles['elektro']['styles']['font-family'] = '';
	$wpha_skins_styles['elektro']['styles']['background'] = '#F9E709';
	$wpha_skins_styles['elektro']['styles']['background_opacity'] = '1';
	$wpha_skins_styles['elektro']['styles']['ham_background'] = '#000000';
	$wpha_skins_styles['elektro']['styles']['foreground'] = '#ffffff';
	$wpha_skins_styles['elektro']['styles']['menu-color'] = '#000000';
	$wpha_skins_styles['elektro']['styles']['menu-font-size'] = '28px';
	$wpha_skins_styles['elektro']['styles']['menu-bullet-closed'] = 'none';
	$wpha_skins_styles['elektro']['styles']['menu-bullet-closed-img'] = '';
	$wpha_skins_styles['elektro']['styles']['menu-bullet-opened'] = 'none';
	$wpha_skins_styles['elektro']['styles']['menu-bullet-opened-img'] = '';
	$wpha_skins_styles['elektro']['styles']['sub-menu-color'] = $wpha_skins_styles['elektro']['styles']['menu-color'];
	$wpha_skins_styles['elektro']['styles']['sub-menu-font-size'] = '26px';
	$wpha_skins_styles['elektro']['styles']['sub-menu-bullet-closed'] = 'none';
	$wpha_skins_styles['elektro']['styles']['sub-menu-bullet-closed-img'] = '';
	$wpha_skins_styles['elektro']['styles']['css'] = '';
	$wpha_skins_styles['elektro']['options']['position'] = 'fixed';
		
	$wpha_img_preloader = array();
	$wpha_data = get_plugin_data(__FILE__);
	$wpha_dir = plugin_dir_path( __FILE__ );
    $wpha_url = plugin_dir_url( __FILE__ );
	$wpha_settings_url = admin_url('admin.php?page=wp-hamburger');
    $wpha_options = get_option('wpha_options', array());

	$wpha_default_bullet_img = $wpha_url .'img/butterfly.png';
    $wpha_premium_link = 'https://shop.androidbubbles.com/product/wp-hamburger';//https://shop.androidbubble.com/products/wordpress-plugin?variant=36439508418715';//

	$wpha_pro_file = $wpha_dir.'pro/wp-hamburger-pro.php';

    $wpha_pro = file_exists($wpha_pro_file);
    if($wpha_pro){
        include($wpha_pro_file);
	}	

	
	include_once('inc/functions.php');


	$wpha_customization = wpha_get_customaization();

	
	

	include_once('inc/walker-class.php');
	include_once('inc/functions-inner.php');
	

	if(is_admin()){
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'wpha_plugin_links' );
	}
	