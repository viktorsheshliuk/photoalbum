<?php
/**
 * Local Nova Poshta data (cities / warehouses) for the Simple checkout autocomplete
 */
class ModelExtensionModuleShippingdata extends Model {
	// Warehouse categories that are shown as "Відділення" (novaposhta.department)
	private $branch_categories = array('Branch', 'Store', 'DropOff');

	// Warehouses categories that are shown as "Поштомат" (novaposhta.parcelbox)
	private $postomat_category = 'Postomat';

	// Префиксы типа населённого пункта, которые может ввести пользователь
	// или которые остались в адресах от сторонних модулей ("м. Київ", "с. Козин", "смт Мангуш")
	private $type_prefixes = array(
		'селище міського типу',
		'місто',
		'м.',
		'село',
		'с.',
		'селище',
		'смт',
		'город',
		'г.',
		'поселок',
		'посёлок',
		'пгт'
	);

	/**
	 * Cities search by name inside the local reference table
	 */
	public function getCities($search, $zone_id = 0) {
		$search = trim($this->stripTypePrefix($search));

		if (mb_strlen($search, 'UTF-8') < 2) {
			return array();
		}

		$like = $this->db->escape($this->escapeLike($search));

		// Название населённого пункта без уточнения в скобках: "Андріївка (Київська обл.)" -> "Андріївка"
		$name_sql = $this->getBaseNameSql();
		$name_sql_ru = $this->getBaseNameSql('DescriptionRu');

		$sql = "SELECT `Ref`, `Description`, `AreaDescription`, `SettlementTypeDescription` FROM `" . DB_PREFIX . "novaposhta_cities`";
		$sql .= " WHERE `Delivery1` = '1' AND (" . $name_sql . " LIKE '%" . $like . "%' OR " . $name_sql_ru . " LIKE '%" . $like . "%')";

		$area = $this->getAreaDescription($zone_id);

		if ($area) {
			$sql .= " AND `AreaDescription` = '" . $this->db->escape($area) . "'";
		}

		$sql .= " ORDER BY (" . $name_sql . " = '" . $this->db->escape($search) . "') DESC, (" . $name_sql . " LIKE '" . $like . "%') DESC, CHAR_LENGTH(`Description`) ASC, `Description` ASC LIMIT 30";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	/**
	 * Finds one city by its exact name (or by the closest match)
	 */
	public function getCityByName($name, $zone_id = 0) {
		$name = $this->normalizeCityName($name);

		if ($name === '') {
			return array();
		}

		$area = $this->getAreaDescription($zone_id);

		$select = "SELECT `Ref`, `Description`, `AreaDescription`, `SettlementTypeDescription` FROM `" . DB_PREFIX . "novaposhta_cities`";

		// "село Березанка (Миколаївська обл.)" -> также пробуем "Березанка"
		$variants = array($name);

		$base_name = $this->stripNameSuffix($name);

		if ($base_name !== '' && $base_name !== $name) {
			$variants[] = $base_name;
		}

		$conditions = array();

		foreach ($variants as $variant) {
			$variant = $this->db->escape($variant);

			$conditions[] = "(`Description` = '" . $variant . "' OR `DescriptionRu` = '" . $variant . "')";
			// В справочнике встречается "Березанка(Миколаївська обл.)" без пробела
			$conditions[] = "REPLACE(`Description`, '(', ' (') = '" . $variant . "'";
			// Сохранённое значение может быть без уточнения в скобках
			$conditions[] = $this->getBaseNameSql() . " = '" . $variant . "'";
		}

		foreach ($conditions as $condition) {
			$rows = $this->fetchCityRows($select . " WHERE `Delivery1` = '1' AND " . $condition, $area, " ORDER BY `Description` ASC LIMIT 5");

			if ($rows) {
				return $rows;
			}
		}

		return array();
	}

	/**
	 * Подпись населённого пункта для поля city: "місто Харків", "село Андріївка (Київська обл.)"
	 */
	public function getCityLabel($city) {
		$type = isset($city['SettlementTypeDescription']) ? trim($city['SettlementTypeDescription']) : '';
		$name = isset($city['Description']) ? trim($city['Description']) : '';

		$name = $this->removeTypeSuffix($name, $type);

		// В справочнике встречается "Березанка(Миколаївська обл.)" без пробела
		$name = preg_replace('/\s*\(/', ' (', $name);
		$name = preg_replace('/\s*\)/', ')', $name);

		return trim($type . ' ' . $name);
	}

	/**
	 * Серая подсказка в выпадающем списке: область, если её ещё не видно в названии
	 *
	 * @param array  $city   строка из novaposhta_cities
	 * @param string $suffix сокращение области ("обл."), передаётся из языкового файла
	 */
	public function getCityHint($city, $suffix = '') {
		$name = isset($city['Description']) ? trim($city['Description']) : '';
		$area = isset($city['AreaDescription']) ? trim($city['AreaDescription']) : '';

		// Уточнение в скобках ("Андріївка (Київська обл.)") уже показано в самой подписи
		if ($area === '' || mb_stripos($name, $area, 0, 'UTF-8') !== false) {
			return '';
		}

		// "Харківська" -> "Харківська обл." (если в справочнике когда-то будет уже с "обл." — не дублируем)
		if ($suffix !== '' && !preg_match('/(обл\.?|область)$/u', $area)) {
			$area .= ' ' . $suffix;
		}

		return $area;
	}

	/**
	 * Warehouses of the city filtered by the delivery type
	 *
	 * @param string $city_ref city Ref
	 * @param string $type     branch|postomat
	 * @param string $search   number or a part of the address
	 */
	public function getWarehouses($city_ref, $type, $search = '') {
		$city_ref = trim((string)$city_ref);

		if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $city_ref)) {
			return array();
		}

