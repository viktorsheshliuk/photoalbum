/* Cookie functions*/
function setCookie(name,value,days) {
	var expires;
	if (days) {
	var date = new Date();
	date.setTime(date.getTime()+(days*24*60*60*1000));
	expires = "; expires="+date.toGMTString();
	} else {
	expires = "";
	}
	document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
	var c = ca[i];
	while (c.charAt(0)==' ') c = c.substring(1,c.length);
	if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function deleteCookie(name) {
	setCookie(name,"",-1);
}

$(document).on('click', '#discount-special-window input.datepicker', function(){
	var field = $(this);
	if(field.length > 0){
		if(typeof(field.data('dp')) === 'undefined'){
			if(field.val() == '') {
				var d = new Date();
				field.val(moment(d).format(field.data('date-format')));
			}
			field.datetimepicker({pickTime: false}).data("DateTimePicker").show();
			field.data('dp', 1);
		}
	}
});

$(document).on('click', '#discount-special-window input.datepicker', function(){
	var field = $(this);
	if(field.length > 0){
		if(typeof(field.data('dp')) === 'undefined'){
			if(field.val() == '') {
				var d = new Date();
				field.val(moment(d).format(field.data('date-format')));
			}
			field.datetimepicker({pickTime: false}).data("DateTimePicker").show();
			field.data('dp', 1);
		}
	}
});

$(document).on('click', '#product-extra-wrapper tbody td input.datepicker', function(){
	var field = $(this);
	if(field.length > 0){
		if(typeof(field.data('dp')) === 'undefined'){
			field.datetimepicker({pickTime: false}).data("DateTimePicker").show();
			field.data('dp', 1);
		}
	}
});


$.extend({
	getUrlVars: function(){
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for(var i = 0; i < hashes.length; i++)
	{
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
	},
	getUrlVar: function(name){
	return $.getUrlVars()[name];
	}
});

if($.getUrlVar('route') == 'catalog/product'){
	var l = window.location.toString();
	var newL = l.replace('catalog/product', 'extension/product_extra');
	/*
	if(getCookie('remove-auto-redirect') != 1){
	window.location = newL;
	}
	*/
}
if($.getUrlVar('iframed') == 1){
	//$('script[src="view/javascript/product_extra.js"]').append('<div class="test"></div>');
	$('head').append('<link rel="stylesheet" href="view/stylesheet/product_extra.css" type="text/css" />');
}

$(document).ready(function($) {
	$(document).on({
		focusin: function(){
			$(this).parents('td').addClass('editable');
		},
		focusout: function(){
			$(this).parents('td').removeClass('editable');
		}
	}, '#product-extra-wrapper tbody td :input');

	/**
	 * Settings
	 */
	$('#product-extra-wrapper .settings-button').popover({
		content: function(){return $('.settings-box').html()},
		placement: 'bottom',
		html: true
	});

	/* Category interface */
	$(document).on('click', '#product-extra-wrapper tr.product-row td.categories', function(e){
		var cCell = $(this).children().get(0);
		if(typeof($(cCell).data('popovered')) === 'undefined'){
			if(typeof($('body').data('categoryCell')) !== 'undefined'){
				$('body').data('categoryCell').popover('destroy');
				$('body').data('categoryCell').removeData('popovered');
				$('body').removeData('categoryCell');
			}
			$(cCell).popover({
				container: 'body',
				html: true,
				content: function(){
					var select = $('tr.filter td.category-column select').clone();
					var ul = $(cCell).children().get(0);
					//remove first element
					$(select.children().get(0)).html("-- Select None --");

					// Create container with close button
					var container = $('<div class="category-popover-container" style="position:relative;padding-top:25px;"></div>');
					var closeBtn = $('<button type="button" class="close popover-close" aria-label="Close" style="position:absolute;top:0;right:0;z-index:10;">&times;</button>');
					
					closeBtn.on('click', function(e){
						e.stopPropagation();
						var cell = $(cCell);
						cell.popover('destroy');
						cell.removeData('popovered');
						$('body').removeData('categoryCell');
					});
					
					container.append(closeBtn);
					
					
					$(select).on('change', function(){
						$.get(link, {type: 'change_category', category_id: $(this).val().join(','), product_id: $(cCell).parents('tr').attr('data-id')}, function(response){
							if(response == 'done'){
								$(ul).children().remove();
								$(select).find('option:selected').each(function(){
									if ($(this).val() != "*") {
										var li = $('<li></li>').append($(this).text()).addClass('cat-list').attr('data-id', $(this).attr('value'));
										$(ul).append(li);
									}
								});
							}
						});
					});
					//set values
					var selected = $(ul).find('li').map(function(){return Number($(this).attr("data-id"));}).get();
					$(select).prop('multiple', true).prop('size', 15).find('option:selected').prop('selected', false);
					$.each(selected, function(i, v){
						$(select).find('option[value="'+v+'"]').prop('selected', true);	
					});
					
					container.append(select);
					return container;
				}
			}).popover('show');
			$(cCell).data('popovered', true);
			$('body').data('categoryCell', $(cCell));
		} else {
			$('body').data('categoryCell').popover('destroy');
			$('body').data('categoryCell').removeData('popovered');
			$('body').removeData('categoryCell');
		}
		
	});
	/*
	if(getCookie('remove-auto-redirect') == 1){
		var productLink = $('#menu-catalog>ul>li>a[href*="catalog/product"]').clone();
		productLink.attr('href', productLink.attr('href').replace('route=catalog/product', 'route=extension/product_extra'));
		productLink.html('Product Manager');
		var productExtraLi = $('<li></li>').append(productLink)
		$('#menu-catalog>ul').append(productExtraLi);
	}
	*/
	//Product stores
	$(document).on('click', '#product-extra-wrapper td.stores a', function(e){
		e.preventDefault();
		var a = $(this);
		
		$.get($(this).attr('href'), function(){
			if(a.hasClass('included')){
			a.removeClass('included').addClass('excluded');
			} else {
			a.removeClass('excluded').addClass('included');
			}
			a.parents('td').addClass('updated');
			setTimeout(function(){a.parents('td').removeClass('updated');}, 1500);
		});
	});
	
	$(document).on('click', '#product-extra-wrapper td.status a', function(e){
		e.preventDefault();
		var a = $(this);
		
		$.get($(this).attr('href'), function(){
			if(a.hasClass('included')){
			a.removeClass('included').addClass('excluded');
			a.html($('span.disabled').html());
			} else {
			a.removeClass('excluded').addClass('included');
			a.html($('span.enabled').html());
			}
			a.parents('td').addClass('updated');
			setTimeout(function(){a.parents('td').removeClass('updated');}, 1500);
		});
	});
	$(document).on('click', '#product-extra-wrapper td.subtract a', function(e){
		e.preventDefault();
		var a = $(this);
		
		$.get($(this).attr('href'), function(){
			if(a.hasClass('included')){
			a.removeClass('included').addClass('excluded');
			a.html($('span.no').html());
			} else {
			a.removeClass('excluded').addClass('included');
			a.html($('span.yes').html());
			}
			a.parents('td').addClass('updated');
			setTimeout(function(){a.parents('td').removeClass('updated');}, 1500);
		});
	});
	$(document).on('focusout', '#product-extra-wrapper td.product-model input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&model='+encodeURIComponent(input.val()), function(result){
				//input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	$(document).on('click', '#product-extra-wrapper td.product-name', function(){
		var wrapper = $(this).find('.product-name-wrapper');
		wrapper.hide();
		wrapper.next().show();
		wrapper.next().focus();
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.product-name input', function(){
		var input = $(this);
		var td = input.parents('td');
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&name='+encodeURIComponent(input.val()), function(result){
				//input.val(result);
				input.attr('orig', result);
				td.addClass('updated');
				input.prev().html(result);
				input.prev().show();
				input.hide();
				setTimeout(function(){td.removeClass('updated');}, 1500);
			});
		}
	});

	$(document).on('click', '#product-extra-wrapper td.product-meta-title', function(){
		var wrapper = $(this).find('.product-meta-title-wrapper');
		wrapper.hide();
		wrapper.next().show();
		wrapper.next().focus();
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.product-meta-title input', function(){
		var input = $(this);
		var td = input.parents('td');
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&meta_title='+encodeURIComponent(input.val()), function(result){
				//input.val(result);
				input.attr('orig', result);
				td.addClass('updated');
				input.prev().html(result);
				input.prev().show();
				input.hide();
				setTimeout(function(){td.removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.quantity input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&quantity='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.weight input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&weight='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.sku input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&sku='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});

	$(document).on('focusout', '#product-extra-wrapper td.upc input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&upc='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.location input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&location='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	$(document).on('focusout', '#product-extra-wrapper td.date_available input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&date_available='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});

	$(document).on('focusout', '#product-extra-wrapper td.seo input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&seo='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.length input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&length='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.width input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&width='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.height input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&height='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('keyup', '#product-extra-wrapper td.quantity input', function(){
		$(this).removeClass();
		if($(this).val() <= 0){
			$(this).addClass('red');
		} else if ($(this).val() <= 5){
			$(this).addClass('yellow');
		} else {
			$(this).addClass('green');
		}
	});
	
	$(document).on('focusout', '#product-extra-wrapper input.product-price-field', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&price='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.sort_order input', function(){
		var input = $(this);
		if(input.prop('value') != input.attr('orig')){
			$.get(input.attr('rel')+'&sort_order='+input.val(), function(result){
				input.val(result);
				input.attr('orig', result);
				input.parents('td').addClass('updated');
				setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);
			});
		}
	});
	
	$(document).on('click', '#product-extra-wrapper td a.edit_desc_link', function(e){
		e.preventDefault();
		var tr = $(this).parents('tr');
		var product_id = tr.find('input:checkbox').val();
		var myinstances = [];
		var descriptions = tr.find('textarea.descriptions');
		var j=0;
		for(var i in CKEDITOR.instances) {
			CKEDITOR.instances[i].setData($(descriptions[j]).val());
			j++;
		}
		$('#description-popup').data('row', tr);
		$('#description-product-id').val(product_id);
		$('#description-popup').dialog('option', 'title', tr.find('.product-name-wrapper').html()).dialog('open');
	});
	
	$(document).on('click', '#product-extra-wrapper button.product-save', function(e){
		var trigger = $(this);
		e.preventDefault();
		//Store the WYSIWYG into textareas
		var form = $('#editor iframe').contents().find('form');
		/*form.find('textarea').each(function(){
			if($(this).code() != ''){
				$(this).val($(this).code());
			}
		});*/
		$.post($(this).attr('data-url'), $('#editor iframe').contents().find('form').serialize(), function(data){
			if(data == "OK"){
				trigger.removeClass('btn-primary').addClass('btn-warning').prepend('<i class="fa fa-floppy-o"></i> ');
				if(trigger.attr('data-new') === false){
					reloadRow(formUrl);
				} else {
					ajaxified($('#form-product-extra').attr('current'));
				}
				setTimeout(function(){
					trigger.removeClass('btn-warning').addClass('btn-primary');
					trigger.find('i').remove();
				}, 1500);
			} else {
				trigger.removeClass('btn-primary').addClass('btn-danger');
				setTimeout(function(){
					trigger.removeClass('btn-danger').addClass('btn-primary');
				}, 3500);
			}
		});
	});
	$(document).on('click', '#product-extra-wrapper a.edit_link, #product-extra-wrapper a.default-product, #product-extra-wrapper a.insert-product', function(e){
		var isNew = false;
		if(getCookie('popup-edit') != 1){
			return true;
		}
		var rowTd = $(this).parents('tr');
		if($(this).hasClass('insert-product')){ //New product. Update the table instead of product.
			isNew = true;
		}
		//var languagesCount = rowTd.find('textarea.descriptions').length; //Used because every ckediror adds another iframe.
		e.preventDefault();
		formUrl = $(this).attr('href');
		formUrl = formUrl.replace('catalog/product', 'extension/product_extra');
		
		if($('#editor').length > 0){
			//$('#editor').dialog("destroy");
			$('#editor').remove();
		}

		$('#content').prepend('<div id="editor" class="modal" tabindex="-1" role="dialog" style="padding: 3px 0px 0px 0px;"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-body" style="height: 600px;"><iframe src="'+$(this).attr('href')+'&iframed=1" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary product-save" data-url="'+formUrl+'" data-new="'+isNew+'">Save changes</button></div></div>');
		if(getCookie('editorWidth') === null){
			setCookie('editorWidth', 950);
		}
		if(getCookie('editorHeight') === null){
			setCookie('editorHeight', 550);
		}
		$('#editor').modal({}).modal('show');

		/*$('#editor').dialog({
			title: 'Product Manager',
			buttons: {
				"Save": function() {
					var inst;
					//Patch for saving CKedit textareas
					if(typeof(window.frames[languagesCount].CKEDITOR) !== 'undefined'){
						for ( inst in window.frames[languagesCount].CKEDITOR.instances ){
							window.frames[languagesCount].CKEDITOR.instances[inst].updateElement();
						}
					} else {
						//Chrome fix
						instance = $('#editor iframe');
						w = instance[0].contentWindow;
						for ( inst in w.CKEDITOR.instances ){
							w.CKEDITOR.instances[inst].updateElement();
						}
					}
				
					$.post(formUrl, $('#editor iframe').contents().find('form').serialize(), function(data){
						if(data == "OK"){
							$('#editor').dialog({title:'<span style="color:red">Saved</span>'});
							if(isNew === false){
								reloadRow(formUrl);
							} else {
								ajaxified($('#form-product-extra').attr('current'));
							}
							setTimeout(function(){
								$('#editor').dialog({title:"Product Manager"});
							}, 1500);
						} else {
							$('#editor').dialog({title:'<span style="color:red">Error. Cannot save data.</span>'});
							setTimeout(function(){
								$('#editor').dialog({title:"Product Manager"});
							}, 3500);
						}
					});
				},
				"Close": function(){
					$(this).dialog("close"); $(this).remove();
				}
			},
			close: function(){
				$(this).remove();
			},
			resizeStop: function( event, ui ) {
				setCookie('editorWidth', $(this).dialog( "option", "width" ), 365);
				setCookie('editorHeight', $(this).dialog( "option", "height" ), 365);
			},
			bgiframe: false,
			width: Number(getCookie('editorWidth')),
			height: Number(getCookie('editorHeight')),
			resizable: true,
			modal: true
		});*/
			
		var reloadRow = function(url){
			url = url.replace('update', 'ajaxify');
			$.get(url, function(data){
				rowTd.html(data);
			});
		};
	});
	if($('#form-product-extra').length > 0){
		//Changing main image
		$(document).on('click', '#modal-image a.thumbnail', function(e){
			$('#modal-image').data('trigger').next().trigger('change');
		});
	}
	
	$(document).on('click', '#product-extra-wrapper a[data-toggle=\'main-image\']', function(e){
		e.preventDefault();
		var trigger = $(this);
		$('#modal-image').remove();
		$.ajax({
			url: 'index.php?route=common/filemanager',
			data: {user_token: token, target: $(this).next().attr('id'), thumb: $(this).attr('id')},
			dataType: 'html',
			success: function(html) {
				$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
				$('#modal-image').modal('show');
				$('#modal-image').data('trigger', trigger);
			}
		});
	});
	$(document).on('change', '#product-extra-wrapper .image-wrapper input[name="image"]', function(e){
		var td = $(this).parents('td');
		td.addClass('updated');
		$.get($(this).attr('rel'), {image: $(this).val(), product_id: $(this).attr('data-id')}, function(){
			setTimeout(function(){td.removeClass('updated');}, 1500);
		});
	});
	$(document).on('click', '#product-extra-wrapper .image-wrapper .remove', function(e){
		e.preventDefault();
		if(!confirm('Are you sure?')){
			return false;
		}
		//console.log($(this).prev().prev().find('img').prop('data-placeholder'));
		$(this).prev().prev().find('img').prop('src', $(this).prev().prev().find('img').attr('data-placeholder'));
		$(this).prev().val('');
		$(this).prev().trigger('change');
	});
	
	$(document).on('change', '#product-extra-wrapper input.switcher', function(){
		if($(this).is(':checked') === true){
			$('.'+$(this).attr('name')).removeClass('hide-column');
			setCookie($(this).attr('name'), 1, 365);
		} else {
			$('.'+$(this).attr('name')).addClass('hide-column');
			deleteCookie($(this).attr('name'));
		}
	});
	
	var columnStates = function(){
		var active_columns = [];
		$('#product-extra-wrapper input.switcher').each(function(){
			if(getCookie($(this).attr('name')) == 1){
				$(this).attr('checked', true);
			} else {
				$(this).attr('checked', false);
			}
			if($(this).is(':checked') === true){
				$('.'+$(this).attr('name')).removeClass('hide-column');
			} else {
				$('.'+$(this).attr('name')).addClass('hide-column');
			}
		});
	};
	
	var initCookies = function(){
		$('#product-extra-wrapper input.switcher').each(function(){
		setCookie($(this).attr('name'), 1, 365);
		});
		setCookie('show-column-checkboxes', 1, 365);
		$('#product-extra-wrapper .column-switcher').removeClass('hide-column');
	};
		
	if(getCookie('show-column-checkboxes') >= 1){
		columnStates();
	} else {
		initCookies();
	}
	
	if(getCookie('show-column-checkboxes') == 1){
		$('.column-switcher').show();
	} else {
		$('.column-switcher').hide();
	}
	
	$(document).on('click', '#product-extra-wrapper .columns-button', function(e){
		e.preventDefault();
		if(getCookie('show-column-checkboxes') == 1){
			$('.column-switcher').hide();
			setCookie('show-column-checkboxes', 2, 365);
		} else {
			$('.column-switcher').show();
			setCookie('show-column-checkboxes', 1, 365);
		}
	});
	/*$(document).on('click', '.settings-button', function(e){
		e.preventDefault();
		$('.settings-box').dialog({
			title:'Settings'
		});
	});*/
//Manufacturer
	$(document).on('click', '#product-extra-wrapper td.product-manufacturer', function(){
		if($(this).find('select').length === 0){
			var manufacturerSelect = $('.filter select[name="filter_manufacturer"]').clone();
			$(this).attr('mname', $(this).html());
			$(this).html('');
			manufacturerSelect.val($(this).attr('rel'));
			$(this).append(manufacturerSelect);
		}
	});
	
	$(document).on('change', '#product-extra-wrapper td.product-manufacturer select', function(){
		var td = $(this).parents('td');
		var tds = $(this).parents('tr').children('td');
		var product_id = $(tds[0]).find('input').val();
		$.get(td.attr('loc')+'&manufacturer_id='+$(this).val(), function(){
			td.addClass('updated');
			setTimeout(function(){td.removeClass('updated');}, 1500);
		});
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.product-manufacturer select', function(){
		var td = $(this).parents('td');
		var text = $(this).find('option:selected').text();
		var id = $(this).find('option:selected').val();
		td.attr('rel', id);
		td.html(text);
	});
//Weight Class
	$(document).on('click', '#product-extra-wrapper td.weight-class', function(){
		if($(this).find('select').length === 0){
			var weightSelect = $('.filter select[name="filter_weight_class"]').clone();
			$(this).attr('mname', $(this).html());
			$(this).html('');
			weightSelect.val($(this).attr('rel'));
			$(this).append(weightSelect);
		}
	});
	
	$(document).on('change', '#product-extra-wrapper td.weight-class select', function(){
		var td = $(this).parents('td');
		var tds = $(this).parents('tr').children('td');
		var product_id = $(tds[0]).find('input').val();
		$.get(td.attr('loc')+'&weight_class_id='+$(this).val(), function(){
			td.addClass('updated');
			setTimeout(function(){td.removeClass('updated');}, 1500);
		});
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.weight-class select', function(){
		var td = $(this).parents('td');
		var text = $(this).find('option:selected').text();
		var id = $(this).find('option:selected').val();
		td.attr('rel', id);
		td.html(text);
	});
//Tax class
	$(document).on('click', '#product-extra-wrapper td.tax-class', function(){
		if($(this).find('select').length === 0){
			var taxClassSelect = $('.filter select[name="filter_tax_class"]').clone();
			$(this).attr('mname', $(this).html());
			$(this).html('');
			taxClassSelect.val($(this).attr('rel'));
			$(this).append(taxClassSelect);
		}
	});
	
	$(document).on('change', '#product-extra-wrapper td.tax-class select', function(){
		var td = $(this).parents('td');
		var tds = $(this).parents('tr').children('td');
		var product_id = $(tds[0]).find('input').val();
		$.get(td.attr('loc')+'&tax_class_id='+$(this).val(), function(){
			td.addClass('updated');
			setTimeout(function(){td.removeClass('updated');}, 1500);
		});
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.tax-class select', function(){
		var td = $(this).parents('td');
		var text = $(this).find('option:selected').text();
		var id = $(this).find('option:selected').val();
		td.attr('rel', id);
		td.html(text);
	});
//Stock Status
	$(document).on('click', '#product-extra-wrapper td.stock-status', function(){
		if($(this).find('select').length === 0){
			var stockStatusSelect = $('.filter select[name="filter_stock_status"]').clone();
			$(this).attr('mname', $(this).html());
			$(this).html('');
			stockStatusSelect.val($(this).attr('rel'));
			$(this).append(stockStatusSelect);
		}
	});
	
	$(document).on('change', '#product-extra-wrapper td.stock-status select', function(){
		var td = $(this).parents('td');
		var tds = $(this).parents('tr').children('td');
		var product_id = $(tds[0]).find('input').val();
		$.get(td.attr('loc')+'&stock_status_id='+$(this).val(), function(){
			td.addClass('updated');
			setTimeout(function(){td.removeClass('updated');}, 1500);
		});
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.stock-status select', function(){
		var td = $(this).parents('td');
		var text = $(this).find('option:selected').text();
		var id = $(this).find('option:selected').val();
		td.attr('rel', id);
		td.html(text);
	});
	
//Length class
	$(document).on('click', '#product-extra-wrapper td.length-class', function(){
		if($(this).find('select').length === 0){
			var lengthClassSelect = $('.filter select[name="filter_length_class"]').clone();
			$(this).attr('mname', $(this).html());
			$(this).html('');
			lengthClassSelect.val($(this).attr('rel'));
			$(this).append(lengthClassSelect);
		}
	});
	
	$(document).on('change', '#product-extra-wrapper td.length-class select', function(){
		var td = $(this).parents('td');
		var tds = $(this).parents('tr').children('td');
		var product_id = $(tds[0]).find('input').val();
		$.get(td.attr('loc')+'&length_class_id='+$(this).val(), function(){
			td.addClass('updated');
			setTimeout(function(){td.removeClass('updated');}, 1500);
		});
	});
	
	$(document).on('focusout', '#product-extra-wrapper td.length-class select', function(){
		var td = $(this).parents('td');
		var text = $(this).find('option:selected').text();
		var id = $(this).find('option:selected').val();
		td.attr('rel', id);
		td.html(text);
	});
	
	$(document).on('click', '#product-extra-wrapper ul.language-selection a', function(e){
		e.preventDefault();
		var trigger = $(this);
		var link = removeParam('ajaxed', $('#form-product-extra').attr('current'));
		link = removeParam('type', link);
		link = removeParam('language', link);
		var url = link+'&type=change_language&language='+$(this).attr('data-id');
		;
		location.href = url;
		/*$('#form-product-extra').load(url, function(e){
			trigger.parents('ul').prev().find('#selected-language').text(trigger.attr('data-code'));
		});*/
	})
	
	/**
	 * Handling ajax sort & pagination
	 */
	$(document).on('click', '#form-product-extra thead td a', function(e){
		e.preventDefault();
		ajaxified($(this).attr('href'));
	});
	
	$(document).on('submit', '#form-product-extra', function(e){
		$.post($(this).attr('action'), $(this).serialize(), function(response){
			ajaxified($('#form-product-extra').attr('current'));
		});
		return false;
	});
	
	$(document).on('change', '#rows-per-page', function(e){
		var base_url = removeParam('ajaxed', $('#form-product-extra').attr('current'))+'&rows='+$(this).val();
		location.href = base_url;
		$('#form-product-extra').attr('current', base_url);
		//ajaxified($('#form-product-extra').attr('current')+'&rows='+$(this).val());
		return false;
	});

	$(document).on('click', '#bulk_remove', function(e){
	  //var ul = $(cCell).children().get(0);
      var products_id = [];
   	  $('#form-product-extra').find('input[name="selected[]"]:checked').each(function() {
        products_id.push($(this).val());
    	});
   	  var new_category_id = $('select[name="filter_category_for_bulk_remove"]').val();
   	  if ((new_category_id =='*')||(products_id.length == 0)) {alert('Выберите категорию и товары для переноса !');return;}
   	   
   	  products_id.forEach(function(elem,index){
   	 	  $.get(link, {type: 'change_category', category_id: new_category_id, product_id: elem}, function(response){
							if(response == 'done'){
								filter();
								//$(ul).children().remove();
								//$(select).find('option:selected').each(function(){
								//	if ($(this).val() != "*") {
									//	var li = $('<li></li>').append($(this).text()).addClass('cat-list').attr('data-id', $(this).attr('value'));
								//		$(ul).append(li);
									//}
								//});
							}
						});
	   });
	});

	/**
	 * prevent status change of default product
	 */
	
	if($('#product-extra-wrapper #form').length > 0){
		if(typeof($('#form')) !== 'undefined' && typeof($('#form').attr('action')) !== 'undefined' && $('#form').attr('action').indexOf('product_id=-1') != -1){
			$('#form').find('select[name="status"]').parents('tr').hide();
		}
	}
	
	/**
	 * return ability to see original product list
	 */
	
});

var ajaxified = function(requestUrl){
	if(requestUrl.toString().indexOf('?') != -1){
	requestUrl += '&ajaxed=1';
	} else {
	requestUrl += '?ajaxed=1';
	}
	$('#form-product-extra').load(requestUrl, function(){
		$('#form-product-extra').trigger('product-extra-reload');
	});
	$('#form-product-extra').attr('current', requestUrl);
};

function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}