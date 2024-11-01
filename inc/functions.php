<?php
	if(!function_exists('wpha_get_customaization')){
		function wpha_get_customaization(){
			
			global $wpha_url, $wpha_options, $wpha_skins_styles, $wpha_customization;			

			if(array_key_exists('skins', $wpha_options) && array_key_exists($wpha_options['skins'], $wpha_skins_styles)){
				$wpha_customization = $wpha_skins_styles[$wpha_options['skins']]['styles'];
			}
			
			return $wpha_customization;
	
		}
	}
	
	function wpha_is_fa($str){

		$str = trim($str);
		$sub_str = substr($str, 0, 2);
		return $sub_str == 'fa';
	
	}

	function wpha_is_image($str){

	
		$str = trim($str);
		return (strlen($str) == 0 || $str=='none');
	
	}
	
	add_action('admin_head', 'wpha_admin_head_func');
	function wpha_admin_head_func(){
		
		global $wpha_url;
		
?>
	<style type="text/css">
	
		
		li a[href="options-general.php?page=wp-hamburger"], 
		li a[href="options-general.php?page=wp-hamburger"]:hover {
			background-color: #fff !important;
			color: #32373c !important;
			background-image:url("<?php echo $wpha_url; ?>img/icon.png") !important;
			background-size: 18px !important;
			background-repeat: no-repeat !important;
			background-position: 110px !important;
			font-size: 12px !important;
		}				
		li a[href="options-general.php?page=wp-hamburger"]:hover {
			background-color: #EFEFEF !important;
			color: #1B1B1B !important;
		}
		
		@media only screen and (max-device-width: 480px) {
			
			
		}			
		
		/* ipad */
		@media only screen 
		and (min-device-width : 768px) 
		and (max-device-width : 1024px)  {
		}
		
		@media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {

		}
		@supports (-ms-accelerator:true) {
		  /* IE Edge 12+ CSS styles go here */ 
		}				
	</style>
    
<?php        
	}

	function sanitize_wpha_data( $input ) {
	
			if(is_array($input)){
			
				$new_input = array();
		
				foreach ( $input as $key => $val ) {
					$new_input[ $key ] = (is_array($val)?sanitize_wpha_data($val):sanitize_text_field( $val ));
				}
				
			}else{
				$new_input = sanitize_text_field($input);
			}
	
			if(!is_array($new_input)){
	
				if(stripos($new_input, '@') && is_email($new_input)){
					$new_input = sanitize_email($new_input);
				}
	
				if(stripos($new_input, 'http') || wp_http_validate_url($new_input)){
					$new_input = esc_url($new_input);
				}
	
			}
	
			
			return $new_input;
		}	
	
	function wpha_admin_enqueue_script()
	{
		if (isset($_GET['page']) && $_GET['page'] == 'wp-hamburger') {
			
			wp_enqueue_media();
			
			global $wpha_pro, $wpha_options, $wpha_settings_url, $wpha_customization, $wpha_default_bullet_img;
			
			if(!array_key_exists('disable_bootstrap', $wpha_options)){	
				wp_enqueue_script('wpha_boostrap', plugin_dir_url(dirname(__FILE__)) . 'js/bootstrap.min.js', array('jquery'));
				wp_enqueue_style('wpha-boostrap', plugins_url('css/bootstrap.min.css', dirname(__FILE__)));
			}
			wp_enqueue_script('wpha_slim', plugin_dir_url(dirname(__FILE__)) . 'js/slimselect.js', array('jquery'));
			wp_enqueue_style('wpha-slim', plugins_url('css/slimselect.css', dirname(__FILE__)));
	
			wp_enqueue_style('wpha-fontawesome', plugins_url('css/fontawesome.min.css', dirname(__FILE__)));
	

			wp_enqueue_style('wpha-admin', plugins_url('css/admin-styles.css?t='.time(), dirname(__FILE__)), time());

			wp_enqueue_script('wpha-jquery-form-min', plugin_dir_url(dirname(__FILE__)) . 'js/jquery.form.min.js?t='.time(), array('jquery'));
			wp_enqueue_script('wpha_admin_scripts', plugin_dir_url(dirname(__FILE__)) . 'js/admin-scripts.js?t='.time(), array('jquery'));
			wp_enqueue_script('wpha-fontawesome-js', plugin_dir_url(dirname(__FILE__)) . 'js/fontawesome.min.js', array('jquery'));

			if($wpha_pro){
				wp_enqueue_script('wpha_pro_scripts', plugin_dir_url(dirname(__FILE__)) . 'pro/admin-scripts.js?t='.time(), array('jquery'));
			}
			
			
			wp_localize_script(
				'wpha_admin_scripts',
				'wpha_object',
				array(

                    'this_url' => $wpha_settings_url,
                    'is_pro' => $wpha_pro,
                    'wpha_tab' => (isset($_GET['t'])?esc_attr($_GET['t']):'0'),
					'ajax_url' => admin_url('admin-ajax.php'),
					'url' => $wpha_settings_url,
					'nonce' => wp_create_nonce('wpha_update_options_nonce'),
                    'wpha_customization' => $wpha_customization,
					'default_bullet_img' => $wpha_default_bullet_img,
					'premium_feature' => __('This feature is available in premium version.', 'wp-hamburger')

				)
			);
		}
	}
	
	
	add_action('admin_enqueue_scripts', 'wpha_admin_enqueue_script');
	
	add_action('wp_enqueue_scripts', 'wpha_wp_enqueue_script');
	
	function wpha_wp_enqueue_script()
	{
		global $post, $wpha_pro, $wpha_url, $wpha_options;
		
		if(!array_key_exists('disable_fontawesome', $wpha_options)){
	
			wp_enqueue_style('wpha-fontawesome', plugins_url('css/fontawesome.min.css', dirname(__FILE__)));
			wp_enqueue_script('wpha-fontawesome-js', plugin_dir_url(dirname(__FILE__)) . 'js/fontawesome.min.js', array('jquery'));
		}
		
		if(!is_admin()){
			wp_enqueue_script('wpha-front-scripts', plugin_dir_url(dirname(__FILE__)) . 'js/front-scripts.js', array('jquery'));
		}



	}
	
	if (is_admin()) {
		add_action('admin_menu', 'wpha_menu');
	}
	function wpha_menu()
	{
		global $wpha_data, $wpha_pro;
	
		$title = $wpha_data['Name'];
		add_submenu_page('options-general.php', $title, $title, 'manage_options', 'wp-hamburger', 'wpha_settings' );
	}
	function wpha_settings()
	{
		global $wpha_premium_link, $wpha_pro, $wpha_url;
		$wpha_options = get_option('wpha_options', array());
		$wpha_options = is_array($wpha_options)?$wpha_options:array();
		include_once('wpha_settings.php');
	}


    add_action('wp_ajax_wpha_update_option', 'wpha_update_option');

    if(!function_exists('wpha_update_option')){
        function wpha_update_option(){


            $return = array(

                'status' => false,

            );

            if(isset($_POST['wpha_update_option_nonce'])){

                $nonce = $_POST['wpha_update_option_nonce'];



                if ( ! wp_verify_nonce( $nonce, 'wpha_update_options_nonce' ) ) die (__("Sorry, your nonce did not verify.", 'wp-hamburger'));
				
				global $wpha_customization, $wpha_pro, $wpha_options, $wpha_skins_styles;
				
				$wpha_options_updated = isset($_POST['wpha_options']) ? sanitize_wpha_data($_POST['wpha_options']) : array();
				
				//pree($wpha_pro);
				//pree($wpha_options['skins'].'!='.$wpha_options_updated['skins']);
				//pree($wpha_customization);
				if($wpha_pro && $wpha_options['skins']!=$wpha_options_updated['skins']){
					//pree($wpha_options_updated['skins']);
					//pree($wpha_skins_styles);
					//pree($wpha_skins_styles[$wpha_options_updated['skins']]);
					update_option('wpha-customization', $wpha_skins_styles[$wpha_options_updated['skins']]['styles']);
					$wpha_options_updated['position'] = $wpha_skins_styles[$wpha_options_updated['skins']]['options']['position'];
					$wpha_options_updated['dom'] = '';
				}
				//exit;

				$return['status'] = update_option('wpha_options', $wpha_options_updated);


            }


            wp_send_json($return);



        }
    }

    function wpha_plugin_links($links) {
        global $wpha_premium_link, $wpha_pro, $wpha_settings_url;

        $settings_link = '<a href="'.esc_url($wpha_settings_url).'">'.__('Settings', 'wp-hamburger').'</a>';

        if(!$wpha_pro && $wpha_premium_link){
			$wpha_premium_link = '<a href="'.esc_url($wpha_premium_link).'" title="'.__('Go Premium', 'wp-hamburger').'" target="_blank">'.__('Go Premium', 'wp-hamburger').'</a>';
			array_unshift($links, $settings_link, $wpha_premium_link);
        }else{
			array_unshift($links, $settings_link);
        }


        return $links;
    }
	
	function wp_hamburger_update(){

		global $wpha_customization;

		if(!empty($_POST) && (isset($_POST['wpha-configuration']) || isset($_POST['wpha-customization']))){

			if ( 
					
					! isset( $_POST['wp_hamburger_field'] ) 
	
					|| ! wp_verify_nonce( $_POST['wp_hamburger_field'], 'wp_hamburger_action' ) 

			) {

			

			   _e( 'Sorry, your nonce did not verify.', 'wp-hamburger');

			   exit;

			

			} else {
				
					if(array_key_exists('wpha-configuration', $_POST)){
						

						$wpha_configuration_saved = get_option('wpha-configuration', array());
						$wpha_hover_settings = array_key_exists('hover_settings', $wpha_configuration_saved) ? $wpha_configuration_saved['hover_settings'] : array();					
						$wpha_configuration = (is_array($_POST['wpha-configuration'])?sanitize_wpha_data($_POST['wpha-configuration']):array());						
						$wpha_hover_settings_post = array_key_exists('hover_settings', $wpha_configuration) ? $wpha_configuration['hover_settings'] : array();
						
						if(!empty($wpha_hover_settings_post)){
						
							
							foreach($wpha_hover_settings_post as $hover_settings_key => $hover_settings_value){
							
							
								$wpha_hover_settings[$hover_settings_key] = $hover_settings_value;
							
							}
							
							$wpha_configuration['hover_settings'] = $wpha_hover_settings;
						
						
						}
												
						update_option('wpha-configuration', $wpha_configuration);
					}

					if(array_key_exists('wpha-customization', $_POST)){
						//$wpha_configuration_saved = get_option('wpha-configuration', array());
						//$wpha_hover_settings = array_key_exists('hover_settings', $wpha_configuration_saved) ? $wpha_configuration_saved['hover_settings'] : array();
						
						//$wpha_configuration = (is_array($_POST['wpha-configuration'])?sanitize_wpha_data($_POST['wpha-configuration']):array());
						
						$wpha_customization = (is_array($_POST['wpha-customization'])?sanitize_wpha_data($_POST['wpha-customization']):array());
						
						
						update_option('wpha-customization', $wpha_customization);
					}
					
					//pree($_POST);
					//exit;

			  
			}

			
		}
			
		

	}

		
	
	function wpha_config_menu($menu_slug){
	
	
		if($menu_slug){
		
			
			$wp_nav_menu_args = array(
				//'theme_location' => 'primary',
				'menu' => $menu_slug,
				'menu_class' => "wpha_config_menu",
				'menu_id' => "",
				'container' => false ,
				'walker' => new Wpha_config_Nav_Walker(),
			);
?>

<h5 class="alert <?php echo $menu_slug?'alert-success':'alert-secondary'; ?>"><?php _e('Hamburger Menu Hover Effects', 'wp-hamburger'); ?><i class="fas fa-bars float-right"></i></h5>

<div class="wpha-hover-demo">
	<a></a>
</div>

<?php			
			wp_nav_menu($wp_nav_menu_args);
			
		
		}else{
		
		
			
			?>
			
			
			<div class="alert alert-info">
			
				<?php _e('Menu not selected', 'wp-hamburger'); ?>
			
			</div>
			
			
			<?php
			
		
		}
	
	
	
	
	}
	
	
	function wpha_load_selected_menu(){
	
		
		$result = array(
		
		'status' => false,
		'html' => '',
		
		);
		
		if(!empty($_POST) && isset($_POST['wpha_selected_menu'])){
		
			
			if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wpha_update_options_nonce')){
			
			
				wp_die(__('Sorry, your nonce did not verify.', 'wp-hamburger'));
			
			
			}else{
			
				$wpha_selected_menu = sanitize_wpha_data($_POST['wpha_selected_menu']);
				
				if(isset($_POST['wpha_reset_item_id'])){
					
					$wpha_configuration = get_option('wpha-configuration', array());
					$wpha_hover_settings = wpha_get_config_settings_menu_slug($wpha_selected_menu);
					$reset_item_id = sanitize_wpha_data($_POST['wpha_reset_item_id']);
					
					if(array_key_exists($reset_item_id, $wpha_hover_settings)){
					
					
						
						unset($wpha_hover_settings[$reset_item_id]);
						
						$wpha_configuration['hover_settings'] = $wpha_hover_settings;
						
						update_option('wpha-configuration', $wpha_configuration);
						
					}
					
				
				
				
				}
				
				ob_start();
				
				wpha_config_menu($wpha_selected_menu);
				
				$content = ob_get_clean();
				
				$result['status'] = true;
				$result['html'] = $content;
			
			}
			
		
		}
		
		
		wp_send_json($result);
		
		
		
	}
	
	
	function wpha_get_config_settings_by_item($item_id){
	
		global $wpha_url, $wpha_customization;
		
		
		
		$wpha_configuration = get_option('wpha-configuration', array());
		$wpha_configuration = is_array($wpha_configuration)?$wpha_configuration:array();
		
		
		
		$current_item_settings_saved = isset($wpha_configuration['hover_settings']) && isset($wpha_configuration['hover_settings'][$item_id]) ? $wpha_configuration['hover_settings'][$item_id] : array();
		
		
		$default_background = $wpha_customization['background'];
		$default_foreground = $wpha_customization['foreground'];
		$default_img = $wpha_url.'img/default_bg_img.png';
		
		
	
		$current_item_settings = array(	
			'background' => '',
			'background_color' => '',
			'foreground_color' => '',
			'background_img' => '',
		);
		
		if(!empty($current_item_settings_saved)){
			foreach($current_item_settings_saved as $current_item_key=>$current_item_value){
				$current_item_settings[$current_item_key]=$current_item_value;
			}
		}
		
		
		
		return $current_item_settings;
	
	
	}
	
	function wpha_get_config_settings_menu_slug($slug){
	
	$menu_items = wp_get_nav_menu_items($slug);
	
	$wpha_item_config_array = array();
	
	if(!empty($menu_items)){
	
	
	foreach($menu_items as $menu_item){
	
	$wpha_item_config_array[$menu_item->ID] = wpha_get_config_settings_by_item($menu_item->ID);
	
	
	}
	
	}
	
	
	return $wpha_item_config_array;
	
	
	}
	
	
	
	add_action('wp_ajax_wpha_load_selected_menu', 'wpha_load_selected_menu');
	add_action('admin_init', 'wp_hamburger_update');	
	
		
	function wpha_get_hover_styles($menu_slug){
	
		
		$wpha_hover_settings = wpha_get_config_settings_menu_slug($menu_slug);
		
		if(!empty($wpha_hover_settings)){
		
		foreach($wpha_hover_settings as $menu_item_id => $settings){
		
		//$settings['background']; image or color
		//$settings['background_color']; background color
		//$settings['foreground_color']; foreground color
		//$settings['background_img']; image url
		
		if($settings['background'] == 'color' || ($settings['background'] == 'image' && $settings['background_img'] == "")){
		
		
		
		?>
		
		label.wpha input:checked + .menu.hover-menu-item-<?php echo $menu_item_id ?>{
		
		box-shadow: 0 0 0 100vw <?php echo $settings['background_color'] ?>, 0 0 0 100vh <?php echo $settings['background_color'] ?>;
		background : <?php echo $settings['background_color'] ?>;
		
		
		}
        label.wpha li#menu-item-<?php echo $menu_item_id ?>:hover > a{
       	 color : <?php echo $settings['foreground_color'] ?>;
        }
		
		<?php
		
		}elseif($settings['background'] == 'image'){
		
		
		?>
		
		label.wpha input:checked + .menu.hover-menu-item-<?php echo $menu_item_id ?>{
		
		
		
		
		}
		
		
		<?php
		
		
		}
		
		
		}
		
		
		}
	
	
	
	}
	
	function wpha_get_hover_script(){
	
	?>
	
	
	$('label.wpha ul li a').on('mouseover', function(){
        if($('.wp_hamburger_preloaded_images').length>0){
            $('.wp_hamburger_preloaded_images').remove();
        }
	
        var parent_id = $(this).parents('li:first').prop('id');
        var hover_class = 'hover-'+parent_id;
        
        $('label.wpha input:checked + .menu').prop('class', 'menu '+hover_class);
	
	
	});
	
	$('label.wpha ul li a').on('mouseout', function(){
	
	
	
		$('label.wpha input:checked + .menu').prop('class', 'menu ');
	
	
	});
	
	
	<?php
	
	}	
	
