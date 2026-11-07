$(function() {
	if(uniJsVars.addit_image) {
		function uniAdditImage() {

			if(uni_touch_support || $(window).width() < 575) return;
			
			$('.product-thumb__image img').each(function () {
				if($(this).data('additional')) {
					let img = $(this),
						img_src = $(this).attr('src'),
						arr_items = $(this).data('additional').split('||'),
						parent_elem = img.parent(),
						html = '';
					
					if(typeof(img_src) == 'undefined') img_src = $(this).data('src');
					
					arr_items.unshift(img_src);
					
					img.data('additional', false)
					
					html += '<div class="product-thumb__addit">';
					html += '<div class="product-thumb__addit-wrap">';
				
					for(i in arr_items) {
						html += '<div class="product-thumb__addit-item" data-img="'+arr_items[i]+'"></div>';
					}
				
					html += '</div>';
				
					for(i in arr_items) {
						html += '<span class="product-thumb__addit-dot '+(i == 0 ? 'active' : '')+'"></span>';
					}
				
					html += '</div>';
					
					img.after(html);
				
					const item = parent_elem.find('.product-thumb__addit-item'),
						dot = parent_elem.find('.product-thumb__addit-dot');
				
					item.on('mouseenter', function(e) {
						img.attr('src', $(this).data('img'));
						dot.removeClass('active').eq($(this).index()).addClass('active');
					});
					
					/*
					item.on('touchmove', function(e) {
						var ev = e.originalEvent.changedTouches[0],
							el = document.elementFromPoint(ev.clientX, ev.clientY);
					
						img.attr('src', $(el).data('img'));
						dot.removeClass('active').eq($(el).index()).addClass('active');
					});
					*/
				
					parent_elem.on('mouseleave', () => {
						img.attr('src', img_src);
						dot.removeClass('active').first().addClass('active');
					});
				}
			});
		}
		
		//setTimeout(() => { 
			uniAdditImage();
		//}, 550);
		
		$(document).ajaxStop(uniAdditImage);
	}
});