		$sql = "SELECT `Ref`, `Description`, `Number`, `CategoryOfWarehouse`, `ShortAddress` FROM `" . DB_PREFIX . "novaposhta_departments`";
		$sql .= " WHERE `CityRef` = '" . $this->db->escape($city_ref) . "' AND `DenyToSelect` = '0' AND `WarehouseStatus` = 'Working'";

		if ($type == 'postomat') {
			$sql .= " AND `CategoryOfWarehouse` = '" . $this->db->escape($this->postomat_category) . "'";
		} else {
			$sql .= " AND `CategoryOfWarehouse` IN ('" . implode("','", $this->branch_categories) . "')";
		}

		$search = trim((string)$search);

		if ($search !== '') {
			$like = $this->db->escape($this->escapeLike($search));

			$sql .= " AND (`Number` = '" . $this->db->escape($search) . "' OR `Description` LIKE '%" . $like . "%' OR `DescriptionRu` LIKE '%" . $like . "%')";
		}

		$sql .= " ORDER BY CAST(`Number` AS UNSIGNED) ASC, `Description` ASC LIMIT 50";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	/**
	 * SELECT cities by the prepared condition with the preferred area first
	 */
	private function fetchCityRows($sql, $area, $order) {
		if ($area) {
			$query = $this->db->query($sql . " AND `AreaDescription` = '" . $this->db->escape($area) . "' LIMIT 1");

			if ($query->num_rows) {
				return $query->rows;
			}
		}

		$query = $this->db->query($sql . $order);

		return $query->rows;
	}

	/**
	 * Название населённого пункта без уточнения в скобках
	 */
	private function getBaseNameSql($field = 'Description') {
		return "TRIM(SUBSTRING_INDEX(`" . $field . "`, '(', 1))";
	}