function wpha_elektro_style($args){

	
    extract($args);
	global $wpha_options;
?>



    .elektro-ham{
    
    z-index: 99999;


    <?php if($is_mobile): ?>
		
        <?php if($wpha_options['position']=='default'): ?>
        
			<?php if(!$is_hide_on_scroll_mobile): ?>
                position: fixed;
            <?php else: ?>
                position: absolute;
            <?php endif; ?>
            
		<?php else: ?>
        
        		position: <?php echo $wpha_options['position']; ?>;
        
        <?php endif; ?>

    <?php else: ?>
    
    	<?php if($wpha_options['position']=='default'): ?>

			<?php if(!$is_hide_on_scroll_desktop): ?>
                position: fixed;
            <?php else: ?>
                position: absolute;
            <?php endif; ?>

		<?php else: ?>
        
        		position: <?php echo $wpha_options['position']; ?>;
        
        <?php endif; ?>
        
    <?php endif; ?>

    top: 30px;
    right: 30px;

    height:44px;
    width:44px;

    text-align:center;

    <?php if($wpha_customization['ham_background']){ ?>

        background-color:<?php echo $wpha_customization['ham_background']; ?>;


    <?php }else{ ?>

        background-color:#000;

    <?php } ?>


    cursor:pointer;
    }
    .elektro-ham .fa-bars{
    font-size:24px;

    <?php if($wpha_customization['foreground']){ ?>

        color:<?php echo $wpha_customization['foreground']; ?>;


    <?php }else{ ?>

        color:#FFF;

    <?php } ?>



    position:relative;
    top:10px;
    }
    .elektro-menu{


    <?php if($wpha_customization['background']){ ?>

        background-color:<?php echo $wpha_customization['background']; ?>;


    <?php }else{ ?>

        color:#F9E709;

    <?php } ?>
    




    background-repeat:no-repeat;
    background-size:cover;
    display:none;
    position: fixed;

    top: 0;
    right: 0;
    left: 0;
    bottom: 0;

    width: auto;
    height: auto;

    align-items: center;
    justify-content: center;
    transition: all ease-in-out .25s;
    z-index: 99999;
    overflow-y: auto;
    box-sizing: border-box;
    line-height: 36px;
    }
    .elektro-menu > img{ /* ignore */
    position:absolute;
    left:0;
    top:0;
    width:100%;
    opacity:0;
    }
    .elektro-menu.flexed{
    display: flex;
    transition: all ease-in-out .25s;
    }
    .elektro-menu .elektro-close{
    top: 10px;
    right: 10px;
    position:absolute;
    cursor:pointer;
    width: 32px;
    height: 32px;
    line-height: 1;

    align-items: center;
    justify-content: center;
    display: flex;
    }
    .elektro-menu .elektro-close .fa-times{
    font-size:22px;
   <?php if($wpha_customization['menu-color']): ?>
        color: <?php echo $wpha_customization['menu-color']; ?>;
    <?php else: ?>
        color: #000000;
    <?php endif; ?>

    }
    .elektro-menu .elektro-items{
    }
    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?>{
        padding: 0;
        margin: 0;    
    }
    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> li{

    <?php if($closed_list_style): ?>
        list-style: <?php echo $closed_list_style; ?>;
    <?php else: ?>
        list-style: none;
    <?php endif; ?>

    }


    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> li.opened{

    <?php if($opened_list_style): ?>
        list-style: <?php echo $opened_list_style; ?>;
    <?php else: ?>
        list-style: none;
    <?php endif; ?>

    }

    .elektro-menu ul.sub-menu li{

    <?php if($sub_list_style): ?>
        list-style: <?php echo $sub_list_style; ?>;
    <?php else: ?>
        list-style: none;
    <?php endif; ?>

    }

    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> > li a,
    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> > li ul.sub-menu a{

    <?php if($wpha_customization['font-family']): ?>
        font-family: <?php echo $wpha_customization['font-family']; ?>;
    <?php endif; ?>



    text-transform: uppercase;
    padding: 20px 30px 20px 30px;

    display: block;
    align-items: center;
    position: relative;
    text-decoration: none;
    text-align: center;


    }
    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> > li a{
    <?php if($wpha_customization['menu-font-size']): ?>
        font-size: <?php echo $wpha_customization['menu-font-size']; ?>;
    <?php else: ?>
        font-size: 28px;
    <?php endif; ?>
    <?php if($wpha_customization['menu-color']): ?>
        color: <?php echo $wpha_customization['menu-color']; ?>;
    <?php else: ?>
        color: #000000;
    <?php endif; ?>
    }
    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> li ul.sub-menu a{
    <?php if($wpha_customization['sub-menu-font-size']): ?>
        font-size: <?php echo $wpha_customization['sub-menu-font-size']; ?>;
    <?php else: ?>
        font-size: 26px;
    <?php endif; ?>
	}
    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> li ul.sub-menu a:hover{
    <?php if($wpha_customization['sub-menu-font-size']): ?>
        font-size: <?php echo $wpha_customization['sub-menu-font-size']; ?>;
    <?php else: ?>
        font-size: 26px;
    <?php endif; ?>    
    <?php if($wpha_customization['sub-menu-color']): ?>
        color: <?php echo $wpha_customization['sub-menu-color']; ?>;
    <?php else: ?>
        color: #000000;
    <?php endif; ?>
    }
    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> li a:hover{
    color: #F9E709;
    background-color: #000000;

    }
    .elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> li ul{
    display:none;
    }






    <?php



}


