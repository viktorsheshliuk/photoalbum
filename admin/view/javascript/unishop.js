var this_url = window.location.search.split('&'), token = this_url[1];

for(i in this_url) {
	if(this_url[i].indexOf('user_token')+1) {
		token = this_url[i];
	}
}

$(function() {
	
	$('#module .col-sm-10 .nav').each(function() {
		$(this).find('li:first:not(.m) a').tab('show');
	});
	
	$('.uni-color').each(function() {
		$(this).css('background', '#'+$(this).val());
		
		var bg = $(this).css('background-color').replace(/[^\d,]/g, '').split(',');

		if(bg[0] > 125 && bg[1] > 125 && bg[2] > 125) {
			$(this).css('color', '#000');
		} else {
			$(this).css('color', '#fff');
		}
	});
	
	set_color('#tab-header');
	
	$('.nav-stacked li a').on('click', function() {
		var id = $(this).attr('href');
		set_color(id);
	});
	
	if($(window).width() > 767) {
		$('.nav-pills li').not('.new').on('click', function() {
			var destination = $('.nav-pills').offset().top-60;
			$('html, body').animate({scrollTop: destination}, 400);
		});
	}
		
	var adm_new_stick = $('input[name="uni_set[adm_new_stick]"]');
		
	if(adm_new_stick.prop('checked')) {
		$('.nav-tabs > li a span').show();
	}
		
	adm_new_stick.on('change', function() {
		if($(this).prop('checked')) {
			$('.nav-tabs > li a span').show();
		} else {
			$('.nav-tabs > li a span').hide();
		}
	});
		
	$(window).scroll(function() {	
		if($(this).scrollTop()>100) {
			if(!$('.scroll_button').length) {
				$('body').append('<div class="scroll_button"></div>');
				$('.btns').clone().appendTo('.scroll_button');
				$('[data-toggle=\'tooltip\']').tooltip({container:'body', placement:'bottom'});
			}
		} else {
			$('.scroll_button').remove();
		}
	});	
		
	$('input[name="uni_set[save_date]"]').val(Date.now());
	
	$('.container-fluid_new > .nav a').on('click', function(e) {
		e.preventDefault();
	
		if (confirm(uni_text_alert)) {
			location = $(this).attr('href');
		}
	});
	
	if($('.uni-alert').length) {
		$('.btns .btn-success').attr('disabled', true);
	}
	
	$('body').on('click', '.btns button', () => {
		saveSet();
	})
	
	uniFindSettings.init();
	
	$('#content .nav li a').each(function() {
		$(this).addClass($(this).attr('href').replace('#', ''));
	});
	
	$(window).scroll(() => {
		if($('.tooltip').length) $('.tooltip').remove();
	});
	
	$.get('index.php?route=design/theme/history&'+token, function(data) {
		if($(data).find('tbody td').text('unishop2').length > 1) {
			$('.container-fluid_new').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+uni_text_error_design+' <a href="index.php?route=design/theme&'+token+'" target="_blank" style="text-decoration:underline">'+uni_text_error_design_link+'</a></div>');
		}
	});
	
	$('body').on('click', '.phones-is-second', function() {
		$(this).closest('table').find('.phones-is-second').not($(this)).find('input').prop('checked', false).attr('checked', false);
	});
	
	$('#column-left').append('<div class="show-column-left"><i class="fa fa-chevron-left"></i><i class="fa fa-chevron-right"></i></div>');
	
	$('.show-column-left').on('click', function() {
		$(this).toggleClass('active');
		$('#column-left').toggleClass('active');
	});
	
	$('body').on('click', '.landinglinks-category', function() {
								
		const $this = $(this);
							
		$this.autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=extension/module/uni_category_wall_v2/autocomplete&'+token+'&filter_name='+encodeURIComponent(request)+'&max_level=1&no_child=1',
					dataType: 'json',
					success: function(json) {
						response($.map(json, (item) => {
							return {
								label: item['name'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				const category_id = item['value'];
									
				$this.data('cat-id', category_id).attr('name', 'uni_set[menu][landinglinks]['+category_id+']').val(item['label']);
				
				$this.parent().find('.ll-text').each(function() {
					$(this).attr('name', 'uni_set[menu][landinglinks]['+category_id+']['+$(this).data('key')+'][text]['+$(this).data('lang-id')+']');
				});
				
				$this.parent().find('.ll-link').each(function() {
					$(this).attr('name', 'uni_set[menu][landinglinks]['+category_id+']['+$(this).data('key')+'][link]['+$(this).data('lang-id')+']');
				});
				
				$this.parent().find('.ll-sort').each(function() {
					$(this).attr('name', 'uni_set[menu][landinglinks]['+category_id+']['+$(this).data('key')+'][sort_order]');
				});
			}
		});
	});
	
	$('body').on('click', '.textblock-category', function() {
								
		const $this = $(this);
							
		$this.autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=extension/module/uni_category_wall_v2/autocomplete&'+token+'&filter_name='+encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, (item) => {
							return {
								label: item['name'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				const category_id = item['value'];
									
				$this.attr('name', 'uni_set[product][textblock]['+category_id+']').val(item['label']);
				
				$this.parent().find('input[type="checkbox"]').attr('name', 'uni_set[product][textblock]['+category_id+'][quickorder]');
				
				$this.parent().find('textarea').each(function() {
					$(this).attr('name', 'uni_set[product][textblock]['+category_id+'][text]['+$(this).data('lang-id')+']');
				});
			}
		});
	});
});
	
	let s_url = 'index.php?route=extension/module/uni_settings/save&'+token, s_data = $('#unishop input, #unishop textarea, #unishop select').serialize();
	
	function set_color(data) {
		$(data+' .uni-color').colorpicker({
			format:'hex',
			hexNumberSignPrefix:false
		}).on('changeColor', function(e) {
			$(this).css('background-color', e.color.toString('hex'));
		   
			var bg = e.color.toRGB();

			if(bg['r'] > 125 && bg['g'] > 125 && bg['b'] > 125) {
				$(this).css('color', '#000');
			} else {
				$(this).css('color', '#fff');
			}
		});
	}
	
	function img_or_ico(id, type) {
		if(type == 'img') {
			$('.'+id).find('.img').addClass('selected');
			$('.'+id).find('.ico').removeClass('selected');
		} else {
			$('.'+id).find('.img').removeClass('selected');
			$('.'+id).find('.ico').addClass('selected');
		}
	}
	
	function popup_icons(id) {
		$('.fontawesome-icon-list').load('index.php?route=extension/module/uni_settings/getIconBlock&'+token, function() {
			$('#modal-icons-form').modal('show');
		
			$('#modal-icons-form i').on('click', function() {
				var this_class = $(this).attr('class');
			
				$('#'+id).find('i').attr('class', this_class);
				$('#'+id).next().val(this_class);
			
				$('#modal-icons-form').modal('hide');
			});
		});
	}
	
	function addHeaderLinks(lang_id, data) {
		var headerlinks_num = $('#tab-header #headerlinks-'+lang_id+' .input-group').length+1;

		html = '<div class="input-group">';
		html += '<input type="text" name="uni_set['+lang_id+'][headerlinks]['+headerlinks_num+'][title]" value="" placeholder="'+uni_text_title+' #'+headerlinks_num+'" class="form-control" />';
		html += '<input type="text" name="uni_set['+lang_id+'][headerlinks]['+headerlinks_num+'][link]" value="" placeholder="'+uni_text_link+' #'+headerlinks_num+'" class="form-control" />';
		html += '<span class="btn-default" onclick="$(this).parent().next().remove(); $(this).parent().remove();" title="'+uni_text_delete+'"><i class="fa fa-close"></i></span>';
		html += '</div>';
		html += '<div class="infolink">';
		html += '<a onclick="$(this).toggleClass(\'show\');">'+uni_text_article_link+' <i class="fa fa-caret-down"></i></a>';
		html += '<div>';
		html += data;
		html += '</div>';
		html += '</div>';
											
		$('#tab-header #headerlinks-'+lang_id+' > hr').before(html);
	}
	
	function addHeaderLinks2(lang_id, data) {
		var h2_num = $('#tab-additionalmenu .headerlinks2_'+lang_id+' td > .input-group').length+1;
															
		html  = '<tr class="headerlinks2-'+lang_id+'-'+h2_num+'">';
		html += '<td>';
		html += '<a onclick="img_or_ico($(this).parent().parent().attr(\'class\'), \'img\');" class="img selected">'+uni_text_img+'</a>';
		html += '<a onclick="img_or_ico($(this).parent().parent().attr(\'class\'), \'ico\');" class="ico">'+uni_text_icon+'</a>';
		html += '<div class="main-category-icon">';
		html += '<a href="" id="thumb-image-'+lang_id+'-headerlinks2-'+h2_num+'" data-toggle="image" class="img-thumbnail img selected">';
		html += '<img src="'+uni_img_placeholder+'" alt="" title="" data-placeholder="'+uni_img_placeholder+'" />';
		html += '</a>';
		html += '<a id="'+lang_id+'-t-l-'+h2_num+'" onclick="popup_icons($(this).attr(\'id\'))" class="ico">';
		html += '<i class="fa fa-plus-circle"></i>';
		html += '</a>';
		html += '<input type="hidden" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][icon]" value="" id="image-'+lang_id+'-headerlinks2-'+h2_num+'" />';
		html += '</div>';
		html += '<input type="hidden" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][icon_type]" value="img" class="form-control icon-type" />';
		html += '</td>';
		html += '<td>';
		html += '<div class="input-group">';
		html += '<input type="text" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][title]" value="" placeholder="'+uni_text_title+' #'+h2_num+'" class="form-control" />';
		html += '<input type="text" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][link]" value="" placeholder="'+uni_text_link+' #'+h2_num+'" class="form-control" />';
		html += '<span class="input-group-btn btn-default"onclick="$(this).parent().parent().parent().remove();" title="'+uni_text_delete+'"><i class="fa fa-close"></i></span>';
		html += '</div>';
		html += '<div class="infolink">';
		html += '<a onclick="$(this).toggleClass(\'show\');">'+uni_text_article_link+' <i class="fa fa-caret-down"></i></a>';
		html += '<div>';
		html += data;
		html += '</div>';
		html += '</div>';
		html += '<div class="submenu"></div>';
		html += '<a onclick="addHeaderLinks2Sub('+lang_id+', '+h2_num+', this);" title="Добавить ссылку второго уровня" data-toggle="tooltip" class="add-sub btn btn-success"><i class="fa fa-plus"></i></a>';
		html += '<div class="sort">';
		html += uni_text_sort+'<input type="text" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][sort_order]" value="1" class="form-control">';
		html += uni_text_column+'<input type="text" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][column]" value="1" class="form-control">';
		html += '</div>';
		html += '<label class="show-in-cat"><input type="checkbox" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][show_in_cat]" value="1"><span></span>Показывать в главном меню категорий</label>';
		html += '</div>';
		html += '</td>';
		html += '</tr>';

		$('#tab-additionalmenu .headerlinks2_'+lang_id).append(html);
	}
	
	function addHeaderLinks2Sub(lang_id, h2_num, data) {
		
		var elem = $(data), h2sub_num = elem.parent().find('.submenu').length+1;
		
		html  = '<div class="submenu">';
		html  += '<div class="input-group">';
		html  += '<i class="fas fa-level-up-alt"></i>';
		html  += '<input type="text" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][children]['+h2sub_num+'][name]" value="" placeholder="Заголовок #'+h2sub_num+'" class="form-control" />';
		html  += '<input type="text" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][children]['+h2sub_num+'][href]" value="" placeholder="Ссылка #'+h2sub_num+'" class="form-control" />';
		html  += '<span class="input-group-btn btn-default" onclick="$(this).parent().parent().remove();" title="'+uni_text_delete+'"><i class="fa fa-close"></i></span>';
		html  += '</div>';
		html  += '<a onclick="addHeaderLinks2Sub2('+lang_id+', '+h2_num+', '+h2sub_num+', this);" title="Добавить ссылку третьего уровня" data-toggle="tooltip" class="add-sub btn btn-info"><i class="fa fa-plus"></i></a>';
		html  += '</div>';
		
		elem.before(html);
		
		$('[data-toggle=\'tooltip\']').tooltip({container:'body', trigger:'hover'});
	}
	
	function addHeaderLinks2Sub2(lang_id, h2_num, h2sub_num, data) {
		
		var elem = $(data), h2sub2_num = elem.parent().find('.submenu2').length+1;
		
		html  = '<div class="submenu2">';
		html  += '<div class="input-group">';
		html  += '<i class="fas fa-level-up-alt"></i>';
		html  += '<input type="text" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][children]['+h2sub_num+'][children]['+h2sub2_num+'][name]" value="" placeholder="Заголовок #'+h2sub2_num+'" class="form-control" />';
		html  += '<input type="text" name="uni_set['+lang_id+'][headerlinks2]['+h2_num+'][children]['+h2sub_num+'][children]['+h2sub2_num+'][href]" value="" placeholder="Ссылка #'+h2sub2_num+'" class="form-control" />';
		html  += '<span class="input-group-btn btn-default" onclick="$(this).parent().parent().remove();" title="'+uni_text_delete+'"><i class="fa fa-close"></i></span>';
		html  += '</div>';
		html  += '</div>';
		
		elem.before(html);
		
		$('[data-toggle=\'tooltip\']').tooltip({container:'body', trigger:'hover'});
	}
	
	function addMainPhones(lang_id, data) {
		var mf_num = $('#tab-header .main-phone-'+lang_id+' .input-group').length+1;

		html  = '';
		html  += '<tr class="main-phone-icon-'+lang_id+'-'+mf_num+'">';
		html  += '<td>';
		html  += '<a onclick="img_or_ico($(this).parent().parent().attr(\'class\'), \'img\');" class="selected img">'+uni_text_img+'</a>';
		html  += '<a onclick="img_or_ico($(this).parent().parent().attr(\'class\'), \'ico\');" class="ico">'+uni_text_icon+'</a>';
		html  += '<div class="main-category-icon">';
		html  += '<a href="" id="thumb-image-'+lang_id+'-main-phone-icon-'+mf_num+'" data-toggle="image" class="img-thumbnail img selected">';
		html  += '<img src="'+uni_img_placeholder+'" alt="" title="" data-placeholder="'+uni_img_placeholder+'" />';
		html  += '</a>';
		html  += '<a id="'+lang_id+'-m-f-'+mf_num+'" onclick="popup_icons($(this).attr(\'id\'))" class="ico">';
		html  += '<i class="fa fa-plus-circle"></i>';
		html  += '</a>';
		html  += '<input type="hidden" name="uni_set[header][contacts][main]['+mf_num+'][icon]['+lang_id+']" value="" id="image-'+lang_id+'-main-phone-icon-'+mf_num+'" />';
		html  += '</div>';
		html  += '</td>';
		html  += '<td>';
		html  += '<div class="input-group">';
		html  += '<input type="text" name="uni_set[header][contacts][main]['+mf_num+'][text]['+lang_id+']" value="" placeholder="'+uni_text_mf_text+' #'+mf_num+'" class="form-control" style="width:140px" />';
		html  += '<input type="text" name="uni_set[header][contacts][main]['+mf_num+'][number]['+lang_id+']" value="" placeholder="'+uni_text_mf_number+' #'+mf_num+'" class="form-control" style="width:140px" />';
		html  += '<select name="uni_set[header][contacts][main]['+mf_num+'][type]['+lang_id+']" class="form-control" style="width:140px" >';
		html  += data;
		html  += '</select>';
		html  += '<span class="input-group-btn btn-default" onclick="$(this).parent().parent().parent().remove()" title="'+uni_text_delete+'"><i class="fa fa-close"></i></span>';
		html  += '</div>';
		html  += '<label class="phones-is-second"><input type="checkbox" name="uni_set[header][contacts][main]['+mf_num+'][is_second]['+lang_id+']" value="1" /><span></span>'+uni_text_contact_is_second+'</label>';
		html  += '<label><input type="checkbox" name="uni_set[header][contacts][main]['+mf_num+'][contact_page]['+lang_id+']" value="1" /><span></span>'+uni_text_contact_contact_page+'</label>';
		html  += '<br /><label style="margin:0 0 10px"><input type="checkbox" name="uni_set[header][contacts][main]['+mf_num+'][contact_page_as_text]['+lang_id+']" value="1" /><span></span>'+uni_text_contact_contact_page_as_text+'</label>';
		html  += '</td>';
		html  += '</tr>';

		$('#tab-header .main-phone-'+lang_id).append(html);
	}
	
	function addContacts(lang_id, data) {
		var c_num = $('#tab-header .additional-contacts-'+lang_id+' .input-group').length+1;
														
		html = '<tr class="additional-contacts-icon-'+lang_id+'-'+c_num+'">';
		html += '<td>';
		html += '<a onclick="img_or_ico($(this).parent().parent().attr(\'class\'), \'img\');" class="selected img">'+uni_text_img+'</a>';
		html += '<a onclick="img_or_ico($(this).parent().parent().attr(\'class\'), \'ico\');" class="ico">'+uni_text_icon+'</a>';
		html += '<div class="main-category-icon">';
		html += '<a href="" id="thumb-image-'+lang_id+'-contacts-icon-'+c_num+'" data-toggle="image" class="img-thumbnail img selected">';
		html += '<img src="'+uni_img_placeholder+'" alt="" title="" data-placeholder="'+uni_img_placeholder+'" />';
		html += '</a>';
		html += '<a id="'+lang_id+'-a-c-'+c_num+'" onclick="popup_icons($(this).attr(\'id\'))" class="ico">';
		html += '<i class="fa fa-plus-circle"></i>';
		html += '</a>';
		html += '<input type="hidden" name="uni_set[header][contacts][addit]['+c_num+'][icon]['+lang_id+']" value="" id="image-'+lang_id+'-contacts-icon-'+c_num+'" />';
		html += '</div>';
		html += '</td>';
		html += '<td>';
		html += '<div class="input-group">';
		html += '<input type="text" name="uni_set[header][contacts][addit]['+c_num+'][text]['+lang_id+']" value="" placeholder="'+uni_text_mf_text+' #'+c_num+'"  class="form-control" style="width:140px" />';
		html += '<input type="text" name="uni_set[header][contacts][addit]['+c_num+'][number]['+lang_id+']" value="" placeholder="'+uni_text_mf_number+' #'+c_num+'" class="form-control" style="width:140px" />';
		html += '<select name="uni_set[header][contacts][addit]['+c_num+'][type]['+lang_id+']" class="form-control header-call" style="width:140px">';
		html += data;
		html += '</select>';
		html += '<span class="input-group-btn btn-default" onclick="$(this).parent().parent().parent().remove()" title="'+uni_text_delete+'"><i class="fa fa-close"></i></span>';
		html += '</div>';
		html += '<label><input type="checkbox" name="uni_set[header][contacts][addit]['+c_num+'][contact_page]['+lang_id+']" value="1" /><span></span>'+uni_text_contact_contact_page+'</label>';
		html += '<label><input type="checkbox" name="uni_set[header][contacts][addit]['+c_num+'][contact_page_as_text]['+lang_id+']" value="1" /><span></span>'+uni_text_contact_contact_page_as_text+'</label>';
		html += '</td>';
		html += '</tr>';
		
		$('#tab-header .additional-contacts-'+lang_id).append(html);
	}
	
	function addFooterLinks(lang_id, data) {
		var f_links_num = $('#tab-footer #footerlinks-'+lang_id+' .input-group').length+1;
		
		html = '<div class="input-group">';
		html += '<input type="text" name="uni_set['+lang_id+'][footerlinks]['+f_links_num+'][title]" value="" placeholder="'+uni_text_title+' #'+f_links_num+'" class="form-control" />';
		html += '<input type="text" name="uni_set['+lang_id+'][footerlinks]['+f_links_num+'][link]" value="" placeholder="'+uni_text_link+' #'+f_links_num+'" class="form-control" />';
		html += '<select name="uni_set['+lang_id+'][footerlinks]['+f_links_num+'][column]" class="form-control">';
		html += data;
		html += '</select>';
		html += '<span class="btn-default" onclick="$(this).parent().remove()" title="'+uni_text_delete+'"><i class="fa fa-close"></i></span>';
		html += '</div>';
		
		f_links_num = f_links_num+1;
		
		$('#tab-footer #footerlinks-'+lang_id+' .add-before').before(html);
	}
	
	function addSocials(data) {
		var socials_num = $('#tab-footer .socials-icon .input-group').length+1;

		html = '<div class="input-group">';
		html += '<select name="uni_set[socials]['+socials_num+'][icon]" class="form-control">';
		html += data;
		html += '</select>';
		html += '<input type="text" name="uni_set[socials]['+socials_num+'][link]" value="" placeholder="'+uni_text_link+'" class="form-control" />';
		html += '<span class="btn-default" onclick="$(this).parent().remove()" title="'+uni_text_delete+'"><i class="fa fa-close"></i></span>';
		html += '</div>';
		
		socials_num = socials_num+1;
		
		$('#tab-footer .socials-icon').append(html);
	}
	
	function addProductBanner(lang_id) {
		var product_banner_num = $('#product-banners-'+lang_id+' .input-group').length+1;

		html = '<div>';
		html += '<div class="input-group">';
		html += '<span class="input-group-addon open_icon" id="'+lang_id+'_p_b_'+product_banner_num+'" onclick="popup_icons($(this).attr(\'id\'))">'+uni_text_icon+':<i class=""></i></span>';
		html += '<input type="hidden" name="uni_set['+lang_id+'][product_banners]['+product_banner_num+'][icon]" value="" class="form-control" />';
		html += '<input type="text" name="uni_set['+lang_id+'][product_banners]['+product_banner_num+'][text]" value="" placeholder="'+uni_text_mf_text+' #'+product_banner_num+'" class="form-control" />';
		html += '<input type="text" name="uni_set['+lang_id+'][product_banners]['+product_banner_num+'][link]" value="" placeholder="'+uni_text_link+' #'+product_banner_num+'" class="form-control" />';
		html += '<span class="btn-default" onclick="$(this).parent().parent().remove();" title="'+uni_text_delete+'"><i class="fa fa-close"></i></span>';
		html += '</div>';
		html += '<label><input type="checkbox" name="uni_set['+lang_id+'][product_banners]['+product_banner_num+'][link_popup]" value="1" /><span></span>'+uni_text_link_popup+'</label>';
		html += '<label style="margin:5px 0 10px 20px"><input type="checkbox" name="uni_set['+lang_id+'][product_banners]['+product_banner_num+'][hide]" value="1"><span></span> скрывать на маленьких экранах?</label>';
		html += '</div>';
			
		$('#product-banners-'+lang_id+' > hr').before(html);
	}
	
	function saveSet() {
		$('.note-editable').each(function() {
			$(this).closest('.tab-pane').find('textarea').html($(this).html());
		});
		
		$('.cke_wysiwyg_frame').each(function() {
			$(this).parent().parent().parent().prev().val($(this).contents().find('.cke_editable').html());
		});
		
		$('input[name="uni_set[save_date]"]').val(Date.now());
		
		let $btn = $('.btns button');
		
		$.ajax({
			url: s_url,
			type: 'post',
			data: $('#unishop input, #unishop textarea, #unishop select').serialize(),
			dataType: 'html',
			beforeSend: function() {
				$btn.html('<i class="fa fa-spinner"></i>');
			}, 
			success: function(data) {
				if(data == 'success') {
					$btn.html('<i class="fa fa-check"></i>');
					setTimeout(function() {
						$btn.html('<i class="fa fa-save"></i>');
					}, 1000);
				} else {
					$btn.html('<i class="fa fa-remove"></i>').data('original-title', uni_text_alert_validate).attr('class', 'btn btn-danger');
				}
				
				$.get('index.php?route=marketplace/modification/refresh&'+token, () => {
					$.get('index.php?route=catalog/review&'+token);
				});
			}
		});
	}
	
	uniFindSettings = {
		init:function() {
			var base = this;
			
			base.input = 'input[name="search-setting"]';
			base.item = '.find-settings__a';
			base.result = '.find-settings__result';
			base.separator = '🠒';
			base.area = '#unishop .nav, #unishop .col-sm-2';
			base.minlength = 3;
			base.timer;
			base.delay = 500;
			
			$(base.input).on('keyup', function() {
				base.keyUp();
			});
			
			$('html body').on('click', base.item, function() {
				base.itemClick(this);
			});
		},
		keyUp:function() {
			var base = this,
				html;
				
				base.phrase = $(base.input).val().trim();
		
			if (base.phrase.length >= base.minlength) {
		
				clearTimeout(base.timer);
			
				base.timer = setTimeout(function(){
		
					$(base.area).removeClass('description');
					
					base.mark_unmark(base.area, base.phrase);
					
					html = '<ul class="list-unstyled">';
					
					$('.highlight').each(function(){
				
						let $this = $(this),
							item_class = $this.parent().attr('class');
				
						if($this.closest('#unishop .col-sm-2').length) {
							item_class = $this.parent().parent().parent().attr('id')+' description';
					
							$this.closest('#unishop .col-sm-2').addClass(item_class);
						}
					
						let cc = $this.closest('.tab-pane').attr('id'),
							cc2 = $('#'+cc).parent().closest('.tab-pane').attr('id');
				
						$txt_0 = $('#unishop a.'+cc).text().replace('New', '');
						$txt_1 = $('#unishop a.'+cc2).text().replace('New', '');
				
						let $text = $this.parent();

							$text.find('span').remove();
				
							$txt_2 = $text.text().replace('New', '');
			
						if(!$this.closest('span').length) { 
							html += '<li>&#8226; <a class="find-settings__a" data-class="'+item_class+'">';
							html += $txt_1 ? $txt_1+' '+base.separator+' ' : '';
							html += $txt_0 ? $txt_0+' '+base.separator+' ' : '';
							html += $txt_2;
							html += '</a></li>';
						}
					});
					
					html += '</ul>';
			
					$(base.result).html(html);
			
					if($('.highlight').length) {
						$(base.result).show();
					} else {
						$(base.result).hide();
					}
					
				}, base.delay);
			} else {
				$(base.result).hide();
			}
		},
		itemClick:function(el) {
			var base = this;
			
			elem_class = $(el).data('class');
			
			txt_arr = $(el).text().split(base.separator);
			
			base.mark_unmark(base.area, txt_arr[txt_arr.length - 1]);
		
			if(elem_class.includes('description')) {
				elem_class = elem_class.replace('description', '');
			
				setTimeout(() => {
					$('html, body').animate({scrollTop: $('#unishop').find('.col-sm-2.'+elem_class).offset().top-50}, 400);
				}, 300);
			}
			
			$('#unishop .'+elem_class).click();
			$('#unishop .'+$('#unishop .'+elem_class).closest('.tab-pane').attr('id')).click();
		},
		mark_unmark:function(el, txt){
			var base = this;
			
			$(el).unhighlight({element:'mark', className:'highlight'}).highlight(txt.trim(), {element:'mark', className:'highlight'});
		},
		remove:function() {
			var base = this;
				
			$(base.input).val('');
			$(base.result).hide();
			$(base.area).unhighlight({element:'mark', className:'highlight'});
		}
	}
	
///////////////////
	
	function addLandingLinksItem(languages) {
		const key = 'new-' + $('.landinglinks > ul li').length;
											
		$('.landinglinks > ul').append('<li class="landinglinks-'+key+'"><a href="#landinglinks-'+key+'" style="text-decoration:none" data-toggle="tab">'+uni_text_landinglinkmenu_new_block+'</a></li>');
												
		html = '<div id="landinglinks-'+key+'" class="landinglinks__item tab-pane">';
		html += '<input type="text" name="uni_set[menu][landinglinks]['+key+']" value="" placeholder="'+uni_text_category_autocomplete+'" data-cat-id="'+key+'" class="landinglinks-category form-control" style="width:100% !important;max-width:1000px" />';
		html += '<br />';
		html += '<div class="landinglinks__btns">';
		html += '<button type="button" onclick="addLandingLinksItemLinks(this, languages);" title="" class="btn btn-success">'+uni_text_landinglinkmenu_add_link+'</button>';
		html += '<button type="button" onclick="removeLandingLinksItem(\''+key+'\')" class="btn btn-default">'+uni_text_landinglinkmenu_del_block+'</button>';
		html += '</div>';
		html += '</div>';
												
		$('.landinglinks > .tab-content').append(html);
		$('.landinglinks-'+key+' a').tab('show');
	}
	
	function addLandingLinksItemLinks(item, languages) {
		const elem = $(item).closest('.landinglinks__item');
												
		const cat_id = elem.find('.landinglinks-category').data('cat-id'), key = elem.find('.landinglinks__item-links').length;
												
		html = '<div class="landinglinks__item-links landinglinks__item-links-'+cat_id+'">';
		html += '<ul class="nav nav-tabs">';
		for (i in languages) {
			html += '<li><a href="#landinglinks-'+cat_id+'-'+key+'-'+languages[i]['language_id']+'" data-toggle="tab"><img src="language/'+languages[i]['code']+'/'+languages[i]['code']+'.png" title="'+languages[i]['name']+'" /></a></li>';
		}
		html += '</ul>';
		html += '<div class="tab-content">';
		for (i in languages) {
		html += '<div id="landinglinks-'+cat_id+'-'+key+'-'+languages[i]['language_id']+'" class="tab-pane">';
		html += '<div class="input-group">';
		html += '<input type="text" name="uni_set[menu][landinglinks]['+cat_id+']['+key+'][text]['+languages[i]['language_id']+']" value="" placeholder="'+uni_text_text+'" data-key="'+key+'" data-lang-id="'+languages[i]['language_id']+'" class="ll-text form-control" />';
		html += '<input type="text" name="uni_set[menu][landinglinks]['+cat_id+']['+key+'][link]['+languages[i]['language_id']+']" value="" placeholder="'+uni_text_link+'" data-key="'+key+'" data-lang-id="'+languages[i]['language_id']+'" class="ll-link form-control" />';
		html += '</div>';
		html += '</div>';
		}
		html += '</div>';
		html += '<div class="landinglinks__item-sort">';
		html += uni_text_headerlinks2_sort+'<input type="text" name="uni_set[menu][landinglinks]['+cat_id+']['+key+'][sort_order]" value="0" data-key="'+key+'" class="ll-sort form-control" />';
		html += '<button type="button" onclick="$(this).parent().parent().remove()" title="" class="add-sub btn btn-default">'+uni_button_remove+'</button>';
		html += '</div>';
		html += '</div>';
												
		$(item).parent().before(html)
												
		$('.landinglinks__item-links .nav-tabs').each(function() {
			$(this).find('li:first a').tab('show');
		});
	}
	
	function removeLandingLinksItem(id) {
		$('#landinglinks-'+id+', .landinglinks-'+id).remove();
												
		$('.landinglinks > .nav-tabs').each(function() {
			$(this).find('li:first a').tab('show');
		});
	}
	
	function addProductTextblock(languages) {
		const key = 'new-' + $('.textblock > ul li').length;
											
		$('.textblock > ul').append('<li class="textblock-'+key+'"><a href="#textblock-'+key+'" style="text-decoration:none" data-toggle="tab">'+uni_text_landinglinkmenu_new_block+'</a></li>');
												
		html = '<div id="textblock-'+key+'" class="tab-pane">';
		html += '<input type="text" name="uni_set[product][textblock]['+key+']" value="" placeholder="'+uni_text_category_autocomplete+'" class="textblock-category form-control" style="width:100%" />';
		html += '<br />';
		html += '<label><input type="checkbox" name="uni_set[product][textblock]['+key+'][quickorder]" value="1" /><span></span>'+uni_text_product_text_block_quickorder+'</label>';
		html += '<br /><br />';
		html += '<ul class="nav nav-tabs">';
		for (i in languages) {
			html += '<li><a href="#textblock-'+key+'-'+languages[i]['language_id']+'" data-toggle="tab"><img src="language/'+languages[i]['code']+'/'+languages[i]['code']+'.png" title="'+languages[i]['name']+'" /></a></li>';
		}
		html += '</ul>';
		html += '<div class="tab-content">';
		for (i in languages) {
			html += '<div id="textblock-'+key+'-'+languages[i]['language_id']+'" class="tab-pane">';
			html += '<textarea name="uni_set[product][textblock]['+key+'][text]['+languages[i]['language_id']+']" data-lang-id='+languages[i]['language_id']+' class="form-control"></textarea>';
			html += '</div>';
		}
		html += '</div>';
		html += '<br />';
		html += '<button type="button" onclick="removeProductTextblock(\''+key+'\')" class="btn btn-default">'+uni_button_remove+'</button>';
		html += '</div>';
												
		$('.textblock > .tab-content').append(html);
		$('.textblock-'+key+' a').tab('show');
		$('#textblock-'+key+' li:first a').tab('show');
	}
											
	function removeProductTextblock(id) {
		$('#textblock-'+id+', .textblock-'+id).remove();
												
		$('.textblock > .nav-tabs').each(function() {
			$(this).find('li:first a').tab('show');
		});
	}
	
	function addPickupItem(elem, languages) {
		
		let items = $('.checkout-pickup-item').length, html = '';
		
		html += '<div class="checkout-pickup-item checkout-pickup-item-'+items+'">';
		html += '<ul class="nav nav-tabs">';
		for (i in languages) {
			html += '<li><a href="#checkout_pickup_item-'+items+'-'+languages[i]['language_id']+'" data-toggle="tab"><img src="language/'+languages[i]['code']+'/'+languages[i]['code']+'.png" title="'+languages[i]['name']+'" /></a></li>';
		}
		html += '</ul>';
		html += '<div class="tab-content">';
		
		for (i in languages) {
			
			const lang_id = languages[i]['language_id'];
			
			html += '<div id="checkout_pickup_item-'+items+'-'+languages[i]['language_id']+'" class="tab-pane">';
			html += '<small>'+uni_text_pickup_title+'</small><br />';
			html += '<input type="text" name="uni_set[checkout][pickup][items]['+items+'][title]['+lang_id+']" value="" placeholder="" class="form-control" />';
			html += '<small>'+uni_text_pickup_address+'</small><br />';
			html += '<input type="text" name="uni_set[checkout][pickup][items]['+items+'][address]['+lang_id+']" value="" placeholder="" class="form-control" />';
			html += '<small>'+uni_text_pickup_time+'</small><br />';
			html += '<input type="text" name="uni_set[checkout][pickup][items]['+items+'][working_hours]['+lang_id+']" value="" placeholder="" class="form-control" />';
			html += '<small>'+uni_text_pickup_life+'</small><br />';
			html += '<input type="text" name="uni_set[checkout][pickup][items]['+items+'][shelf_life]['+lang_id+']" value="" placeholder="" class="form-control" />';
			html += '<small>'+uni_text_pickup_map+'</small><br />';
			html += '<textarea name="uni_set[checkout][pickup][items]['+items+'][map]['+lang_id+']" placeholder="" class="form-control"></textarea>';
			html += '</div>';
		}
										
		html += '</div>';
		html += '<button type="button" class="btn btn-xs btn-default" onclick="$(this).parent().remove()">'+uni_button_pickup_remove+'</button>';
		html += '<hr style="margin:15px 0" />';
		html += '</div>';
		
		$(elem).before(html);
		$('.checkout-pickup-item-'+items+' li:first a').tab('show');
	}
	
	function addTrial() {
		$('.container-fluid_new > .alert').remove();
			
		if (!$('#trial input[name=\'trial\']').is(':checked')) {
			$('.container-fluid_new').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+uni_text_error_agree+'</div>');
			return false;
		}
				
		$.ajax({
			url: 'index.php?route=extension/module/uni_settings/addTrial&'+token,
			type: 'post',
			dataType: 'json',
			beforeSend: function() {
				$('#trial .btn-primary').button('loading');
			}, 
			complete: function() {
				$('#trial .btn-primary').button('reset');
			},
			success: function(json) {
				if(json['success']) {
					$('#trial .btn-primary').remove();
					window.location.reload();
				} else {
					$('.container-fluid_new').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+uni_text_error_trial+'</div>');
				}
			}
		});
	}
	
	function addKey(data) {
		$('.container-fluid_new > .alert').remove();
	
		if ($(data).prev().val() == '') {
			$('.container-fluid_new').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+uni_text_error_key_empty+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			return false;
		}
				
		$.ajax({
			url:'index.php?route=extension/module/uni_settings/addKey&'+token,
			type:'post',
			data:$(data).prev().serialize(),
			dataType:'json',
			beforeSend:function() {
				$('#full .btn-primary').button('loading');
			}, 
			complete:function() {
				$('#full .btn-primary').button('reset');
			},
			success:function(json) {
				if(json['success']) {
					$('#full .btn-primary').remove();
					window.location.reload();
				} else {
					$('.container-fluid_new').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+uni_text_error_key+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
			}
		});
	}
	
	function addKey2() {
		$('.container-fluid_new > .alert').remove();
	
		$.ajax({
			url: 'index.php?route=extension/module/uni_settings/addKey2&'+token,
			dataType: 'json',
			beforeSend:function() {
				$('#full2 .btn-primary').button('loading');
			}, 
			complete:function() {
				$('#full2 .btn-primary').button('reset');
			},
			success: function(json) {
				if(json['success']) {
					$('.container-fluid_new').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> '+uni_text_full_key_added+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>')
				} else {
					$('.container-fluid_new').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+uni_text_error_key2+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
				
				$('html, body').animate({scrollTop: $('.container-fluid_new').offset().top-150}, 200);
			}
		});
	}