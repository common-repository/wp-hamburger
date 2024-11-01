<?php
add_action('wp_footer', 'wp_hamburger_footer_scripts');

if(!function_exists('wp_hamburger_footer_scripts')){
function wp_hamburger_footer_scripts(){

  global $wpha_options, $wpha_customization, $wpha_pro;

  	//pree($wpha_customization);
	$skin_type = (array_key_exists('skins', $wpha_options) && $wpha_options['skins']!='default'?$wpha_options['skins']:'default');
	$wpha_configuration = get_option('wpha-configuration', array());
	$wpha_configuration = is_array($wpha_configuration)?$wpha_configuration:array();
	$is_hide_on_desktop = array_key_exists('hide_desktop', $wpha_options);
	$is_hide_on_scroll_desktop = array_key_exists('scroll_hide_desktop', $wpha_options);
	$is_hide_on_mobile = array_key_exists('hide_mobile', $wpha_options);
	$is_hide_on_scroll_mobile = array_key_exists('scroll_hide_mobile', $wpha_options);
	$is_mobile = wp_is_mobile();

	
	
	if((!$is_mobile && !$is_hide_on_desktop) || ($is_mobile && !$is_hide_on_mobile)){
	}else{
		return;
	}

	$wp_nav_menu_args = array(
		//'theme_location' => 'primary',
		'menu' => '',
		'menu_class'        => "",
		'menu_id'           => "",
		'container' => false	,	
		'walker' => 		new Wpha_Custom_Nav_Walker(),
	);
	if(array_key_exists('wpha-menu', $wpha_configuration)){
		$wp_nav_menu_args['menu'] = $wpha_configuration['wpha-menu'];
		$wp_nav_menu_args['menu_class'] = 'wpha-'.$wpha_configuration['wpha-menu'];
	}	
	//pree($wp_nav_menu_args);
	if($wp_nav_menu_args['menu']){

	
		//pree($wpha_customization);
		$wpha_main_close = $wpha_customization['menu-bullet-closed'];
		$wpha_main_open = $wpha_customization['menu-bullet-opened'];
		$wpha_sub_menu = $wpha_customization['sub-menu-bullet-closed'];
		
		$closed_list_style = ($wpha_pro && (wpha_is_fa($wpha_main_close) || wpha_is_image($wpha_main_close))) ? 'none' : $wpha_main_close;
		$opened_list_style = ($wpha_pro && (wpha_is_fa($wpha_main_open) || wpha_is_image($wpha_main_open))) ?  'none' : $wpha_main_open;
		$sub_list_style = ($wpha_pro && (wpha_is_fa($wpha_sub_menu) || wpha_is_image($wpha_sub_menu))) ? 'none' : $wpha_sub_menu; 
		
	
	
    
		
	      
	
	switch($skin_type){
	default:
?>
	<label class="wpha">
	<input type='checkbox'>
	<span class='menu'> <span class='hamburger'></span> </span>
<?php
	//pree($wp_nav_menu_args);
	wp_nav_menu($wp_nav_menu_args);
?>
	</label>
<?php
	break;
	case 'elektro':
?>
	<div class="elektro-ham">
		<i class="fa fa-bars"></i>
	</div>
	<div class="elektro-menu">
		<a class="elektro-close"><i class="fa fa-times"></i></a>
		<div class="elektro-items">
<?php
	//pree($wp_nav_menu_args);
		wp_nav_menu($wp_nav_menu_args);
?>
		</div>
	</div>
<?php
	break;
	}
?>

<style type="text/css">

<?php
	switch($skin_type){
	default:
?>
label.wpha .menu {

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
	
	right: -100px;
	top: -100px;
	z-index: 99999;
	width: 200px;
	height: 200px;
	background: <?php echo $wpha_customization['ham_background']; ?>;
	border-radius: 50% 50% 50% 50%;
	-webkit-transition: .5s ease-in-out;
	transition: .5s ease-in-out;
	box-shadow: 0 0 0 0 #FFF, 0 0 0 0 #FFF;
	cursor: pointer;  
}


<?php if(($is_mobile && $is_hide_on_scroll_mobile) || (!$is_mobile && $is_hide_on_scroll_desktop)): ?>
body {	
	overflow-x: hidden;
}  
<?php endif; ?>


label.wpha .hamburger {
  position: absolute;
  top: 135px;
  left: 50px;
  width: 30px;
  height: 2px;
  background: <?php echo $wpha_customization['foreground']; ?>;
  display: block;
  -webkit-transform-origin: center;
  transform-origin: center;
  -webkit-transition: .5s ease-in-out;
  transition: .5s ease-in-out;
  
}

label.wpha .hamburger:after, label .hamburger:before {
  -webkit-transition: .5s ease-in-out;
  transition: .5s ease-in-out;
  content: "";
  position: absolute;
  display: block;
  width: 100%;
  height: 100%;
  background: <?php echo $wpha_customization['foreground']; ?>;
}

label.wpha .hamburger:before { top: -10px; }

label.wpha .hamburger:after { bottom: -10px; }

label.wpha input { display: none; }

label.wpha input:checked + .menu {
  box-shadow: 0 0 0 100vw <?php echo $wpha_customization['background']; ?>, 0 0 0 100vh <?php echo $wpha_customization['background']; ?>;
  border-radius: 0;
}
label.wpha input:checked + .menu .hamburger {
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}

label.wpha input:checked + .menu .hamburger:after {
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
  bottom: 0;
}

label.wpha input:checked + .menu .hamburger:before {
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
  top: 0;
}
label.wpha input:checked + .menu + ul { opacity: 1; }
label.wpha > ul {
  z-index: 99999;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  opacity: 0;
  -webkit-transition: .25s 0s ease-in-out;
  transition: .25s 0s ease-in-out;
  padding:0;
  margin: 0;
  display:none;
}

label.wpha.activated > ul {
	display:block;
}
label.wpha ul li{

  position: relative;
}

label.wpha a {
  margin-bottom: 1em;
  display: block;  
  text-decoration: none;
  font-weight:400;
  
}
label.wpha > ul > li > a{
	font-size: 18px;
}
label.wpha ul.sub-menu{
	display:none;
	margin: 0;
	padding: 0 0 0 16px;
	width: 100%;
}
label.wpha ul.sub-menu a{
	width: 100%;
	color: <?php echo $wpha_customization['sub-menu-color']; ?>;
}
label.wpha ul.sub-menu > li > a{
	font-size: 18px;
}

label.wpha ul.<?php echo $wp_nav_menu_args['menu_class']; ?> > li > a{
	cursor:pointer;
	color: <?php echo $wpha_customization['menu-color']; ?>;
}
label.wpha ul.<?php echo $wp_nav_menu_args['menu_class']; ?> > li{
	height:auto;
	list-style: <?php echo $closed_list_style; ?>;
}
label.wpha ul.<?php echo $wp_nav_menu_args['menu_class']; ?> > li.opened{
	list-style:<?php echo $opened_list_style; ?>;
}
label.wpha ul.sub-menu li{
	list-style:<?php echo $sub_list_style; ?>;
	color: <?php echo $wpha_customization['sub-menu-color']; ?>;
}
<?php
	break;
	case 'elektro':




	
		$elektro_args = array(
			'is_mobile' => $is_mobile,
			'is_hide_on_scroll_mobile' => $is_hide_on_scroll_mobile,
			'is_hide_on_scroll_desktop' => $is_hide_on_scroll_desktop,
			'wpha_customization' => $wpha_customization,
			'wp_nav_menu_args' => $wp_nav_menu_args,
			'closed_list_style' => $closed_list_style,
			'opened_list_style' => $opened_list_style,
			'sub_list_style' => $sub_list_style,
		);
	
		wpha_elektro_style($elektro_args);

?>



<?php
	break;
}



	
	if(function_exists('wpha_get_hover_styles') && !array_key_exists('disable_hover', $wpha_options)){
	
		wpha_get_hover_styles($wp_nav_menu_args['menu']);
	
	}



?>
</style>
<script type="text/javascript" language="javascript">
	jQuery(document).ready(function($){
		

		
		<?php wpha_elektro_script($skin_type, $wp_nav_menu_args); ?>
		
				
<?php

		if(function_exists('wpha_get_hover_script')){

			wpha_get_hover_script();

		}

?>	
		
	});	
</script>
<?php	
	}
}
}

	add_action('wp_footer', 'wp_hamburger_img_preloader');
	function wp_hamburger_img_preloader(){
		global $wpha_img_preloader, $wpha_options;
		echo implode('', $wpha_img_preloader);
?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			<?php if(array_key_exists('dom', $wpha_options) && trim($wpha_options['dom'])!=''): ?>

				if($('.elektro-ham').length>0){
					$('<?php echo $wpha_options['dom']; ?>').append($('.elektro-ham'));
					$('.elektro-ham').css({'top':0, 'right':0});
				}
				

				if($('label.wpha').length>0){
					$('<?php echo $wpha_options['dom']; ?>').append($('label.wpha'));
					$('label.wpha .menu').css({'top':0, 'right':0});
				}

			<?php endif; ?>
		});
	</script>
<?php		
	}