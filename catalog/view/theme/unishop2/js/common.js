//'use strict';

window.dataLayer = window.dataLayer || [];

var uni_touch_support;
	
if ('ontouchstart' in document.documentElement) uni_touch_support = true;

$(function() {
	if(uni_touch_support) $('body').addClass('touch-support');
	
	uniMenuAim();
	uniMenuDropdownPos();
	uniMenuMobile();
	uniSearch.init();
	
	$('#language li a').on('click', function(e) {
		e.preventDefault();
		$('#language input[name=\'code\']').val($(this).data('code'));
		$('#language').submit();
	});
	
	$('#currency li a').on('click', function(e) {
		e.preventDefault();
		$('#currency input[name=\'code\']').val($(this).data('code'));
		$('#currency').submit();
	});
	
	$('.header-phones__additional').on('click', function() {
		$('.header-phones__additional').addClass('selected').not($(this)).removeClass('selected');
		
		if($('.header-phones__main').text() == $(this).data('phone') && $(this).data('href')) {
			location = $(this).data('href');
		} else {
			$('.header-phones__main').text($(this).data('phone')).data('href', $(this).data('href'));
		}
	});
	
	$('[data-toggle=\'tooltip\']').tooltip({container:'body', trigger:'hover'});
	
	$('body').on('hide.bs.modal', '.modal.animated', function() {
		$(this).removeClass(uniJsVars.popup_effect_in).addClass(uniJsVars.popup_effect_out);
		$('body').css({'padding': ''});
	});
		
	$('body').on('hidden.bs.modal', '.modal.animated', (e) => {
		setTimeout(() => {
			e.target.remove();
		}, 200);
		
		$('html').removeClass('scroll-disabled');
		
		if($('body > .modal.fade.in').length) $('body').addClass('modal-open');
	});
	
	$('.add_to_cart.disabled:not(.fly-menu__product-btn)').each(function() {
		$(this).attr('disabled', true);
	});
	
	uniChangeBtn();
	
	$(document).ajaxStop(() => {	
		$('[data-toggle=\'tooltip\']').tooltip({container:'body', trigger:'hover'});
		
		$('.add_to_cart.disabled:not(.fly-menu__product-btn)').each(function(){
			$(this).attr('disabled', true);
		});
	});
	
	//quantity
	$('body').on('blur click', '.qty-switch__input, .qty-switch__btn', function(e) {
		let $elem = $(this);
		
		if($(this).hasClass('qty-switch__btn')) $elem = $(this).closest('.qty-switch').find('input');
		
		if($(this).hasClass('qty-switch__input') && e.type == 'click') return;
		
		let qty = parseFloat($elem.val()),
			min = $elem.data('minimum') ? parseFloat($elem.data('minimum')) : 1,
			max = 10000,
			step = uniJsVars.qty_switch_step ? min : 1,
			decimal = 0,
			new_qty;
		
		if($(this).hasClass('qty-switch__input')) {
			if(step > 1) qty = Math.round(qty/min)*min;
			
			//new_qty = (qty > min) && (qty < max) ? qty : min;
			new_qty = (qty > min) && (qty < max) ? qty : ((qty > max) ? max : min);
		} else {
			new_qty = $(this).hasClass('fa-plus') ? ((qty < max) ? qty+step : qty) : ((qty > min) ? qty-step : qty);
		}
		
		new_qty = new_qty.toFixed(decimal);
		
		$elem.val(new_qty).change();
		
		if($(this).closest('.checkout-cart__quantity, .header-cart__quantity').length) {
			cart.update($elem.data('cid'), new_qty);
		}
	});
	
	$('body').on('touchstart mouseenter', '.option__item', function(e) {
		let elem = $(this).find('img');
		
		if(!elem.length) return;
		
		let block = $('<div class="option__popup '+elem.data('type')+'"><img src="'+elem.data('thumb')+'" class="option__popup-img img-responsive" />'+elem.attr('alt')+'</div>'),
			imgSrc = elem.data('thumb'),
			elemTop = elem.offset().top,
			elemLeft = elem.offset().left+(elem.outerWidth()/2);
			
		$('.option__popup').remove()
		
		$('body').append(block);
		
		if(elemLeft < block.outerWidth()/2) {
			elemLeft = elem.offset().left;
		} else if(elemLeft + (block.outerWidth()/2) > $(window).width()) {
			elemLeft = elem.offset().left + elem.outerWidth() - block.outerWidth();
		} else {
			elemLeft = elemLeft - (block.outerWidth()/2);
		}

		setTimeout(() => {
			block.css({top: elemTop-block.outerHeight()-10, left: elemLeft}).addClass('show');
		}, 170);
		
		$(this).on('mouseleave', () => {
			block.remove();
		});
		
		$('body').on('touchstart', () => { 
			block.remove();     
		});
	});
	
	if(uniJsVars.change_opt_img) {
		$('main').on('click', '.product-thumb .option__item input', function() {
			$(this).closest('.product-thumb').find('a img:first').attr('src', $(this).next().data('thumb'));
		});
	}
	
	$('body').on('click', '.uni-href', function() {
		if(typeof($(this).data('href')) != 'undefined' && $(this).data('href') != '') {
			if(($(this).attr('target') || $(this).data('target')) == '_blank') {
				window.open($(this).data('href'), '_blank');
			} else {
				location = $(this).data('href');
			}
		}
	});
	
	//$('.breadcrumb').animate({scrollLeft: 1000}, 0);
	$('.breadcrumb').scrollLeft(1000);
	
	if(uniJsVars.unregisterSW && ('serviceWorker' in navigator)) {
		navigator.serviceWorker.getRegistrations().then(function(registrations) {
			for(let registration of registrations) {
				registration.unregister();
			}
		});
		
		caches.keys().then(function(cacheNames) {
			cacheNames.forEach(cacheName => {
				caches.delete(cacheName);
			});
		});
	}
});

