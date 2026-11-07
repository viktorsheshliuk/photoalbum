//Autocomplete for shipping addresses
						(function ($) {
							var methods = {
								init: function (options) {
									return this.each(function () {
										var $this = $(this);
										var data = $this.data('autocompleteAddress');

										// If the plugin is not yet initialized
										if (!data) {
											$this.timer = null;
											$this.items = new Array();

											$.extend($this, options);

											$this.attr('autocomplete', 'off');

											// Focus
											$this.on('focus.autocompleteAddress', function () {
												$this.request('');
											} );

											// Blur
											$this.on('blur.autocompleteAddress', function () {
												setTimeout(function (object) {
													object.hide();
												}, 200, $this);
											} );

											// Keydown
											$this.on('keydown.autocompleteAddress', function (event) {
												switch (event.keyCode) {
													case 27: // escape
														$this.hide();
														break;
													default:
														if ($this[0].name.match(/address_1/i)){ break;};
														$this.request();
														break;
												}
											} );

											// Click
											$this.click = function (event) {
												event.preventDefault();

												//var value = $(event.target).parent().attr('data-value');
												var value = $(event.target).text();
												if (value && $this.items[value]) {
													$this.select($this.items[value]);
												}
											}

											// Show
											$this.show = function () {
												var pos = $this.position();

												$this.siblings('ul.' + $this.class).css({
													'top': pos.top + $this.outerHeight(),
													'left': pos.left
												});

												$this.siblings('ul.' + $this.class).show();
											}

											// Hide
											$this.hide = function () {
												$this.siblings('ul.' + $this.class).hide();
											}

											// Request
											$this.request = function (search) {
												clearTimeout($this.timer);

												$this.timer = setTimeout(function (object) {
													search = (typeof(search) === 'undefined') ? object.val() : search;

													object.source(search, $.proxy(object.response, object));
												}, 200, $this);
											}

											// Response
											$this.response = function (json) {
												var html = '';

												if (json.length) {
													for (i = 0; i < json.length; i++) {
														this.items[json[i]['value']] = json[i];

														html += '<li data-value=' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
													}
												}

												if (html && $this.is(':focus')) {
													$this.show();
												} else {
													$this.hide();
												}

												$this.siblings('ul.' + $this.class).html(html);
											}

											$this.after('<ul class="' + $this.class + '"></ul>');
											$this.siblings('ul.' + $this.class).delegate('a', 'click', $.proxy($this.click, $this));
											$this.data('autocompleteAddress', true);
										}
									} );
								},
								destroy: function () {
									return this.each(function () {
										var $this = $(this);

										$this.removeData('autocompleteAddress');

										$this.off('.autocompleteAddress');
									} );
								}
							};

							$.fn.autocompleteAddress = function (method) {
								if (methods[method]) {
									return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
								} else if (typeof (method) === 'object' || !method) {
									return methods.init.apply(this, arguments);
								} else {
									$.error('Method "' + method + '" does not exist for jQuery.autocompleteAddress');
								}
							}
						} )(window.jQuery);

						// ShippingData object
						function ShippingData() {
							var self = this;
							var src, method, lang, deliveryCity;

							self.methods_city = [
								'novaposhta.warehouse',
								'novaposhta.doors',
                                'filterit0.filterit0',
                                'filterit3.filterit0'
							];

							self.methods_address = [
								'novaposhta.warehouse',
								  'filterit0.filterit0',
								  'filterit3.filterit0'
							];

							self.setProp = function () {
								self.method = $('input[name="shipping_method"]:checked').val() || $('select[name="shipping_method"]').val();

								self.lang =  $('html').attr('lang');
							}

							self.handlerChanges = function (name, value) {
								if ($.inArray(self.method, self.methods_city.concat(self.methods_address)) != - 1) {
									if (name.match(/zone/i)) {
										$('input[name*="city"]:visible').val('');
										$('input[name*="address_1"]:visible').val('');
									} else if (name.match(/city/i)) {
										$('input[name*="address_1"]:visible').val('');
									} else if (name.match(/shipping\_method/i)) {
										$('input[name*="city"]:visible').autocompleteAddress('destroy');
										$('input[name*="address_1"]:visible').val('').autocompleteAddress('destroy');

										self.method = value;
									}
								} else if ($.inArray(value, self.methods_city.concat(self.methods_address)) != - 1) {
									if (name.match(/shipping\_method/i)) {
										$('input[name*="city"]:visible').val('');
										$('input[name*="address_1"]:visible').val('');

										self.method = value;
									}
								}
							}

							self.getAddress = function (element, search) {
								var filter, action;

								if (element[0].name.match(/city/i)) {
									filter = $('[name*="zone"]:visible').val() || '';
									if (!search) {
										search = element[0].value;
									}
									return $.ajax( {
										url: 'index.php?route=extension/module/nova_poshta/search',
										type: 'POST',
										data: 'shipping=' + 'novaposhta.warehouse'+ '&filter=' + encodeURIComponent(filter) + '&search=' + encodeURIComponent(search),
	                                    dataType: 'json',
										global: false,
										success: function (json) {
											self.src = json;
										}
									} );
								} else if (element[0].name.match(/address_1/i)) {
									filter = $('[name*="city"]:visible').val();
									if (!search) {
										search = self.deliveryCity;
									}
									return $.ajax({
										url: 'index.php?route=extension/module/nova_poshta/warehouses',
										type: 'POST',
										data: 'ref=' + encodeURIComponent(search),
	                                    dataType: 'json',
										global: false,
										success: function (json) {
											self.src = json;
										}
									});
								}								
							}


						}

						// DOOM loaded
						$(function () {
							var shippingData = new ShippingData();

							// Settings properties after DOOM load
							shippingData.setProp();

							// Settings properties after ajaxStop
							$(document).ajaxStop(function () {
								shippingData.setProp();
							} );

							// Check changes
							$(document).on('change', '[name*="zone"]:visible, [name*="city"]:visible,  [name*="shipping_method"]', function (e) {
								shippingData.handlerChanges(e.target.name, e.target.value);
							});

							// Add autocomplete for address
							$('body').on('focus', 'input[name*="city"]:visible, input[name*="address_1"]:visible', function () {

						
								if (this.name.match(/city/i) && $.inArray(shippingData.method, shippingData.methods_city) != - 1 || this.name.match(/address_1/i) && $.inArray(shippingData.method, shippingData.methods_address) != - 1) {

									$(this).autocompleteAddress( {
										source: function (request, response) {
											var x, html_el = this;
											shippingData.getAddress(this, request).done(function () {
												if(html_el[0].name.match(/city/i)){
													x='Present';
												} else {
													x='Description';
												}
												response($.map(shippingData.src, function (item) {
													return {
														label: item[x],
														value: item[x],
														deliveryCity:   item['DeliveryCity']
													}
												} ));
											} );
										},
										select: function (e) {
											console.log('Значение: '+e.value);
											if (e.value != this.val()) {
												this.val(e.label).trigger('change');
											}
											if(e.deliveryCity){ 
												shippingData.deliveryCity = e.deliveryCity;
											}
	
										},
										class: 'dropdown-address'
									} );
								}
							} );
						} );

