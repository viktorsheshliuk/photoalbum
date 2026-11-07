/**
 * Локальне автодоповнення Нової Пошти (міста / відділення) для Simple checkout
 */
(function ($) {
	'use strict';

	if (typeof $ === 'undefined') {
		return;
	}

	// Блок, в якому шукаємо поля адреси доставки
	var CONTAINERS = ['#simplecheckout_shipping_address'];

	var KIND_BRANCH = 'branch';
	var KIND_POSTOMAT = 'postomat';

	var state = {};
	var config = null;
	var refreshTimer = 0;
	var retries = 0;
	var lastKind = null;

	function getConfig() {
		if (config) {
			return config;
		}

		if (window.NPSHIPPING && window.NPSHIPPING.url) {
			config = window.NPSHIPPING;
		}

		return config;
	}

	function text(key, fallback) {
		var current = getConfig();

		if (current && current.texts && typeof current.texts[key] !== 'undefined' && current.texts[key] !== '') {
			return current.texts[key];
		}

		return fallback || '';
	}

	function getMethod() {
		var method = $('input[name="shipping_method"]:checked').val();

		if (typeof method === 'undefined' || method === '') {
			method = $('select[name="shipping_method"]').val();
		}

		return method ? String(method) : '';
	}

	// Тип точки видачі для поточного методу доставки
	function getKind() {
		var method = getMethod();

		if (method.indexOf('novaposhta.') !== 0) {
			return '';
		}

		if (method.indexOf('parcelbox') !== -1 || method.indexOf('postomat') !== -1) {
			return KIND_POSTOMAT;
		}

		if (method.indexOf('department') !== -1 || method.indexOf('warehouse') !== -1) {
			return KIND_BRANCH;
		}

		return '';
	}

	function scheduleRefresh(delay) {
		window.clearTimeout(refreshTimer);

		refreshTimer = window.setTimeout(refresh, typeof delay === 'number' ? delay : 0);
	}

	function refresh() {
		if (!getConfig()) {
			return;
		}

		if (typeof $.fn.select2 !== 'function') {
			// У режимі popup скрипти підключаються динамічно
			if (retries < 40) {
				retries++;

				refreshTimer = window.setTimeout(refresh, 250);
			}

			return;
		}

		retries = 0;

		// Не перебудовуємо селекти, поки користувач обирає значення
		if ($('.select2-container--open').length) {
			scheduleRefresh(400);

			return;
		}

		var kind = getKind();

		// Обраний раніше відділення/поштомат не підходить для нового типу доставки
		var kindChanged = (lastKind !== null && kind !== '' && lastKind !== '' && lastKind !== kind);

		lastKind = kind;

		for (var i = 0; i < CONTAINERS.length; i++) {
			var $container = $(CONTAINERS[i]);

			if ($container.length) {
				setup($container, kind, kindChanged);
			}
		}
	}

	function setup($container, kind, kindChanged) {
		var id = $container.attr('id');
		var $city = $container.find('input[name$="[city]"]').first();
		var $address = $container.find('input[name$="[address_1]"]').first();
		var current = state[id];

		if (current && current.kind === kind && current.city === $city[0] && current.address === $address[0] && current.citySelect && $.contains(document.documentElement, current.citySelect[0])) {
			return;
		}

		destroy(id);

		if (!kind || !$city.length) {
			return;
		}

		var zoneId = function () {
			var $zone = $container.find('select[name$="[zone_id]"], input[name$="[zone_id]"]').first();

			return $zone.length ? ($zone.val() || 0) : 0;
		};

		var cityValue = $city.val() || '';

		state[id] = {
			kind: kind,
			city: $city[0],
			address: $address.length ? $address[0] : null,
			cityRef: '',
			addressRef: '',
			citySelect: null,
			addressSelect: null
		};

		state[id].citySelect = createSelect($city, 'np-city-select', cityValue);

		initCitySelect(id, state[id].citySelect, $city, zoneId);

		if ($address.length) {
			state[id].addressSelect = createSelect($address, 'np-address-select', $address.val() || '');

			initAddressSelect(id, state[id].addressSelect, $address, kind);
		}

		if (kindChanged && $address.length) {
			clearAddress(id);
		}

		if (cityValue) {
			resolveCity(id, cityValue, zoneId());
		}
	}


	// Створює select2-селект поруч з нативним полем і ховає нативне поле
	function createSelect($native, cssClass, value) {
		var $select = $('<select class="form-control ' + cssClass + '"></select>');

		// Без атрибута name, щоб селект не потрапляв у дані форми
		$select.append($('<option value=""></option>'));

		if (value) {
			$select.append($('<option></option>').attr('value', value).text(value).prop('selected', true));
		}

		$native.addClass('np-native-hidden').after($select);

		return $select;
	}

	function initSelect($select, options) {
		$select.select2($.extend(true, {
			width: '100%',
			allowClear: true,
			minimumInputLength: 2,
			language: {
				inputTooShort: function () {
					return text('input_too_short');
				},
				noResults: function () {
					return text('no_results');
				},
				searching: function () {
					return text('searching');
				},
				errorLoading: function () {
					return text('error_loading');
				},
				loadingMore: function () {
					return text('loading_more');
				}
			},
			transport: function (params, success, failure) {
				// global: false - щоб запити не запускали глобальні ajax-події Simple
				params.global = false;

				var request = $.ajax(params);

				request.then(success);
				request.fail(failure);

				return request;
			}
		}, options));
	}

	function initCitySelect(id, $select, $native, zoneId) {
		initSelect($select, {
			placeholder: $native.attr('placeholder') || text('search_city'),
			templateResult: function (item) {
				if (!item.id || !item.hint) {
					return item.text;
				}

				return $('<span>').append($('<span>').text(item.text), $('<span class="np-item-hint">').text(' — ' + item.hint));
			},
			templateSelection: function (item) {
				return item.text;
			},
			ajax: {
				url: getConfig().url,
				dataType: 'json',
				delay: 250,
				cache: true,
				data: function (params) {
					return {
						action: 'cities',
						q: params.term || '',
						zone_id: zoneId()
					};
				},
				processResults: function (data) {
					return { results: (data && data.results) ? data.results : [] };
				}
			}
		});

		$select.on('select2:select', function (event) {
			var item = event.params.data || {};

			if (item.id) {
				state[id].cityRef = item.id;
			}

			setNativeValue($native, item.text || '');
			clearAddress(id);
		});

		$select.on('select2:clear', function () {
			if (state[id]) {
				state[id].cityRef = '';
			}

			setNativeValue($native, '');
			clearAddress(id);
		});
	}


	function initAddressSelect(id, $select, $native, kind) {
		var hasCity = function () {
			return !!(state[id] && state[id].cityRef);
		};

		initSelect($select, {
			minimumInputLength: 0,
			placeholder: $native.attr('placeholder') || text('search_warehouse'),
			language: {
				noResults: function () {
					return hasCity() ? text('no_results') : text('select_city_first');
				}
			},
			ajax: {
				url: getConfig().url,
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						action: 'warehouses',
						city_ref: hasCity() ? state[id].cityRef : '',
						type: kind,
						q: params.term || ''
					};
				},
				processResults: function (data) {
					return { results: (data && data.results) ? data.results : [] };
				}
			}
		});

		$select.on('select2:select', function (event) {
			var item = event.params.data || {};

			state[id].addressRef = item.id || '';

			saveWarehouseRef(id);

			setNativeValue($native, item.text || '');
		});

		$select.on('select2:clear', function () {
			if (state[id]) {
				state[id].addressRef = '';
			}

			saveWarehouseRef(id);

			setNativeValue($native, '');
		});
	}

	// Ref обраного відділення/поштомата надсилаємо на сервер, щоб зберегти його в замовленні
	function saveWarehouseRef(id) {
		var current = state[id];

		if (!current || !getConfig()) {
			return;
		}

		$.ajax({
			url: getConfig().url,
			data: {
				action: 'save',
				ref: current.addressRef || ''
			},
			dataType: 'json',
			global: false
		});
	}

	// Записує значення в нативне поле Simple, щоб працювали валідація та збереження
	function setNativeValue($native, value) {
		if (!$native.length || $native.val() === value) {
			return;
		}

		$native.val(value).trigger('change');
	}

	function clearAddress(id) {
		var current = state[id];

		if (!current) {
			return;
		}

		if (current.addressSelect && current.addressSelect.length) {
			current.addressSelect.val('').trigger('change.select2');
		}

		if (current.address && $(current.address).length) {
			setNativeValue($(current.address), '');
		}

		saveWarehouseRef(id);
	}

	// Отримує Ref міста для вже збереженого значення у полі city
	function resolveCity(id, name, zoneId) {
		var current = state[id];

		if (!current || !name) {
			return;
		}

		$.ajax({
			url: getConfig().url,
			data: {
				action: 'resolve',
				city: name,
				zone_id: zoneId || 0
			},
			dataType: 'json',
			global: false,
			success: function (data) {
				if (state[id] !== current) {
					return;
				}

				if (data && data.results && data.results.length) {
					current.cityRef = data.results[0].id;
				}
			}
		});
	}

	function destroy(id) {
		var current = state[id];

		if (!current) {
			return;
		}

		destroySelect(current.citySelect, current.city);
		destroySelect(current.addressSelect, current.address);

		delete state[id];
	}

	function destroySelect($select, native) {
		if ($select && $select.length) {
			if ($select.data('select2')) {
				$select.select2('destroy');
			}

			$select.remove();
		}

		if (native && $(native).length) {
			$(native).removeClass('np-native-hidden');
		}
	}

	window.NPDelivery = {
		refresh: function () {
			scheduleRefresh(0);
		}
	};

	$(function () {
		scheduleRefresh(50);

		$(document).on('ajaxComplete', function (event, xhr, settings) {
			var url = (settings && settings.url) ? String(settings.url) : '';

			if (url.indexOf('shippingdata/getShippingData') !== -1) {
				return;
			}

			scheduleRefresh(0);
		});

		$(document).on('change', 'input[name="shipping_method"], select[name="shipping_method"]', function () {
			scheduleRefresh(80);
		});

		$(document).on('change', 'select[name$="[zone_id]"], input[name$="[zone_id]"]', function () {
			scheduleRefresh(80);
		});
	});
})(window.jQuery);