const uniSearch = {
	init: function() {
		let base = this;
		
		$('body').on('click', '.header-search__category-li', function() {
			$(this).closest('.header-search').find('.header-search__category-span').text($(this).text());
			$(this).closest('.header-search').find('input[name=\'filter_category_id\']').val($(this).data('id'));
		});

		$('body').on('click', '.header-search__btn', function() {
			let url = $('base').attr('href') + 'index.php?route=product/search',
				elem = $(this).closest('.header-search'),
				elemInput = elem.find('input[name="search"]'),
				value = elem.find('input[name="search"]').val(), 
				filter_category_id = elem.find('input[name=\'filter_category_id\']').val();
				
			if(!value) value = elemInput.attr('placeholder');
			if (value) url += '&search='+encodeURIComponent(value);
			if (filter_category_id > 0) url += '&category_id='+encodeURIComponent(filter_category_id)+'&sub_category=true';
			url += '&description=true';
		
			window.location = url;
		});

		$('body').on('keydown', '.header-search__input', function(e) {
			if (e.keyCode == 13) $(this).parent().find('.header-search__btn').click();
		});
	
		if($(window).width() > 575 && uniJsVars.search_phrase_arr.length > 1) {
			new Typed('.header-search__input', {
				strings: uniJsVars.search_phrase_arr,
				startDelay: 1500,
				typeSpeed: 80,
				backDelay: 1500,
				backSpeed: 45,
				attr: 'placeholder',
				bindInputFocusEvents: true,
				loop: true
			});
		}
		
		base.clearBtn();
	},
	clearBtn: function() {
		const input = 'input[name="search"]', btn_class = '.search-btn-clear';
	
		$(input).each(function() {
			$(this).on('input', () => {
				$(input).not($(this)).val($(this).val());
			
				if($(this).val() != '') {
					$(btn_class).addClass('show');
				} else {
					$(btn_class).removeClass('show');
				}
			});
		});
	
		$('body').on('click', btn_class, () => {
			$(input).val('');
			$(btn_class).removeClass('show');
		});
	}
};

var uniSelectView = {
	init:function(viewtype){
		var base = this;
		
		base.display = localStorage.getItem('display') ? localStorage.getItem('display') : default_view;
		base.displayMFP = localStorage.getItem('displayMFP');
		
		if(typeof(MegaFilter) === 'function' && base.displayMFP) base.display = base.displayMFP;
		if(typeof(viewtype) != 'undefined') base.display = viewtype;
		
		base.bind();
		base.switcher();
	},
	switcher:function() {
		var base = this, lastWindowWidth = $(window).width(), breakpoint = 992;
		
		base.switcher2 = (new_width) => {
			base.displayMobile = localStorage.getItem('displayMobile') ? localStorage.getItem('displayMobile') : default_mobile_view;
			
			if(!$('.products-block').length) return;
			
			let disp = (new_width <= breakpoint) ? base.displayMobile : base.display;
			
			if (disp == 'list') {
				base.list();
			} else if (disp == 'grid')  {
				base.grid();
			} else {
				base.compact();
			}
		}
			
		base.switcher2(lastWindowWidth);
			
		$(window).resize(function(){
			if($(this).width() != lastWindowWidth && $(this).width() >= breakpoint){
				base.switcher2($(this).width());
			}
		});
	},
	list:function() {
		var base = this, breakpoint = 992, product_layout = $('.product-layout'), new_class = 'product-layout product-list list-view col-sm-12';
		
		if(!product_layout.first().attr('class').includes('list-view')) {
			$('.list-view, .grid-view, .compact-view, .product-grid, .product-list, .product-compact').attr('class', new_class);
			product_layout.find('.product-thumb__name, .product-thumb__description, .product-thumb__option').height('auto');
			
			$.post('index.php?route=extension/module/uni_new_data/setDefaultView', {view: 'list'});
		}
		
		$('.sorts-block__btn').addClass('selected').not('#list-view').removeClass('selected');
		
		localStorage.setItem('display', 'list');
		localStorage.setItem('displayMFP', 'list');
		if($(window).width() <= breakpoint) localStorage.setItem('displayMobile', 'list');
	},
	grid:function() {
		var base = this, breakpoint = 992, col_left = $('#column-left').length, col_right =  $('#column-right').length, product_layout = $('.product-layout'), new_class = 'product-layout product-grid grid-view col-sm-6 col-md-3 col-lg-3 col-xxl-4';

		if (col_left && col_right) {
			new_class = 'product-layout product-grid grid-view col-sm-12 col-md-6 col-lg-6 col-xxl-6-1';
		} else if (col_left || col_right) {
			new_class = 'product-layout product-grid grid-view col-sm-6 col-md-4 col-lg-4 col-xxl-5';
		}
		
		if(!product_layout.first().attr('class').includes('grid-view')) {
			$.post('index.php?route=extension/module/uni_new_data/setDefaultView', {view: 'grid'});
		}
		
		$('.list-view, .grid-view, .compact-view, .product-grid, .product-list, .product-compact').attr('class', new_class);
		
		$('.sorts-block__btn').addClass('selected').not('#grid-view').removeClass('selected');
		
		if($(window).width() > breakpoint ) {
			uniAutoHeight(product_layout.find('.product-thumb__name'));
			
			const arr = ['.grid-view .product-thumb__attribute', '.grid-view .product-thumb__description', '.grid-view .product-thumb__option'];
			
			for (i in arr) {
				if($(arr[i]).css('display') !== 'none' || uni_touch_support) {
					uniAutoHeight($(arr[i]));
				}
			}
		}
		
		localStorage.setItem('display', 'grid');
		localStorage.setItem('displayMFP', 'grid');
		if($(window).width() <= breakpoint) localStorage.setItem('displayMobile', 'grid');
	},
	compact:function() {
		var base = this, product_layout = $('.product-layout'), new_class = 'product-layout product-price compact-view col-sm-12';
		
		if(!product_layout.first().attr('class').includes('compact-view')) {
			$('.list-view, .grid-view, .compact-view, .product-grid, .product-list, .product-compact').attr('class', new_class);
			product_layout.find('.product-thumb__name, .product-thumb__description, .product-thumb__option').css('height', '');
			
			$.post('index.php?route=extension/module/uni_new_data/setDefaultView', {view: 'compact'});
		}
		
		$('.sorts-block__btn').addClass('selected').not('#compact-view').removeClass('selected');
		
		if(!product_layout.find('.product-thumb__option').children().length) {
			product_layout.find('.product-thumb__option').remove()
		}
		
		product_layout.find('.product-thumb__cart.disabled').css('min-width', product_layout.find('.product-thumb__cart').first().outerWidth());
	
		localStorage.setItem('display', 'compact');
		localStorage.setItem('displayMFP', 'compact');
	},
	bind:function() {
		var base = this;
		$('#list-view').on('click', base.list);
		$('#grid-view').on('click', base.grid);
		$('#compact-view').on('click', base.compact);
	}
};