	/**
	 * Приводит сохранённое значение города к названию из справочника:
	 * "місто Харків" -> "Харків", "м. Київ, Київська обл." -> "Київ"
	 */
	private function normalizeCityName($name) {
		$name = trim((string)$name);

		if ($name === '') {
			return '';
		}

		// Значения сторонних модулей: "м. Київ, Київська обл.".
		// Если в названии есть скобки с уточнением (там тоже бывает запятая) — не режем
		$comma = mb_strpos($name, ',', 0, 'UTF-8');

		if ($comma !== false && mb_strpos($name, '(', 0, 'UTF-8') === false) {
			$name = trim(mb_substr($name, 0, $comma, 'UTF-8'));
		}

		return $this->stripTypePrefix($name);
	}

	/**
	 * Название населённого пункта без уточнения в скобках: "Березанка (Миколаївська обл.)" -> "Березанка"
	 */
	private function stripNameSuffix($name) {
		$open = mb_strpos($name, '(', 0, 'UTF-8');

		if ($open !== false) {
			$name = mb_substr($name, 0, $open, 'UTF-8');
		}

		return trim($name);
	}

	/**
	 * Убирает префикс типа населённого пункта: "місто Харків" -> "Харків", "смт Мангуш" -> "Мангуш"
	 */
	private function stripTypePrefix($name) {
		$name = trim((string)$name);

		if ($name === '') {
			return '';
		}

		$prefixes = array();

		foreach ($this->type_prefixes as $prefix) {
			$prefixes[] = preg_quote($prefix, '/');
		}

		if (preg_match('/^(' . implode('|', $prefixes) . ')\s+(.+)$/iu', $name, $matches)) {
			$rest = trim($matches[2]);

			if (mb_strlen($rest, 'UTF-8') >= 2) {
				return $rest;
			}
		}

		return $name;
	}

	/**
	 * Убирает уточнение в скобках, если оно повторяет тип: "Бахмач (місто)" -> "Бахмач"
	 */
	private function removeTypeSuffix($name, $type) {
		if ($type === '') {
			return $name;
		}

		$open  = mb_strpos($name, '(', 0, 'UTF-8');
		$close = mb_strrpos($name, ')', 0, 'UTF-8');

		if ($open === false || $close === false || $close < $open) {
			return $name;
		}

		$inner = rtrim(trim(mb_substr($name, $open + 1, $close - $open - 1, 'UTF-8')), '.');

		if (mb_strtolower($inner, 'UTF-8') !== mb_strtolower($type, 'UTF-8')) {
			return $name;
		}

		return trim(mb_substr($name, 0, $open, 'UTF-8'));
	}

	/**
	 * Converts a zone_id (region in the store) to the area name used by Nova Poshta
	 */
	public function getAreaDescription($zone_id) {
		$zone_id = (int)$zone_id;

		if (!$zone_id) {
			return '';
		}

		$query = $this->db->query("SELECT `name` FROM `" . DB_PREFIX . "zone` WHERE `zone_id` = '" . $zone_id . "' LIMIT 1");

		if (!$query->num_rows) {
			return '';
		}

		$name = trim(preg_replace('/\s*(область|обл\.)$/u', '', $query->row['name']));

		$variants = array($name);

		$map = array(
			'Київ'        => 'Київська',
			'Киев'        => 'Київська',
			'Севастополь' => 'Крим',
			'Крим'        => 'Крим',
			'Крым'        => 'Крим'
		);

		if (isset($map[$name])) {
			$variants[] = $map[$name];
		}

		foreach ($variants as $variant) {
			$query = $this->db->query("SELECT `AreaDescription` FROM `" . DB_PREFIX . "novaposhta_cities` WHERE `AreaDescription` = '" . $this->db->escape($variant) . "' LIMIT 1");

			if ($query->num_rows) {
				return $query->row['AreaDescription'];
			}
		}

		return '';
	}

	/**
	 * Escapes the LIKE wildcards so the user input is searched literally
	 */
	private function escapeLike($value) {
		return str_replace(array('\\', '%', '_'), array('\\\\', '\\%', '\\_'), $value);
	}
}