function wpha_elektro_script($skin_type, $wp_nav_menu_args){
	
	global $wpha_options;
	
	$is_hide_on_desktop = array_key_exists('hide_desktop', $wpha_options);
	$is_hide_on_scroll_desktop = array_key_exists('scroll_hide_desktop', $wpha_options);
	$is_hide_on_mobile = array_key_exists('hide_mobile', $wpha_options);
	$is_hide_on_scroll_mobile = array_key_exists('scroll_hide_mobile', $wpha_options);
	$is_mobile = wp_is_mobile();
	
	
	if((!$is_mobile && !$is_hide_on_desktop) || ($is_mobile && !$is_hide_on_mobile)){
		
	switch($skin_type){
        default:
		
            ?>
            $('label.wpha span.menu').on('click', function(){
				$(this).parent().toggleClass('activated');
            });
            
            <?php if($is_hide_on_scroll_desktop || ($is_hide_on_scroll_mobile && $is_mobile)): ?>
            $(window).scroll(function (event) {
                var scroll = $(window).scrollTop();
                if(scroll>270){
                	$('label.wpha').hide();
                }else{
	                $('label.wpha').show();
                }
            });
            <?php endif; ?>


            setTimeout(function(){
                if(typeof jQuery('label.wpha input:checked').prop('checked')=="boolean"){
                 $('label.wpha span.menu').parent().addClass('activated');
                }
            }, 100);

           

<?php
		break;
        case 'elektro':



?>


            $('.elektro-ham, .elektro-close').click(function(){
            	$('.elektro-menu').toggleClass('flexed');
                if($('.wp_hamburger_preloaded_images').length>0){
	                $('.wp_hamburger_preloaded_images').remove();
                }
            });
            $('.elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> li a').on('mouseover', function(){
                var background_type = $(this).parent().data('background');
                var background_color = $(this).parent().data('background_color');
                var foreground_color = $(this).parent().data('foreground_color');
                var background_img = $.trim($(this).parent().data('background_img'));

                if(background_img && background_type=='image'){                	
                    $('.elektro-menu').css({'background-image':'url('+background_img+')','background-repeat': 'no-repeat', 'background-size': 'cover','opacity':1,'transition':'opacity 0.2s linear 0s'});
                    //$('.elektro-menu').prepend('<img src="'+background_img+'" style="transition:opacity 0.2s linear 0s" />');
                    $(this).css({'background-color':background_color, 'color':foreground_color});
                }else{
                    $('.elektro-menu').css({'background-color':background_color});
                    $(this).css({'color':foreground_color});
                }
                $('.elektro-close .fa-times').css({'color':foreground_color});


            });
            $('.elektro-menu ul.<?php echo $wp_nav_menu_args['menu_class']; ?> li a').on('mouseout', function(){
                //console.log($(this));
                $('.elektro-menu > img').remove();
                $('.elektro-menu, .elektro-close .fa-times').removeAttr('style');
                $(this).removeAttr('style');
            });



<?php
		break;
    }
	}
	


}

	