function uniMenuAim() {
	if($(window).width() > 992) {
		let blur_blocks = $('main, footer'), items = '.menu__level-2', timer = '', delay = 0, delay2 = 150;
		
		$('.menu.menu2 li.has-children').on('mouseenter', function() {
			timer = setTimeout(() => { 
				changeState($(this), 1);
			}, delay);
		}).on('mouseleave', function() {
			clearTimeout(timer);
			changeState($(this), 0);
		});
		
		$('.menu.menu1 .menu__collapse').menuAim({
			rowSelector:'.menu__level-1-li',
			submenuSelector:'*',
			activate:function(data) {
				changeState($(data), 1);
			},
			deactivate:function(data) {
				changeState($(data), 0);
			},
			exitMenu:function(data) {
				if(!$(data).parent().hasClass('new')) {
					return true;
				}
			}
		});

		const changeState = (elem, state) => {
			const child = elem.children(items);
			
			if(child.css('display') == 'none') child.css('opacity', 0);
			
			$('.menu__level-1-li:first, .menu__level-1-li:first .menu__level-2').removeClass('open');
			
			if(state) {
				elem.addClass('open');
				child.addClass('open').animate({opacity: 1}, delay2);
			} else {
				elem.removeClass('open');
				child.removeClass('open');
			}
		};
		
		const menuBlur = () => {
			if(uni_touch_support || typeof(uniJsVars) == 'undefined' || !uniJsVars.menu_blur) return;
			
			let blur_delay = 110, blur_timer = '';
		
			$('.menu:not(.new)').on('mouseenter', () => {
				blur_timer = setTimeout(() => { 
					blur_blocks.addClass('blur');
				}, blur_delay);
			}).on('mouseleave', () => {
				clearTimeout(blur_timer);
				blur_blocks.removeClass('blur');
			});
			
			if($('.menu-wrapper.new').hasClass('show')) {
				blur_blocks.addClass('blur');
			} else {
				blur_blocks.removeClass('blur');
			}
		};
		
		menuBlur();
		
		const btn = '.header-menu__btn', wrapper = '.menu-wrapper.new', li = '.menu1.new .menu__level-1-li';
		
		if($(wrapper).length) {
			$(btn).unbind('click');
	
			$(btn).on('click', function() {
				$(this).toggleClass('show');
			
				changeState($(li).not(':first-child'), 0);
				changeState($(li).first(), 1);
			
				$(wrapper).toggleClass('show');
		
				menuBlur();
			});
		}
		
		$('main, footer').on('click touchstart', () => {
			$(items).removeClass('open');
			$('.menu__pm').removeClass('open');
			$('.menu .collapse').collapse('hide');
			
			$('html').removeClass('scroll-disabled');
			$('.menu-wrapper, .header-menu__btn').removeClass('show');
			
			blur_blocks.removeClass('blur');
		});
	} else {
		$('body').on('click', '.menu__pm', function() {
			$(this).toggleClass('open');
			$(this).next().collapse('toggle');
		});
	
		$('.menu-open, .menu-close').on('click', () => {
			$('html').toggleClass('scroll-disabled');
			$('.menu-wrapper').toggleClass('show');
			$('.fly-menu__block').removeClass('show');
		});
	}
};

