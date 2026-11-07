# Документація API Nova Poshta SDK

Цей документ містить детальний опис усіх доступних методів у SDK для роботи з API Нової Пошти.

## Доступні модулі API

- [AddressApi](#модуль-addressapi) - Робота з адресами, населеними пунктами та відділеннями
- [CounterpartyApi](#модуль-counterpartyapi) - Робота з контрагентами (клієнтами)
- [DocumentApi](#модуль-documentapi) - Робота з накладними (ТТН)
- [TrackingApi](#модуль-trackingapi) - Відстеження статусу посилок
- [CommonApi](#модуль-commonapi) - Довідкова інформація

## Модуль AddressApi

Модуль для роботи з адресами, населеними пунктами та відділеннями.

### getAreas

Отримує список областей України.

```php
$areas = $sdk->address()->getAreas();
```

**Повертає:** масив з інформацією про області України.

**Документація API:** [Address/getAreas](https://developers.novaposhta.ua/documentation#/Address/getAreas)

### searchSettlements

Пошук населених пунктів за назвою з можливістю пагінації.

```php
$settlements = $sdk->address()->searchSettlements(
    'Київ',    // Пошуковий запит
    1,         // Номер сторінки (за замовчуванням: 1)
    20         // Кількість результатів на сторінці (за замовчуванням: 20)
);
```

**Повертає:** масив знайдених населених пунктів.

**Документація API:** [Address/searchSettlements](https://developers.novaposhta.ua/documentation#/Address/searchSettlements)

### searchSettlementStreets

Пошук вулиць у населеному пункті за назвою з можливістю пагінації.

```php
$streets = $sdk->address()->searchSettlementStreets(
    '8d5a980d-391c-11dd-90d9-001a92567626', // Ref населеного пункту
    'Хрещатик',  // Пошуковий запит
    1,           // Номер сторінки (за замовчуванням: 1)
    20           // Кількість результатів на сторінці (за замовчуванням: 20)
);
```

**Повертає:** масив знайдених вулиць у населеному пункті.

**Документація API:** [Address/searchSettlementStreets](https://developers.novaposhta.ua/documentation#/Address/searchSettlementStreets)

### getCities

Отримання списку міст з можливістю фільтрації та пагінації.

```php
$cities = $sdk->address()->getCities(
    null,              // Ref міста для отримання конкретного міста
    'Київ',            // Пошук за рядком
    1,                 // Номер сторінки
    20                 // Кількість результатів на сторінці
);
```

**Повертає:** масив з інформацією про міста.

**Документація API:** [Address/getCities](https://developers.novaposhta.ua/documentation#/Address/getCities)

### getWarehouses

Отримання списку відділень з можливістю фільтрації та пагінації.

```php
$warehouses = $sdk->address()->getWarehouses(
    '8d5a980d-391c-11dd-90d9-001a92567626', // Ref міста
    'Відділення',      // Пошук за рядком
    1,                 // Номер сторінки
    20,                // Кількість результатів на сторінці
    null               // Ref типу відділення
);
```

**Повертає:** масив з інформацією про відділення.

**Документація API:** [Address/getWarehouses](https://developers.novaposhta.ua/documentation#/Address/getWarehouses)

### getWarehouseTypes

Отримання типів відділень.

```php
$warehouseTypes = $sdk->address()->getWarehouseTypes();
```

**Повертає:** масив з інформацією про типи відділень.

**Документація API:** [Address/getWarehouseTypes](https://developers.novaposhta.ua/documentation#/Address/getWarehouseTypes)

### getStreet

Отримання списку вулиць у місті з можливістю фільтрації та пагінації.

```php
$streets = $sdk->address()->getStreet(
    '8d5a980d-391c-11dd-90d9-001a92567626', // Ref міста
    'Хрещатик',        // Пошук за рядком
    1,                 // Номер сторінки
    20                 // Кількість результатів на сторінці
);
```

**Повертає:** масив з інформацією про вулиці.

**Документація API:** [Address/getStreet](https://developers.novaposhta.ua/documentation#/Address/getStreet)

### save

Створення нової адреси (адреси контрагента).

```php
$address = $sdk->address()->save(
    '005056801329',                          // Ref контрагента
    'd8364179-4149-11de-8a23-000c2965ae0e',  // Ref вулиці
    '12',                                    // Номер будинку
    '45',                                    // Номер квартири (опціонально)
    'Додаткова інформація'                   // Примітка (опціонально)
);
```

**Повертає:** масив з інформацією про створену адресу.

**Документація API:** [Address/save](https://developers.novaposhta.ua/documentation#/Address/save)

### delete

Видалення адреси.

```php
$result = $sdk->address()->delete('76f64060-13d4-11ea-8b78-0025b502a04e'); // Ref адреси
```

**Повертає:** масив з результатом операції.

**Документація API:** [Address/delete](https://developers.novaposhta.ua/documentation#/Address/delete)

## Модуль CounterpartyApi

Модуль для роботи з контрагентами (клієнтами).

### save

Створення нового контрагента.

```php
// Для фізичної особи
$counterparty = $sdk->counterparty()->save(
    'PrivatePerson',  // Тип контрагента
    'Іван',           // Ім'я
    'Петренко',       // Прізвище
    'Васильович',     // По батькові
    '380991234567',   // Телефон
    'test@example.com' // Email
);

// Для організації
$counterparty = $sdk->counterparty()->save(
    'Organization',   // Тип контрагента
    null,             // Ім'я (не використовується для організацій)
    null,             // Прізвище (не використовується для організацій)
    null,             // По батькові (не використовується для організацій)
    '380991234567',   // Телефон
    'company@example.com', // Email
    'ТОВ "Компанія"', // Назва компанії
    '12345678'        // ЄДРПОУ
);
```

**Повертає:** масив з інформацією про створеного контрагента.

**Документація API:** [Counterparty/save](https://developers.novaposhta.ua/documentation#/Counterparty/save)

### update

Оновлення існуючого контрагента.

```php
$counterparty = $sdk->counterparty()->update(
    '005056801329',    // Ref контрагента
    'Петро',           // Нове ім'я
    'Іваненко',        // Нове прізвище
    'Сергійович',      // Нове по батькові
    '380991234567',    // Новий телефон
    'new@example.com'  // Новий email
);
```

**Повертає:** масив з інформацією про оновленого контрагента.

**Документація API:** [Counterparty/update](https://developers.novaposhta.ua/documentation#/Counterparty/update)

### delete

Видалення контрагента.

```php
$result = $sdk->counterparty()->delete('005056801329'); // Ref контрагента
```

**Повертає:** масив з результатом операції.

**Документація API:** [Counterparty/delete](https://developers.novaposhta.ua/documentation#/Counterparty/delete)

### getCounterpartyAddresses

Отримання адрес контрагента.

```php
$addresses = $sdk->counterparty()->getCounterpartyAddresses(
    '005056801329',    // Ref контрагента
    'Recipient'        // Тип контрагента (Sender, Recipient)
);
```

**Повертає:** масив з адресами контрагента.

**Документація API:** [Counterparty/getCounterpartyAddresses](https://developers.novaposhta.ua/documentation#/Counterparty/getCounterpartyAddresses)

### getCounterpartyContactPersons

Отримання контактних осіб контрагента.

```php
$contactPersons = $sdk->counterparty()->getCounterpartyContactPersons(
    '005056801329',    // Ref контрагента
    'Recipient'        // Тип контрагента (Sender, Recipient)
);
```

**Повертає:** масив з контактними особами контрагента.

**Документація API:** [Counterparty/getCounterpartyContactPersons](https://developers.novaposhta.ua/documentation#/Counterparty/getCounterpartyContactPersons)

### getCounterparties

Отримання списку контрагентів.

```php
$counterparties = $sdk->counterparty()->getCounterparties(
    'Пет',             // Пошук за рядком
    'Recipient',       // Тип контрагента (Sender, Recipient)
    1,                 // Номер сторінки
    20                 // Кількість результатів на сторінці
);
```

**Повертає:** масив з контрагентами.

**Документація API:** [Counterparty/getCounterparties](https://developers.novaposhta.ua/documentation#/Counterparty/getCounterparties)

## Модуль DocumentApi

Модуль для роботи з накладними (ТТН).

### save

Створення нової накладної.

```php
$document = $sdk->document()->save([
    'PayerType' => 'Sender',
    'PaymentMethod' => 'Cash',
    'CargoType' => 'Cargo',
    'Weight' => 1,
    'ServiceType' => 'WarehouseWarehouse',
    'SeatsAmount' => 1,
    'Description' => 'Опис вантажу',
    'Cost' => 500,
    'CitySender' => '8d5a980d-391c-11dd-90d9-001a92567626',
    'Sender' => '5ace4a2e-13ee-11e5-add9-005056887b8d',
    'SenderAddress' => '2a8c3606-ab5b-11e9-8094-005056881c6b',
    'ContactSender' => '57b4218d-16d7-11e5-add9-005056887b8d',
    'SendersPhone' => '380991234567',
    'CityRecipient' => 'db5c88de-391c-11dd-90d9-001a92567626',
    'Recipient' => '7da56392-b64b-11e4-a77a-005056887b8d',
    'RecipientAddress' => '7da56392-b64b-11e4-a77a-005056887b8d',
    'ContactRecipient' => '57b4218d-16d7-11e5-add9-005056887b8d',
    'RecipientsPhone' => '380991234567',
]);
```

**Повертає:** масив з інформацією про створену накладну.

**Документація API:** [InternetDocument/save](https://developers.novaposhta.ua/documentation#/InternetDocument/save)

### delete

Видалення накладної.

```php
$result = $sdk->document()->delete('9b7ee85f-120d-11e7-eddc-d72eef53f199'); // Ref накладної
```

**Повертає:** масив з результатом операції.

**Документація API:** [InternetDocument/delete](https://developers.novaposhta.ua/documentation#/InternetDocument/delete)

### getDocumentPrice

Розрахунок вартості доставки.

```php
$cost = $sdk->document()->getDocumentPrice(
    '8d5a980d-391c-11dd-90d9-001a92567626', // Місто відправника
    'db5c88de-391c-11dd-90d9-001a92567626', // Місто отримувача
    '1',                                    // Вага
    'WarehouseWarehouse',                   // Тип доставки
    500,                                    // Оголошена вартість
    1,                                      // Тип вантажу
    1                                       // Кількість місць
);
```

**Повертає:** масив з розрахованою вартістю доставки.

**Документація API:** [InternetDocument/getDocumentPrice](https://developers.novaposhta.ua/documentation#/InternetDocument/getDocumentPrice)

### getDocumentDeliveryDate

Розрахунок дати доставки.

```php
$date = $sdk->document()->getDocumentDeliveryDate(
    '8d5a980d-391c-11dd-90d9-001a92567626', // Місто відправника
    'db5c88de-391c-11dd-90d9-001a92567626', // Місто отримувача
    'WarehouseWarehouse',                   // Тип доставки
    '01.01.2023'                            // Дата відправлення
);
```

**Повертає:** масив з розрахованою датою доставки.

**Документація API:** [InternetDocument/getDocumentDeliveryDate](https://developers.novaposhta.ua/documentation#/InternetDocument/getDocumentDeliveryDate)

### getDocumentList

Отримання списку накладних.

```php
$documents = $sdk->document()->getDocumentList(
    '01.01.2023',      // Дата з
    '01.02.2023',      // Дата по
    1,                 // Номер сторінки
    100                // Кількість результатів на сторінці
);
```

**Повертає:** масив з накладними.

**Документація API:** [InternetDocument/getDocumentList](https://developers.novaposhta.ua/documentation#/InternetDocument/getDocumentList)

### getDocument

Отримання інформації про накладну.

```php
$document = $sdk->document()->getDocument('59000000000000'); // Номер накладної
```

**Повертає:** масив з інформацією про накладну.

**Документація API:** [InternetDocument/getDocument](https://developers.novaposhta.ua/documentation#/InternetDocument/getDocument)

### generateReport

Генерування звіту за накладними.

```php
$report = $sdk->document()->generateReport(
    '01.01.2023',      // Дата з
    '01.02.2023',      // Дата по
    'xls'              // Тип файлу (csv, xls)
);
```

**Повертає:** масив з посиланням на звіт.

**Документація API:** [InternetDocument/generateReport](https://developers.novaposhta.ua/documentation#/InternetDocument/generateReport)

## Модуль TrackingApi

Модуль для відстеження статусу посилок.

### getStatusDocuments

Отримання статусу одного відправлення.

```php
$status = $sdk->tracking()->getStatusDocuments('59000000000000'); // Номер накладної
```

**Повертає:** масив зі статусом відправлення.

**Документація API:** [TrackingDocument/getStatusDocuments](https://developers.novaposhta.ua/documentation#/TrackingDocument/getStatusDocuments)

### getStatusDocumentsWithPhone

Отримання статусу відправлення з вказанням телефону.

```php
$status = $sdk->tracking()->getStatusDocumentsWithPhone(
    '59000000000000',  // Номер накладної
    '380991234567'     // Телефон
);
```

**Повертає:** масив зі статусом відправлення.

**Документація API:** [TrackingDocument/getStatusDocuments](https://developers.novaposhta.ua/documentation#/TrackingDocument/getStatusDocuments)

### getStatusDocumentsBatch

Отримання статусу декількох відправлень.

```php
$statuses = $sdk->tracking()->getStatusDocumentsBatch([
    ['DocumentNumber' => '59000000000000'],
    ['DocumentNumber' => '59000000000001'],
]);
```

**Повертає:** масив зі статусами відправлень.

**Документація API:** [TrackingDocument/getStatusDocuments](https://developers.novaposhta.ua/documentation#/TrackingDocument/getStatusDocuments)

### getStatusHistory

Отримання повної історії відправлення.

```php
$history = $sdk->tracking()->getStatusHistory('59000000000000'); // Номер накладної
```

**Повертає:** масив з історією статусів відправлення.

**Документація API:** [TrackingDocument/getStatusHistory](https://developers.novaposhta.ua/documentation#/TrackingDocument/getStatusHistory)

## Модуль CommonApi

Модуль для отримання довідкової інформації.

### getCargoTypes

Отримання типів вантажу.

```php
$cargoTypes = $sdk->common()->getCargoTypes();
```

**Повертає:** масив з типами вантажу.

**Документація API:** [Common/getCargoTypes](https://developers.novaposhta.ua/documentation#/Common/getCargoTypes)

### getCargoDescriptionList

Отримання списку опису вантажу.

```php
$cargoDescriptionList = $sdk->common()->getCargoDescriptionList('Одяг'); // Пошуковий запит
```

**Повертає:** масив з описами вантажу.

**Документація API:** [Common/getCargoDescriptionList](https://developers.novaposhta.ua/documentation#/Common/getCargoDescriptionList)

### getServiceTypes

Отримання типів послуг.

```php
$serviceTypes = $sdk->common()->getServiceTypes();
```

**Повертає:** масив з типами послуг.

**Документація API:** [Common/getServiceTypes](https://developers.novaposhta.ua/documentation#/Common/getServiceTypes)

### getTypesOfPayers

Отримання типів платників.

```php
$typesOfPayers = $sdk->common()->getTypesOfPayers();
```

**Повертає:** масив з типами платників.

**Документація API:** [Common/getTypesOfPayers](https://developers.novaposhta.ua/documentation#/Common/getTypesOfPayers)

### getTypesOfPayment

Отримання типів оплати.

```php
$typesOfPayment = $sdk->common()->getTypesOfPayment();
```

**Повертає:** масив з типами оплати.

**Документація API:** [Common/getTypesOfPayment](https://developers.novaposhta.ua/documentation#/Common/getTypesOfPayment)

### getTimeIntervals

Отримання часових інтервалів доставки.

```php
$timeIntervals = $sdk->common()->getTimeIntervals(
    'db5c88de-391c-11dd-90d9-001a92567626', // Ref міста отримувача
    '01.01.2023'                            // Дата доставки
);
```

**Повертає:** масив з часовими інтервалами доставки.

**Документація API:** [Common/getTimeIntervals](https://developers.novaposhta.ua/documentation#/Common/getTimeIntervals)

### getPackList

Отримання списку пакувань.

```php
$packList = $sdk->common()->getPackList();
```

**Повертає:** масив з типами пакувань.

**Документація API:** [Common/getPackList](https://developers.novaposhta.ua/documentation#/Common/getPackList) 