// 	$(function () {
// 		if($("#shipping_address_city").length > 0) {
// 			console.log('wwwww');
// 		$("#shipping_address_city").autocomplete({
// 			source: (request, response) => {
// 				$.ajax({
// 					url: 'index.php?route=extension/module/nova_poshta/search',
// 					type: 'post',
// 					data: {search : request.term},
// 		      dataType: 'json',
// 					success: (json) => {
// 						response($.map(json, function(item){
// 							return{
// 								label: item.Present,
// 								ref: item.DeliveryCity
// 							}
// 						}));
// 					},
// 				});
// 			},
// 			select: (event, ui) => {
// 				$.ajax({
// 					url: 'index.php?route=extension/module/nova_poshta/warehouses',
// 					type: 'post',
// 					data: {ref : ui.item.ref},
// 		      dataType: 'json',
// 					success: (json) => {
// 						let ware = $.map(json, function(item){
// 							return{
// 								label: item.DescriptionRu,
// 							}
// 						});
// 						$("#shipping_address_address_1").autocomplete({
// 							source:ware,
// 							appendTo: "#address_wrap",
// 							minLength: 0
// 						});
// 						$("#shipping_address_address_1").autocomplete('search');
// 					},
// 				});
// 	    },
// 	    search: inputClear,
// 			appendTo: "#city_wrap",
// 			minLength: 2
// 		});
		
// 		function inputClear() {
//       $('#shipping_address_address_1').val('');
//     }
// 	}
// });