function uniMenuUpd(block) {
	
	if(!$(block).length) return;
	
	const init = () => {
		let menu_block = $(block), menu_items = menu_block.children('.menu__level-1-li:not(.menu__additional)');
			
		menu_items.css('display', '');
			
		if($(window).width() < 992) return;
		
		menu_block.find('.menu__additional').remove();
		
		let coord = menu_block.offset().left + menu_block.width(), flag = false, new_items = '';
			
		if(!menu_items.length || Math.floor(menu_items.last().offset().left + menu_items.last().width()) <= coord) return;
		
		menu_items.each(function() {
			if($(this).offset().left + $(this).width() > coord - 60) {
				let item = $(this).find('> a'), item_child = $(this).find('.menu__level-2-a'), new_child_items = '';
				
				if(item_child.length) {
					new_child_items = '<div class="menu__level-3"><ul class="menu__level-3-ul">';
				
					item_child.each(function() {
						new_child_items += '<li class="menu__level-3-li"><a class="menu__level-3-a';
						
						if(typeof($(this).attr('href')) != 'undefined') {
							new_child_items += '" href="'+$(this).attr('href')+'">';
						} else {
							new_child_items += ' disabled">';
						}
						
						new_child_items += $(this).text()+'</a></li>';
					});
					
					new_child_items += '</ul></div>';
				}
				
				new_items += '<div class="menu__level-2-ul col-md-12"><a class="menu__level-2-a';
				
				if(new_child_items) {
					new_items += ' has-children';
				}
				
				if(typeof(item.attr('href')) != 'undefined') {
					new_items += '" href="'+item.attr('href')+'">';
				} else {
					new_items += ' disabled">';
				}

				new_items += item.text()+'</a>'+new_child_items+'</div>';

				$(this).hide();
				
				flag = true;
			} else {
				$(this).show();
			}
		});
		
		if (flag) {
			if (!menu_block.find('.menu__additional').length) {
				let html = '<li class="menu__level-1-li menu__additional has-children">';
				    html += '<a class="menu__level-1-a additional"><i class="fa fa-ellipsis-h"></i></a>';
				    html += '<div class="menu__level-2 column-1"></div>';
				    html += '</li>';
					
				menu_block.append(html);
				
				uniMenuAim();
			}
				
			menu_block.find('.menu__additional .menu__level-2').html(new_items);
		}
	}
	
	init();
	
	$(window).resize(init);
};

function uniMenuDropdownPos() {
	const menu_block = $('header .menu1:not(.new) .menu__level-2, header .menu2 .menu__level-2');
	
	if(!menu_block.length) return;
	
	const init = () => {
		if($(window).width() > 992) {
			menu_block.css('max-height', ($(window).height() - $('header .menu').offset().top - 50));
			
			const menu_block_2 = $('header .menu2');
			
			if(!menu_block_2.length) return;
			
			menu_block_2.find('.menu__level-2').each(function() {
				const child_pos = ($(this).parent().offset().left + $(this).outerWidth()) - (menu_block_2.offset().left + menu_block_2.outerWidth());
			
				if (child_pos > 0) $(this).css('margin-left', '-'+child_pos+'px');
			});
		} else {
			menu_block.css('max-height', '');
		}
	}
	
	init();
	
	$(window).resize(init);
};

function uniMenuMobile() {
	const menu1 = $('.menu1 .menu__collapse'), menu2 = $('.menu-right .menu__collapse');
		
	if(!menu1.length || !menu2.length) return;
	
	const init = () => {
		let windowWidth = $(window).width();
		
		if(windowWidth < 992) {
			menu2.find('>li').addClass('new-items').appendTo(menu1);
		} else {
			menu1.find('.new-items').removeClass('new-items').appendTo(menu2);
		}
		
		$windowWidth = windowWidth;
	}
	
	init();
	
	$(window).resize(() => {
		if ($(window).width() != $windowWidth) {
			init();
		}
	});
}

function uniBannerLink(url) {
	$.ajax({
		url: url,
		type: 'get',
		dataType: 'html',
		success: function(data) {
			var data = $(data);
			
			title = data.find('h1.heading').text();
			data.find('h1.heading').remove();
			text = data.find('#content').html();
			
			uniModalWindow('modal-banner', 'lg', title, text);
		}
	});
}

function form_error(form, input, text) {
	let element = $(form+' input[name=\''+input+'\'], '+form+' textarea[name=\''+input+'\'], '+form+' select[name=\''+input+'\']').addClass('input-warning');
	
	setTimeout(() => { 
		$(form+' .input-warning').removeClass('input-warning');
	}, 15000);
	
	$(form+' .input-warning').click(function() {
		$(this).removeClass('input-warning');
	});
}

function uniScrollTo(target, time) {
	if (typeof(time) === 'undefined') time = 200;
	$('html, body').animate({scrollTop: $(target).offset().top-150}, time);
}

