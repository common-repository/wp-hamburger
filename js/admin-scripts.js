// JavaScript Document
jQuery(document).ready(function($){

	function parse_query_string(query) {
	  var vars = query.split("&");
	  var query_string = {};
	  for (var i = 0; i < vars.length; i++) {
		var pair = vars[i].split("=");
		// If first entry with this name
		if (typeof query_string[pair[0]] === "undefined") {
		  query_string[pair[0]] = decodeURIComponent(pair[1]);
		  // If second entry with this name
		} else if (typeof query_string[pair[0]] === "string") {
		  var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
		  query_string[pair[0]] = arr;
		  // If third or later entry with this name
		} else {
		  query_string[pair[0]].push(decodeURIComponent(pair[1]));
		}
	  }
	  return query_string;
	}	
	var query = window.location.search.substring(1);
	var qs = parse_query_string(query);		
	
	if(typeof(qs.t)!='undefined'){

		$('.wpha-wrapper a.nav-tab').eq(qs.t).click();
		
	}
	
	
	$('#wpha_customization_form :input').prop('disabled', (wpha_object.is_pro!="1"));
	
	$('.wpha-wrapper a.nav-tab').click(function(){

		$(this).siblings().removeClass('nav-tab-active');
		$(this).addClass('nav-tab-active');
		$('.nav-tab-content').hide();
		$('.nav-tab-content').eq($(this).index()).show();
		window.history.replaceState('', '', wpha_object.this_url+'&t='+$(this).index());
		wpha_object.wpha_tab = $(this).index();
		$('input[name="wpha_tn"]').val($(this).index());

	});


    var wpha_init_change = true;
	
	$('input[name^="wpha_options"], select[name^="wpha_options"]').on('change', function(){
		//console.log($(this));
		//console.log($(this).parents().eq(1));

		$(this).parents().eq(1).find('ul').toggleClass('d-none');
		
		$('.wpha_log ul li.selected').removeClass('selected');
		

		var wpha_option_checked = $('input[name^="wpha_options"][type="checkbox"]:checked');
		var wpha_option_text = $('input[name^="wpha_options"][type="text"]');
		var wpha_option_select = $('select[name^="wpha_options"]');

		var wpha_options_post = {};



		if(wpha_option_select.length > 0 ){
			$.each(wpha_option_select, function () {

				wpha_options_post[$(this).data('name')] = $(this).val();

			});
		}


		if(wpha_option_text.length > 0 ){
			$.each(wpha_option_text, function () {

				wpha_options_post[$(this).data('name')] = $(this).val();

			});
		}

		if(wpha_option_checked.length > 0 ){
			$.each(wpha_option_checked, function () {

				wpha_options_post[$(this).val()] = true;

				$(this).parents().eq(1).addClass('selected');

			});
		}


		//when document load first time then no need to save settings therefore return from here change just to show checked icon after input

		if(wpha_init_change){

		    wpha_init_change = false;
		    return;

		}
	


		var data = {

			action : 'wpha_update_option',
			wpha_update_option_nonce : wpha_object.nonce,
			wpha_options : wpha_options_post,

		}



		$.post(ajaxurl, data, function(response, code){

			//console.log(response);

			if(code == 'success' && response.status){

				$('.wpha-options .alert').removeClass('d-none').addClass('show');
				setTimeout(function(){
					$('.wpha-options .alert').addClass('d-none');
				}, 5000);

			}



		});
		

	});


    $('input[name^="wpha_options"]').change();


    var load_modal = $('.wpha_load_modal');

    //new code start from here

	function wpha_is_fa(str){

		var sub_str = str.substr(0, 2);
		return sub_str == 'fa';
	
	}

	function wpha_is_image(str){

	
		str = str.trim();
		return  str.length == 0;
	
	}

    function wpha_init_demo(wpha_customization){
		
		//console.log(wpha_customization);


        $('.wpha-humburger-demo').css({'background': wpha_customization.ham_background});
        $('.wpha-menu-item-demo').css({'background': wpha_customization.background, 'opacity':wpha_customization.background_opacity});
        $('.wpha-humburger-demo .fa-bars').css({'color': wpha_customization.foreground});
		
		




		var menu_close = wpha_customization['menu-bullet-closed'];
		var sub_menu_close = wpha_customization['sub-menu-bullet-closed'];
		var menu_open = wpha_customization['menu-bullet-opened'];

		

		var menu_close_img = wpha_customization['menu-bullet-closed-img'];
		var sub_menu_close_img = wpha_customization['sub-menu-bullet-closed-img'];
		var menu_open_img = wpha_customization['menu-bullet-opened-img'];

		//console.log(wpha_customization);


        var style_menu_close = {

            'color': wpha_customization['menu-color'],
            'list-style': wpha_is_fa(menu_close) || wpha_is_image(menu_close) ? 'none' : menu_close,

            };

        var style_menu_open = {

			'list-style': wpha_is_fa(menu_open) || wpha_is_image(menu_open) ? 'none' : menu_open,

            };

        var style_sub_menu = {

			'color': wpha_customization['sub-menu-color'],
			'list-style': wpha_is_fa(sub_menu_close) || wpha_is_image(sub_menu_close) ? 'none' : sub_menu_close,


			};
			

			


		$('.wpha-menu-item-demo ul li').find('.svg-inline--fa').remove();

		if(wpha_is_fa(menu_close)){

			
			var fa_icon = `<i class="fa `+menu_close+`"></i>`;
			$('.wpha-menu-item-demo ul:first > li').prepend(fa_icon);


		}


		$('.wpha-menu-item-demo ul li ul li').parents('li').find('.fa').remove();

		if(wpha_is_fa(menu_open)){

			
			// style_menu_close[''] = '';
			var fa_icon = `<i class="fa `+menu_open+`"></i>`;

			$('.wpha-menu-item-demo ul li ul li').parents('li').prepend(fa_icon);


		}



		if(wpha_is_fa(sub_menu_close)){

			
			// style_menu_close[''] = '';
			var fa_icon = `<i class="fa `+sub_menu_close+`"></i>`;
			$('.wpha-menu-item-demo ul li ul li').prepend(fa_icon);

		}


		$('.wpha-menu-item-demo ul li').find('img').remove();

		if(wpha_is_image(menu_close) && menu_close_img){
			
			var img = `<img src='`+menu_close_img+`' />`;
			$('.wpha-menu-item-demo ul:first > li').prepend(img);


		}


		$('.wpha-menu-item-demo ul li ul li').parents('li').find('img').remove();

		if(wpha_is_image(menu_open) && menu_open_img){
			// style_menu_close[''] = '';
			var img = `<img src='`+menu_open_img+`'/>`;

			$('.wpha-menu-item-demo ul li ul li').parents('li').prepend(img);


		}



		if(wpha_is_image(sub_menu_close) && sub_menu_close_img){
			// style_menu_close[''] = '';
			var img = `<img src='`+sub_menu_close_img+`'/>`;
			$('.wpha-menu-item-demo ul li ul li').prepend(img);

		}

			
        $('.wpha-menu-item-demo ul li').css(style_menu_close);
        $('.wpha-menu-item-demo ul li ul li').css(style_sub_menu);
        $('.wpha-menu-item-demo ul li ul li').parents('li:first').css(style_menu_open);

        // $('.wpha-menu-item-demo ul li').prepend('<i class="fa fa-bars" style=""></i>');


    }

    var wpha_customization = wpha_object.wpha_customization;
    wpha_init_demo(wpha_customization);

    $('form#wpha_customization_form input[type="color"], form#wpha_customization_form input[type="text"], form#wpha_customization_form input[type="hidden"]').on('change', function(){

      

        var input_name = $(this).prop('name');

        input_name = input_name.replace('wpha-customization[', '');
        input_name = input_name.replace(']', '');


        wpha_customization[input_name] = $(this).val();
        wpha_init_demo(wpha_customization);

    });



	//media settings

	if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
		$('body').on('click','.wpha_img_bullet, .wpha_background_img_selection',  function(e) {
			
			if(wpha_object.is_pro=="1"){
	
				var this_img = $(this);
				
	
				wp.media.editor.send.attachment = function(props, attachment) {
	
					
						this_img.next('input:first').val(attachment.url);
						this_img.next('input:first').change();
						this_img.prop('src', attachment.url);						
						
	
				};
				wp.media.editor.open($(this));
			}else{
				alert(wpha_object.premium_feature);
			}
			//return false;
		});

	}


	function wpha_init_config_li(){
	
		if($('.wpha_config_menu > li ul').length > 0){
		
			$('.wpha_config_menu > li ul').parents('li').css('cursor', 'pointer');
			$('.wpha_config_menu > li ul').css('cursor', 'default')
		
		}
	
	}

	wpha_init_config_li();

	
	$('body').on('click','.wpha_config_menu > li.menu-item-has-children > span.title', function(){
		
		// alert('hello');
		
		$('.wpha_config_menu > li ul').not($(this).parents('li:first').find('ul')).hide(300);
		$(this).parents('li:first').find('ul').toggle(300);
	
	});

	$('body').on('mouseover','.wpha_config_menu li span.title', function(){
	
	
	
	// $('.wpha_config_menu li span.input_wrapper').hide();
	//
	// $(this).siblings('span.input_wrapper').show();
	
	
	});

	var load_spinner = $('.wpha_config_men_container .spinner-border');
	var menu_ul = $('.wpha_config_men_container .menu_ul');
	
	$('select#wpha-menu').on('change', function(){
		
		var menu = $(this).val();
		
		var data = {
			
			action : 'wpha_load_selected_menu',
			nonce : wpha_object.nonce,
			wpha_selected_menu : menu ? menu : '0',
		
		}
		
		load_spinner.show();
		$.post(ajaxurl, data, function(response, code){
			
			load_spinner.hide();
			if(code == 'success' && response.status){
				
				menu_ul.html(response.html);
				wpha_init_config_li();
			
			}
		
		});
		
	
	
	});


	$('body').on('click','.wpha_reset_single_hover', function(){
		
		var menu = $('select#wpha-menu').val();
		var item_id = $(this).parents('li:first').data('id');
		
		var data = {
		
			action : 'wpha_load_selected_menu',
			nonce : wpha_object.nonce,
			wpha_selected_menu : menu ? menu : '0',
			wpha_reset_item_id :item_id,
		
		}
		
		load_spinner.show();
		$.post(ajaxurl, data, function(response, code){
		
			load_spinner.hide();
			
			if(code == 'success' && response.status){
				
				menu_ul.html(response.html);
				wpha_init_config_li();
			
			}
		
		});



	});
	
	$('body').on('click', '.wpha_config_men_container > div > h5', function(){
		$(this).parent().find('.wpha_config_menu').toggle();
		if($(this).hasClass('alert-success')){
			$(this).removeClass('alert-success').addClass('alert-secondary');
		}else{
			$(this).removeClass('alert-secondary').addClass('alert-success');
		}
	});
	
	$('#wpha_customization_form .form-group .wpha_option_reset').on('click', function(){
		$(this).parents().eq(0).find('input').val('');
		//console.log(wpha_object.default_bullet_img);
		if($(this).parents().eq(0).find('.wpha_img_bullet').length>0){
			$(this).parents().eq(0).find('.wpha_img_bullet').prop('src', wpha_object.default_bullet_img);
		}
	});
	
	
		
	var hover_check_li = $('#wpha_options_disable_hover').parents('li:first');
	var config_container = $('.wpha_config_men_container');
	
	/*
	$('select[name="wpha_options[skins]"]').on('change', function(){
	
		var this_val = $(this).val();
		
		if(this_val == 'default'){
		
		
			hover_check_li.hide();
			config_container.hide();
		
		
		}else if(this_val == 'elektro'){
		
		
			hover_check_li.show();
			config_container.show();
		
		}
		
	});
	*/
	
	/*
	$('#wpha_options_disable_hover').on('change', function(){
	
		if($(this).prop('checked')){
		
			config_container.hide();
		
		
		}else{
		
		
			config_container.show();
		
		}
	
	});
	*/
	
	$('select[name="wpha_options[skins]"]').change();
	$('#wpha_options_disable_hover').change();

	$('body').on('click, change', 'input[name^="wpha-configuration[hover_settings]"]', function(){
		var bg_color = $(this).parent().find('input[name*="[background_color]"][type="color"]').val();
		var fg_color = $(this).parent().find('input[name*="[foreground_color]"][type="color"]').val();
		var bg_image = $(this).parent().find('input[name*="[background_img]"][type="hidden"]').val();
		
		$('.wpha-hover-demo a').html($(this).parents().eq(1).find('.title').html()).css({'color':fg_color,'background-color':bg_color})
		
		if(bg_image){
			$('.wpha-hover-demo').css({'background-image':'url('+bg_image+')', 'background-repeat':'no-repeat'}).fadeIn();
		}else{
			$('.wpha-hover-demo').css({'background-color':bg_color}).fadeIn();
		}
	});
});