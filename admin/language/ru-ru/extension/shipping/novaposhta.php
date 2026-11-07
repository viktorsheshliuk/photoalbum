<?php

// Heading
$_['heading_title'] = 'Нова пошта';

// Tab
$_['tab_api'] = 'Дані з API';
$_['tab_main'] = 'Основне';
$_['tab_shipping_courier'] = 'Доставка кур\'єром';
$_['tab_shipping_department'] = 'Доставка до відділення';
$_['tab_shipping_parcelbox'] = 'Доставка в почтомат';
$_['tab_cron'] = 'Cron';

// Text
$_['text_disabled'] = 'Вимкнено';
$_['text_edit'] = 'Редагувати модуль';
$_['text_enabled'] = 'Увімкнено';
$_['text_extension'] = 'Розширення';
$_['text_info'] = 'Нова пошта %s';
$_['text_none'] = '--- Не обрано ---';
$_['text_success'] = 'Успіх: Ви змінили налаштування модуля!';
$_['text_regions_total'] = 'Кількість регіонів:';
$_['text_cities_total'] = 'Кількість міст:';
$_['text_departments_total'] = 'Кількість відділень:';

// Button
$_['button_apply'] = 'Застосувати';

// Entry
$_['entry_api_key'] = 'API Ключ';
$_['entry_courier_cost'] = 'Вартість';
$_['entry_courier_free_sum'] = 'Безкоштовна доставка від';
$_['entry_courier_free_text'] = 'Текст безкоштовної доставки';
$_['entry_courier_geo_zone_id'] = 'Географічна зона';
$_['entry_courier_max_sum'] = 'Макс. сума замовлення';
$_['entry_courier_min_sum'] = 'Мін. сума замовлення';
$_['entry_courier_status'] = 'Статус';
$_['entry_courier_tax_class_id'] = 'Клас податку';
$_['entry_courier_title'] = 'Назва';
$_['entry_courier_description'] = 'Опис';
$_['entry_description'] = 'Опис методу';
$_['entry_sort_order'] = 'Порядок сортування';
$_['entry_status'] = 'Статус модуля';
$_['entry_store'] = 'Магазин';
$_['entry_department_cost'] = 'Вартість';
$_['entry_department_free_sum'] = 'Безкоштовна доставка від';
$_['entry_department_geo_zone_id'] = 'Географічна зона';
$_['entry_department_max_sum'] = 'Макс. сума замовлення';
$_['entry_department_min_sum'] = 'Мін. сума замовлення';
$_['entry_department_status'] = 'Статус';
$_['entry_department_tax_class_id'] = 'Клас податку';
$_['entry_department_title'] = 'Назва';
$_['entry_department_description'] = 'Опис';
$_['entry_department_free_text'] = 'Текст безкоштовної доставки';

// Почтомат entries (новые)
$_['entry_parcelbox_status'] = 'Статус';
$_['entry_parcelbox_title'] = 'Назва';
$_['entry_parcelbox_description'] = 'Опис';
$_['entry_parcelbox_cost'] = 'Вартість';
$_['entry_parcelbox_min_sum'] = 'Мін. сума замовлення';
$_['entry_parcelbox_max_sum'] = 'Макс. сума замовлення';
$_['entry_parcelbox_free_sum'] = 'Безкоштовна доставка від';
$_['entry_parcelbox_free_text'] = 'Текст безкоштовної доставки';
$_['entry_parcelbox_tax_class_id'] = 'Клас податку';
$_['entry_parcelbox_geo_zone_id'] = 'Географічна зона';

// Help
$_['help_courier_status'] = 'Статус';
$_['help_store'] = 'Сторінка буде перезавантажена';

// Error
$_['error_api_key'] = 'Введіть API ключ!';
$_['error_name'] = 'Назва обов\'язкова!';
$_['error_permission'] = 'Попередження: У вас недостатньо прав для редагування модуля novaposhta!';
$_['error_warning'] = 'Попередження: Будь ласка, уважно перевірте форму на помилки!';

// Cron / Автооновлення статусів замовлень
$_['text_cron_info'] = 'Автоматичне оновлення статусів замовлень за даними Нової Пошти. Налаштуйте відповідність статусів та запускайте URL нижче за розкладом (cron).';
$_['text_cron_url'] = 'URL для cron';
$_['text_cron_copied'] = 'Скопійовано в буфер обміну';
$_['text_status_mapping'] = 'Відповідність статусів';
$_['text_np_statuses'] = 'Статуси Нової Пошти (API)';
$_['text_np_order_status'] = 'Статус замовлення на сайті';
$_['text_np_statuses_none'] = 'Нічого не обрано';
$_['text_np_statuses_selected'] = 'Обрано';
$_['text_np_select_all'] = 'Обрати всі';
$_['text_np_deselect_all'] = 'Зняти всі';
$_['text_status_map_empty'] = 'Відповідності ще не налаштовані';
$_['text_select_status'] = '--- Оберіть статус ---';
$_['text_tracking_result'] = 'Оброблено: %s, оновлено: %s, пропущено: %s';

$_['entry_np_tracking_enabled'] = 'Автооновлення статусів';
$_['entry_np_tracking_statuses'] = 'Відслідковувати замовлення зі статусами';
$_['entry_np_cron_key'] = 'Секретний ключ для cron';

$_['button_cron_copy'] = 'Копіювати';
$_['button_add_mapping'] = 'Додати відповідність';
$_['button_run_tracking'] = 'Оновити статуси зараз';

$_['help_np_tracking_enabled'] = 'Якщо увімкнено, статуси замовлень змінюються автоматично за даними Нової Пошти';
$_['help_np_tracking_statuses'] = 'Замовлення з цими статусами потрапляють у відслідковування. Якщо нічого не обрано - відслідковування не працює';
$_['help_np_cron_key'] = 'Ключ доступу до URL cron. Рекомендується змінити його на власний';
$_['help_status_mapping'] = 'Оберіть один або декілька статусів Нової Пошти (ліворуч) та статус замовлення на сайті (праворуч). Один код Нової Пошти може бути лише в одному рядку - використовується перший';

$_['error_np_tracking_disabled'] = 'Автооновлення статусів вимкнено';
$_['error_np_no_orders'] = 'Немає замовлень для відслідковування';
$_['error_np_status_map_duplicate'] = 'Статус Нової Пошти обрано у декількох рядках: ';