function uniChangeBtn() {
	const cart = () => {
		let products = $('.header-cart__wrapper').data('products');
		
		if(typeof(products) === 'undefined') return;
		
		products = String(products).split(',').map(Number);
		
		$('.product-thumb__add-to-cart, .product-page__add-to-cart, .compare-page__cart').each(function() {
			if(products.indexOf($(this).data('pid')) !== -1) {
				$(this).addClass('in_cart');
				$(this).children('i').attr('class', uniJsVars.cart_btn.icon_incart);
				$(this).children('span').text(uniJsVars.cart_btn.text_incart);
			}
		});
	}
	
	const compare = () => {
		let products = $('.top-menu__compare').data('products');
		
		if(!products) return;
		
		products = String(products).split(',').map(Number);
		
		$('.product-thumb__compare, .product-page__compare-btn').each(function() {
			const pid = Number($(this).attr('onclick').replace(/\D+/g,''));
			
			if(products.indexOf(pid) !== -1) {
				$(this).attr('onclick', $(this).attr('onclick').replace('compare.add', 'compare.remove')).attr('title', uniJsVars.compare_btn.text_remove).addClass('active');
			}
		});
	}
	
	const wishlist = () => {
		let products = $('.top-menu__wishlist').data('products');
		
		if(!products) return;
		
		products = String(products).split(',').map(Number);
		
		$('.product-thumb__wishlist, .product-page__wishlist-btn').each(function() {
			const pid = Number($(this).attr('onclick').replace(/\D+/g,''));
			
			if(products.indexOf(pid) !== -1) {
				$(this).attr('onclick', $(this).attr('onclick').replace('wishlist.add', 'wishlist.remove')).attr('title', uniJsVars.wishlist_btn.text_remove).addClass('active');
			}
		});
	}
	
	cart();
	compare();
	wishlist();
	
	$(document).ajaxStop(() => {
		cart();
		compare();
		wishlist();
	});
}

function uniModalWindow(id, type, title, data) {
	
	/* 	id = id modal form;	type = sm, lg, or empty; title = title modal form; data = text or other data modal form; */
	
	$('#'+id).remove();
				
	let html  = '<div id="'+id+'" class="modal '+uniJsVars.popup_effect_in+'">';
		html += '<div class="modal-dialog modal-'+type+'">';
		html += '<div class="modal-content">';
		html += '<div class="modal-header">';
		html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
		html += '<h4 class="modal-title">'+title+'</h4>';
		html += '</div>';
		html += '<div class="modal-body">'+data+'</div>';
		html += '</div>';
		html += '</div>';
		html += '</div>';
	
	$('html body').append(html);
	$('#'+id).modal('show');
}

function uniAutoHeight(div) {
	const block_height = () => {
		$(div).css({height: ''});
		
		let maxheight = 0;
		
		$(div).each(function(){
			if($(this).height() > maxheight) {
				maxheight = $(this).height();
			}
		});
		
		if(maxheight > 0) $(div).height(maxheight);
	};
	
	block_height();
	$(window).resize(block_height);
}

function uniFlyAlert(type, data) {
	let time = 15,
		effectIn = 'animated bounceInRight',
		effectOut = 'animated bounceOutRight';
	
	if(typeof(uniJsVars) != 'undefined') {
		time = uniJsVars.alert_time;
		effectIn = uniJsVars.alert_effect_in;
		effectOut = uniJsVars.alert_effect_out;
	}
	
	let time1 = time*1000,
		time2 = time1+1000,
		time3 = 100,
		top_offset = 50,
		top_margin = 15,
		icon;
	
	if(type == 'success') icon = 'fa-check-circle';
	//if(type == 'danger') icon = 'fa-times-circle';
	if(type == 'danger') icon = 'fa-exclamation-circle';
	if(type == 'warning') icon = 'fa-exclamation-circle';
	
	$('.uni-alert').remove();
	
	let createAlert = (data) => {
		if($('.uni-alert').length) {
			top_offset = $('.uni-alert:last').position().top + $('.uni-alert:last').outerHeight() + top_margin;
		}
	
		let block = $('<div class="uni-alert alert-'+type+' '+effectIn+'" style="top:'+top_offset+'px"><i class="uni-alert__icon fa '+icon+'"></i><div>'+data+'</div></div>');
	
		$('html body').append(block);
	
		setTimeout(() => {
			block.removeClass(effectIn).addClass(effectOut);
		}, time1);
	
		setTimeout(() => {
			block.remove();
		}, time2);
	}
	
	if(typeof(data) == 'object') {
		let arr = [];
	
		for (i in data) {
			arr.push(data[i]);
		}
	
		let index = -1,
			timer = setInterval(() => {
			if (++index == arr.length) {
				clearInterval(timer);
			} else {
				createAlert(arr[index]);
			}
		}, time3);
	} else {
		createAlert(data);
	}
}

//add css and js from script
var cssUrls = [], jsUrls = [];

function uniAddCss(url) {
	if(cssUrls.indexOf(url) == -1) {
		cssUrls.push(url);
		$('html head').append('<link href="'+url+'" type="text/css" rel="stylesheet" media="screen" />')
	}
}

function uniAddJs(url) {
	if(jsUrls.indexOf(url) == -1) {
		jsUrls.push(url);
		$.getScript(url);
	}
}

(function($){
	var Modules = {
		init:function(options, el) {
            var base = this;
			
			base.$elem = $(el);
			base.$elem2 = $(el).children();
			base.options = $.extend({}, $.fn.uniModules.options, options);
			
			base.load();
        },
		load:function() {
			var base = this;
			
			base.wrapper = (base.$elem2.closest('.tab-content').length) ? base.$elem2.closest('.tab-content') : base.$elem;
			
			if((base.options.type == 'grid' && module_on_mobile == 'carousel' && base.wrapper.width()+20 < 768) || base.wrapper.closest('#column-left, #column-right').length) {
				base.options.type = 'carousel';
			}
			
			if(base.wrapper.closest('#column-left, #column-right').length) {
				base.options.items = {0: {items: 1}};
			}
			
			if (base.options.type == 'grid') {
				base.$elem2.children().wrap('<div class="uni-module__item" style="width:'+base.items()+'"></div>');
			} else {
				base.$elem2.addClass('owl-carousel').owlCarousel({
					responsive:base.options.items,
					responsiveBaseElement:base.wrapper,
					dots:base.options.dots,
					mouseDrag:false,
					loop:base.options.loop,
					autoplay:base.options.autoplay,
					nav:true,
					navText:['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
				});
				
				if(base.$elem2.width() == 0) {
					const item = base.$elem2.find('.owl-item'), item_width = base.items();
					
					item.css({width: item_width});
					base.$elem2.find('.owl-stage').css({width:item.length * item_width});
				}
			}
			
			base.update();
			base.reload();
			base.responsive();
		},
		items:function() {
			var base = this, match = -1, width = base.wrapper.width();
			
			width += (base.wrapper.attr('class') == 'tab-content' && width < 520) ? 10 : 20;
			
			$.each(base.options.items, (breakpoint) => {
				if (breakpoint <= width && breakpoint > match) {
					match = Number(breakpoint);
				}
			});
			
			const items = base.options.items[match]['items']
			
			return (base.options.type == 'carousel') ? width/items : 100/items+'%';
		},
		update:function() {
			var base = this, div_arr = base.options.autoheight;
			
			if($(window).width() < 575 && $('.'+div_arr[0]).closest('.product-thumb').length) {
				div_arr = [];
			}
			
			if(div_arr.length) {
				for (i in div_arr) {
					var maxheight = 0, $elem = base.$elem2.find('.'+div_arr[i]);
				
					if($elem.css('display') !== 'none' || uni_touch_support) {
						$elem.css('height', '');

						$.each($elem, function() {
							if($(this).height() > maxheight) {
								maxheight = $(this).height();
							}
						});
				
						if(maxheight > 0) $elem.height(maxheight);
					}
				}
			}
			
			base.$elem2.addClass('load-complete');
		},
		responsive:function() {
            var base = this, lastWindowWidth = $(window).width();
			
			base.resizer = () => {
                if ($(window).width() != lastWindowWidth || uni_touch_support) {
					if (base.options.type == 'grid') {	
						base.$elem2.children().css('width', base.items());
					}
					
					base.update();
                }
            };
			
			$(window).resize(base.resizer);
        },
		reload:function() {
			var base = this, div = base.$elem.parent(), modal = div.hasClass('modal-body') ? true : false, tab = div.hasClass('tab-pane') ? div.attr('id') : false;
			
			if(modal) {
				setTimeout(() => {
					base.update();
				}, 750);
			}
			
			if(tab) {
				div.parent().prev().find('li a').on('shown.bs.tab', function(e) {
					if($(this).attr('href') == '#'+tab) {
						base.update();
					}
				});
			}
		}
	};
	
	$.fn.uniModules = function(options) {		
		return this.each(function() {
            if ($(this).data('uni-modules-init') === true) {
                return false;
            }
			
            $(this).data('uni-modules-init', true);
			
            var module = Object.create(Modules);
            module.init(options, this);
        });
	};
	
	if(typeof(items_on_mobile) == 'undefined') items_on_mobile = 2;
	
	$.fn.uniModules.options = {
		type 	   :'carousel',
		items	   :{0:{items:items_on_mobile},700:{items:3},1050:{items:4},1400:{items:5}},
		autoheight :[],
		dots	   :true,
		loop	   :false,
		autoplay   :false
	};

	var Timer = {
		init:function(options, el) {
            var base = this;
			
			base.options = $.extend({}, $.fn.uniTimer.options, options);
			base.days = 24*60*60, base.hours = 60*60, base.minutes = 60;
			
			var date_arr = base.options.date.split('-'),
				year = parseFloat(date_arr[0]), 
				month = parseFloat(date_arr[1])-1, 
				day = parseFloat(date_arr[2]);
			
			base.$date = (new Date(year, month, day)).getTime();
			base.$elem = $(el);
			
			if(base.$date > (new Date()).getTime())	{
				base.load();
			}
        },
		load:function() {
			var base = this, i = 4;
			
			html = '<div class="uni-timer">';
			
			for(i in base.options.texts){
				html += '<div class="uni-timer__group g-'+i+'">';
				html += '<div class="uni-timer__digit"></div>';
				
				if(!base.options.hideText) html += '<div class="uni-timer__text">'+base.options.texts[i]+'</div>';
				
				html += '</div>';
			}
			
			html += '</div>';
			
			base.$elem.append(html);
			base.digits = base.$elem.find('.uni-timer__digit');
			base.count();
		},
		count:function() {
			var base = this, left, d, h, m, s;
			
			left = Math.floor((base.$date - (new Date()).getTime())/1000);
			
			left = left > 0 ? left : 0;
			
			d = Math.floor(left / base.days);
			left -= d*base.days;
			h = Math.floor(left / base.hours);
			left -= h*base.hours;
			m = Math.floor(left / base.minutes);
			left -= m*base.minutes;
			s = left;
			
			base.switchDigit(base.digits.eq(0), d);
			base.switchDigit(base.digits.eq(1), h);
			base.switchDigit(base.digits.eq(2), m);
			base.switchDigit(base.digits.eq(3), s);
			
			if (d == 0) base.hideGroup(0);
			if (h == 0) base.hideGroup(1);
			
			setTimeout(() => { 
				base.count();
			}, 1000);
		},
		switchDigit:function(position, number) {
			if(position.data('digit') != number){
				position.data('digit', number).text(number);
			}
		},
		hideGroup:function(num) {
			var base = this;
			
			if(base.options.hideIsNull) {
				base.$elem.find('.uni-timer__group.g-'+num).hide();
			}
		}
	}
	
	$.fn.uniTimer = function(options) {		
		return this.each(function() {
            if ($(this).data("uni-timer-init") === true) {
                return false;
            }
			
            $(this).data("uni-timer-init", true);
			
            var timer = Object.create(Timer);
            timer.init(options, this);
        });
	};
	
	$.fn.uniTimer.options = {
		date		:'0000-00-00',
		texts		:['Дней','Часов','Минут','Секунд'],
		hideText	:false,
		hideIsNull	:false
	};
})(jQuery);

var cart = {
	'add': function(product_id, elem) {
		
		var $elem = $(elem).closest('.product-thumb, .product-thumb-related'),
			product_qty = $elem.find('.qty-switch__input').val(), 
			product_options = $elem.find('.option input[type=\'text\'], .option input[type=\'hidden\'], .option input:checked, .option select, .option textarea'),
			data = 'product_id='+product_id+'&quantity='+(typeof(product_qty) != 'undefined' ? product_qty : 1);
			
		if (product_options.length) {
			data += '&'+product_options.serialize();
		}
		
		$.ajax({
			url: $('base').attr('href')+'index.php?route=checkout/cart/add',
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(json) {
				$('.text-danger').remove();
				
				if (json['redirect'] && (!$elem.find('.option').children().length || $elem.find('.option').css('display') == 'none')) {
					window.location = json['redirect'];
					
					return;
				}
				
				$('.form-group').removeClass('has-error');

				if (json['error']) {
					if (json['error']['option']) {
						for (i in json['error']['option']) {
							var elem = $('.option .input-option' + i.replace('_', '-')), elem2 = (elem.parent().hasClass('input-group')) ? elem.parent() : elem;
							
							elem2.after('<div class="text-danger">'+json['error']['option'][i]+'</div>');
							$('.option .text-danger').delay(5000).fadeOut();
							
							uniFlyAlert('danger', json['error']['option'][i])
						}
					}
				}

				if (json['success']) {
					
					cart.uniCartUpd();
					
					if(!$('#unicheckout').length) {
						if(!uniJsVars.cart_popup_disable) {
							uniModalWindow('modal-cart', '', uniJsVars.modal_cart.text_heading, $('header').find('.header-cart__dropdown').html());
						
							if(uniJsVars.cart_popup_autohide) {
								setTimeout(() => { 
									$('#modal-cart').modal('hide');
								}, uniJsVars.cart_popup_autohide_time * 1000);
							}
						}
					}
					
					dataLayer.push({
						'event': 'addToCart',
						'ecommerce':{
							'currencyCode':uniJsVars.currency.code,
							'add':{
								'products':[json['products']]
							}
						}
					});
					
					if (typeof(gtag) === 'function') {
						gtag('event', 'add_to_cart', {'items': [json['products']]});
					}
					
					if(uniJsVars.cart_btn.metric_id && uniJsVars.cart_btn.metric_target) {
						if (typeof(ym) === 'function') {
							ym(uniJsVars.cart_btn.metric_id, 'reachGoal', uniJsVars.cart_btn.metric_target);
						} else {
							new Function('yaCounter'+uniJsVars.cart_btn.metric_id+'.reachGoal(\''+uniJsVars.cart_btn.metric_target+'\')')();
						}
					}
					
					if(uniJsVars.cart_btn.analytic_category && uniJsVars.cart_btn.analytic_action) {
						if (typeof(gtag) === 'function') {
							gtag('event', uniJsVars.cart_btn.analytic_action, {'event_category': uniJsVars.cart_btn.analytic_category});
						} else if (typeof(ga) === 'function') {
							ga('send', 'event', uniJsVars.cart_btn.analytic_category, uniJsVars.cart_btn.analytic_action);
						}
					}
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	},
	'update': function(key, quantity, product_id) {
		$.ajax({
			url: $('base').attr('href')+'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'quantity['+key+']='+quantity,
			dataType: 'html',
			beforeSend: function() {
				if(!$('#unicheckout').length) {
					$('.header-cart__wrapper, .checkout-cart__wrap').append('<div class="preloader"></div>');
				}
			},
			success: function() {
				cart.uniCartUpd();
				
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					$('#content').load('index.php?route=checkout/cart #content > *');
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	},
	'remove': function(key, product_id) {
		$.ajax({
			url: $('base').attr('href')+'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key='+key,
			dataType: 'json',
			beforeSend: function() {
				if(!$('#unicheckout').length) {
					$('.header-cart__wrapper, .checkout-cart__wrap').append('<div class="preloader"></div>');
				}
			},
			success: function(json) {
				cart.uniCartUpd();

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					$('#content').load('index.php?route=checkout/cart #content > *');
				}
				
				$('.product-thumb__add-to-cart, .product-page__add-to-cart').each(function(){
					if(product_id == $(this).data('pid')) {
						$(this).removeClass('in_cart');
						$(this).children('i').attr('class', uniJsVars.cart_btn.icon);
						$(this).children('span').text(uniJsVars.cart_btn.text);
					}
				});
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	},
	'uniCartUpd': function() {
		$.get('index.php?route=common/cart/info', (data) => {
			$('.header-cart__dropdown').html($(data).find('.header-cart__dropdown').html());
			$('.header-cart__total-items, .fly-menu__cart-total').html($(data).find('.header-cart__total-items').text());
			
			$('#modal-cart').length && $('#modal-cart .modal-body').html($(data).find('.header-cart__dropdown').html());
		});
		
		typeof(uniDelPageCache) === 'function' && uniDelPageCache();
		  
		$('#unicheckout').length && uniCheckoutUpdate();
	}
}

var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: $('base').attr('href')+'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				if(!$('#unicheckout').length) {
					$('.header-cart__wrapper, .checkout-cart__wrap').append('<div class="preloader"></div>');
				}
			},
			success: function(json) {
				cart.uniCartUpd();

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					window.location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	}
}

var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: $('base').attr('href')+'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					window.location = json['redirect'];
				}

				if (json['success']) {
					if(json['success'].indexOf('account/login') !== -1) {
						uniFlyAlert('warning', json['success']);
					} else {
						uniFlyAlert('success', json['success']);
					}
					
					let wishlist_total = (json['success'].indexOf('account/login') == -1) ? json['total'].replace(/\s+/g, '').match(/(\d+)/g) : 0;
					
					wishlist.uniWishlistUpd(wishlist_total);
				}
			}
		});
	},
	'remove': function(product_id) {
		$.ajax({
			url: 'index.php?route=extension/module/uni_new_data/wishlistRemove',
			type: 'post',
			data: 'product_id='+product_id,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					uniFlyAlert('warning', json['success']);
					
					wishlist.uniWishlistUpd(json['total']);
					
					$('.product-thumb__wishlist, .product-page__wishlist-btn').each(function() {
						let pid = Number($(this).attr('onclick').replace(/\D+/g,''));
			
						if(product_id == pid) {
							$(this).attr('onclick', $(this).attr('onclick').replace('wishlist.remove', 'wishlist.add')).attr('title', uniJsVars.wishlist_btn.text).removeClass('active');
						}
					});
				}
			}
		});
	},
	'uniWishlistUpd': function(total){
		$('.fly-block__wishlist-total, .fly-menu__wishlist-total, .top-menu__wishlist-total, .header-wishlist__total-items').text(total);
		
		if (typeof(uniDelPageCache) === 'function') {
			uniDelPageCache();
		}
		
		$.get('index.php?route=account/wishlist', (data) => {
			$('.top-menu__wishlist').data('products', $(data).find('.top-menu__wishlist').data('products'));
		});
	}
}

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					uniFlyAlert('success', json['success']);
					
					$('#compare-total').html('<i class="compare-block__icon fas fa-align-right"></i>'+json['total']);
					
					let compare_total = json['total'].replace(/\s+/g, '').match(/(\d+)/g);
					
					compare.uniCompareUpd(compare_total);
				}
			}
		});
	},
	'remove': function(product_id) {
		$.ajax({
			url: 'index.php?route=extension/module/uni_new_data/compareRemove',
			type: 'post',
			data: 'product_id='+product_id,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					uniFlyAlert('warning', json['success']);
					
					compare.uniCompareUpd(json['total']);
					
					$('.product-thumb__compare, .product-page__compare-btn').each(function() {
						let pid = Number($(this).attr('onclick').replace(/\D+/g,''));
			
						if(product_id == pid) {
							$(this).attr('onclick', $(this).attr('onclick').replace('compare.remove', 'compare.add')).attr('title', uniJsVars.compare_btn.text).removeClass('active');
						}
					});
				}
			}
		});
	},
	'uniCompareUpd': function(total){
		$('.fly-block__compare-total, .fly-menu__compare-total, .top-menu__compare-total, .header-compare__total-items').text(total);
		
		if (typeof(uniDelPageCache) === 'function') {
			uniDelPageCache();
		}
		
		$.get('index.php?route=product/compare', (data) => {
			$('.top-menu__compare').data('products', $(data).find('.top-menu__compare').data('products'));
		});
	}
}

$(document).on('click', '.agree', function(e) {
	e.preventDefault();
	
	var element = this;

	$.ajax({
		url: $(element).attr('href'),
		type: 'get',
		dataType: 'html',
		success: function(data) {
			uniModalWindow('modal-agree', 'lg', $(element).text(), data);
		}
	});
});

function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			$(this).on('focus', function() {
				this.request();
			});

			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			this.show = function() {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			}

			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}

			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			this.response = function(json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}

					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			}

			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

		});
	}
})(window.jQuery);