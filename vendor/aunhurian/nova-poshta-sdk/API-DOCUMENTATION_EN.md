# Nova Poshta SDK API Documentation

This document contains a detailed description of all available methods in the SDK for working with the Nova Poshta API.

## Available API Modules

- [AddressApi](#addressapi-module) - Work with addresses, settlements, and warehouses
- [CounterpartyApi](#counterpartyapi-module) - Work with counterparties (clients)
- [DocumentApi](#documentapi-module) - Work with waybills (TTN)
- [TrackingApi](#trackingapi-module) - Track shipment status
- [CommonApi](#commonapi-module) - Reference information

## AddressApi Module

Module for working with addresses, settlements, and warehouses.

### getAreas

Retrieves a list of regions (oblasts) of Ukraine.

```php
$areas = $sdk->address()->getAreas();
```

**Returns:** an array with information about Ukraine's regions.

**API Documentation:** [Address/getAreas](https://developers.novaposhta.ua/documentation#/Address/getAreas)

### searchSettlements

Search for settlements by name with pagination.

```php
$settlements = $sdk->address()->searchSettlements(
    'Kyiv',     // Search query
    1,          // Page number (default: 1)
    20          // Results per page (default: 20)
);
```

**Returns:** an array of found settlements.

**API Documentation:** [Address/searchSettlements](https://developers.novaposhta.ua/documentation#/Address/searchSettlements)

### searchSettlementStreets

Search for streets in a settlement by name with pagination.

```php
$streets = $sdk->address()->searchSettlementStreets(
    '8d5a980d-391c-11dd-90d9-001a92567626', // Settlement Ref
    'Khreshchatyk', // Search query
    1,              // Page number (default: 1)
    20              // Results per page (default: 20)
);
```

**Returns:** an array of found streets in the settlement.

**API Documentation:** [Address/searchSettlementStreets](https://developers.novaposhta.ua/documentation#/Address/searchSettlementStreets)

### getCities

Retrieve a list of cities with filtering and pagination.

```php
$cities = $sdk->address()->getCities(
    null,              // City Ref to get a specific city
    'Kyiv',            // Search by string
    1,                 // Page number
    20                 // Results per page
);
```

**Returns:** an array with information about cities.

**API Documentation:** [Address/getCities](https://developers.novaposhta.ua/documentation#/Address/getCities)

### getWarehouses

Retrieve a list of warehouses with filtering and pagination.

```php
$warehouses = $sdk->address()->getWarehouses(
    '8d5a980d-391c-11dd-90d9-001a92567626', // City Ref
    'Department',      // Search by string
    1,                 // Page number
    20,                // Results per page
    null               // Warehouse type Ref
);
```

**Returns:** an array with information about warehouses.

**API Documentation:** [Address/getWarehouses](https://developers.novaposhta.ua/documentation#/Address/getWarehouses)

### getWarehouseTypes

Retrieve warehouse types.

```php
$warehouseTypes = $sdk->address()->getWarehouseTypes();
```

**Returns:** an array with information about warehouse types.

**API Documentation:** [Address/getWarehouseTypes](https://developers.novaposhta.ua/documentation#/Address/getWarehouseTypes)

### getStreet

Retrieve a list of streets in a city with filtering and pagination.

```php
$streets = $sdk->address()->getStreet(
    '8d5a980d-391c-11dd-90d9-001a92567626', // City Ref
    'Khreshchatyk',    // Search by string
    1,                 // Page number
    20                 // Results per page
);
```

**Returns:** an array with information about streets.

**API Documentation:** [Address/getStreet](https://developers.novaposhta.ua/documentation#/Address/getStreet)

### save

Create a new address (counterparty address).

```php
$address = $sdk->address()->save(
    '005056801329',                          // Counterparty Ref
    'd8364179-4149-11de-8a23-000c2965ae0e',  // Street Ref
    '12',                                    // Building number
    '45',                                    // Apartment number (optional)
    'Additional information'                 // Note (optional)
);
```

**Returns:** an array with information about the created address.

**API Documentation:** [Address/save](https://developers.novaposhta.ua/documentation#/Address/save)

### delete

Delete an address.

```php
$result = $sdk->address()->delete('76f64060-13d4-11ea-8b78-0025b502a04e'); // Address Ref
```

**Returns:** an array with the operation result.

**API Documentation:** [Address/delete](https://developers.novaposhta.ua/documentation#/Address/delete)

## CounterpartyApi Module

Module for working with counterparties (clients).

### save

Create a new counterparty.

```php
// For an individual
$counterparty = $sdk->counterparty()->save(
    'PrivatePerson',  // Counterparty type
    'John',           // First name
    'Smith',          // Last name
    'Michael',        // Middle name
    '380991234567',   // Phone
    'test@example.com' // Email
);

// For an organization
$counterparty = $sdk->counterparty()->save(
    'Organization',   // Counterparty type
    null,             // First name (not used for organizations)
    null,             // Last name (not used for organizations)
    null,             // Middle name (not used for organizations)
    '380991234567',   // Phone
    'company@example.com', // Email
    'LLC "Company"',  // Company name
    '12345678'        // EDRPOU
);
```

**Returns:** an array with information about the created counterparty.

**API Documentation:** [Counterparty/save](https://developers.novaposhta.ua/documentation#/Counterparty/save)

### update

Update an existing counterparty.

```php
$counterparty = $sdk->counterparty()->update(
    '005056801329',    // Counterparty Ref
    'Peter',           // New first name
    'Johnson',         // New last name
    'William',         // New middle name
    '380991234567',    // New phone
    'new@example.com'  // New email
);
```

**Returns:** an array with information about the updated counterparty.

**API Documentation:** [Counterparty/update](https://developers.novaposhta.ua/documentation#/Counterparty/update)

### delete

Delete a counterparty.

```php
$result = $sdk->counterparty()->delete('005056801329'); // Counterparty Ref
```

**Returns:** an array with the operation result.

**API Documentation:** [Counterparty/delete](https://developers.novaposhta.ua/documentation#/Counterparty/delete)

### getCounterpartyAddresses

Retrieve counterparty addresses.

```php
$addresses = $sdk->counterparty()->getCounterpartyAddresses(
    '005056801329',    // Counterparty Ref
    'Recipient'        // Counterparty type (Sender, Recipient)
);
```

**Returns:** an array with counterparty addresses.

**API Documentation:** [Counterparty/getCounterpartyAddresses](https://developers.novaposhta.ua/documentation#/Counterparty/getCounterpartyAddresses)

### getCounterpartyContactPersons

Retrieve counterparty contact persons.

```php
$contactPersons = $sdk->counterparty()->getCounterpartyContactPersons(
    '005056801329',    // Counterparty Ref
    'Recipient'        // Counterparty type (Sender, Recipient)
);
```

**Returns:** an array with counterparty contact persons.

**API Documentation:** [Counterparty/getCounterpartyContactPersons](https://developers.novaposhta.ua/documentation#/Counterparty/getCounterpartyContactPersons)

### getCounterparties

Retrieve a list of counterparties.

```php
$counterparties = $sdk->counterparty()->getCounterparties(
    'Smith',           // Search by string
    'Recipient',       // Counterparty type (Sender, Recipient)
    1,                 // Page number
    20                 // Results per page
);
```

**Returns:** an array with counterparties.

**API Documentation:** [Counterparty/getCounterparties](https://developers.novaposhta.ua/documentation#/Counterparty/getCounterparties)

## DocumentApi Module

Module for working with waybills (TTN).

### save

Create a new waybill.

```php
$document = $sdk->document()->save([
    'PayerType' => 'Sender',
    'PaymentMethod' => 'Cash',
    'CargoType' => 'Cargo',
    'Weight' => 1,
    'ServiceType' => 'WarehouseWarehouse',
    'SeatsAmount' => 1,
    'Description' => 'Cargo description',
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

**Returns:** an array with information about the created waybill.

**API Documentation:** [InternetDocument/save](https://developers.novaposhta.ua/documentation#/InternetDocument/save)

### delete

Delete a waybill.

```php
$result = $sdk->document()->delete('9b7ee85f-120d-11e7-eddc-d72eef53f199'); // Waybill Ref
```

**Returns:** an array with the operation result.

**API Documentation:** [InternetDocument/delete](https://developers.novaposhta.ua/documentation#/InternetDocument/delete)

### getDocumentPrice

Calculate delivery cost.

```php
$cost = $sdk->document()->getDocumentPrice(
    '8d5a980d-391c-11dd-90d9-001a92567626', // Sender city
    'db5c88de-391c-11dd-90d9-001a92567626', // Recipient city
    '1',                                    // Weight
    'WarehouseWarehouse',                   // Delivery type
    500,                                    // Declared value
    1,                                      // Cargo type
    1                                       // Number of seats
);
```

**Returns:** an array with the calculated delivery cost.

**API Documentation:** [InternetDocument/getDocumentPrice](https://developers.novaposhta.ua/documentation#/InternetDocument/getDocumentPrice)

### getDocumentDeliveryDate

Calculate delivery date.

```php
$date = $sdk->document()->getDocumentDeliveryDate(
    '8d5a980d-391c-11dd-90d9-001a92567626', // Sender city
    'db5c88de-391c-11dd-90d9-001a92567626', // Recipient city
    'WarehouseWarehouse',                   // Delivery type
    '01.01.2023'                            // Shipping date
);
```

**Returns:** an array with the calculated delivery date.

**API Documentation:** [InternetDocument/getDocumentDeliveryDate](https://developers.novaposhta.ua/documentation#/InternetDocument/getDocumentDeliveryDate)

### getDocumentList

Retrieve a list of waybills.

```php
$documents = $sdk->document()->getDocumentList(
    '01.01.2023',      // Date from
    '01.02.2023',      // Date to
    1,                 // Page number
    100                // Results per page
);
```

**Returns:** an array with waybills.

**API Documentation:** [InternetDocument/getDocumentList](https://developers.novaposhta.ua/documentation#/InternetDocument/getDocumentList)

### getDocument

Retrieve information about a waybill.

```php
$document = $sdk->document()->getDocument('59000000000000'); // Waybill number
```

**Returns:** an array with information about the waybill.

**API Documentation:** [InternetDocument/getDocument](https://developers.novaposhta.ua/documentation#/InternetDocument/getDocument)

### generateReport

Generate a report for waybills.

```php
$report = $sdk->document()->generateReport(
    '01.01.2023',      // Date from
    '01.02.2023',      // Date to
    'xls'              // File type (csv, xls)
);
```

**Returns:** an array with a link to the report.

**API Documentation:** [InternetDocument/generateReport](https://developers.novaposhta.ua/documentation#/InternetDocument/generateReport)

## TrackingApi Module

Module for tracking shipment status.

### getStatusDocuments

Retrieve the status of a single shipment.

```php
$status = $sdk->tracking()->getStatusDocuments('59000000000000'); // Waybill number
```

**Returns:** an array with the shipment status.

**API Documentation:** [TrackingDocument/getStatusDocuments](https://developers.novaposhta.ua/documentation#/TrackingDocument/getStatusDocuments)

### getStatusDocumentsWithPhone

Retrieve the status of a shipment with a phone number.

```php
$status = $sdk->tracking()->getStatusDocumentsWithPhone(
    '59000000000000',  // Waybill number
    '380991234567'     // Phone number
);
```

**Returns:** an array with the shipment status.

**API Documentation:** [TrackingDocument/getStatusDocuments](https://developers.novaposhta.ua/documentation#/TrackingDocument/getStatusDocuments)

### getStatusDocumentsBatch

Retrieve the status of multiple shipments.

```php
$statuses = $sdk->tracking()->getStatusDocumentsBatch([
    ['DocumentNumber' => '59000000000000'],
    ['DocumentNumber' => '59000000000001'],
]);
```

**Returns:** an array with the statuses of shipments.

**API Documentation:** [TrackingDocument/getStatusDocuments](https://developers.novaposhta.ua/documentation#/TrackingDocument/getStatusDocuments)

### getStatusHistory

Retrieve the complete history of a shipment.

```php
$history = $sdk->tracking()->getStatusHistory('59000000000000'); // Waybill number
```

**Returns:** an array with the history of shipment statuses.

**API Documentation:** [TrackingDocument/getStatusHistory](https://developers.novaposhta.ua/documentation#/TrackingDocument/getStatusHistory)

## CommonApi Module

Module for retrieving reference information.

### getCargoTypes

Retrieve cargo types.

```php
$cargoTypes = $sdk->common()->getCargoTypes();
```

**Returns:** an array with cargo types.

**API Documentation:** [Common/getCargoTypes](https://developers.novaposhta.ua/documentation#/Common/getCargoTypes)

### getCargoDescriptionList

Retrieve a list of cargo descriptions.

```php
$cargoDescriptionList = $sdk->common()->getCargoDescriptionList('Clothing'); // Search query
```

**Returns:** an array with cargo descriptions.

**API Documentation:** [Common/getCargoDescriptionList](https://developers.novaposhta.ua/documentation#/Common/getCargoDescriptionList)

### getServiceTypes

Retrieve service types.

```php
$serviceTypes = $sdk->common()->getServiceTypes();
```

**Returns:** an array with service types.

**API Documentation:** [Common/getServiceTypes](https://developers.novaposhta.ua/documentation#/Common/getServiceTypes)

### getTypesOfPayers

Retrieve payer types.

```php
$typesOfPayers = $sdk->common()->getTypesOfPayers();
```

**Returns:** an array with payer types.

**API Documentation:** [Common/getTypesOfPayers](https://developers.novaposhta.ua/documentation#/Common/getTypesOfPayers)

### getTypesOfPayment

Retrieve payment types.

```php
$typesOfPayment = $sdk->common()->getTypesOfPayment();
```

**Returns:** an array with payment types.

**API Documentation:** [Common/getTypesOfPayment](https://developers.novaposhta.ua/documentation#/Common/getTypesOfPayment)

### getTimeIntervals

Retrieve time intervals for delivery.

```php
$timeIntervals = $sdk->common()->getTimeIntervals(
    'db5c88de-391c-11dd-90d9-001a92567626', // Recipient city Ref
    '01.01.2023'                            // Delivery date
);
```

**Returns:** an array with delivery time intervals.

**API Documentation:** [Common/getTimeIntervals](https://developers.novaposhta.ua/documentation#/Common/getTimeIntervals)

### getPackList

Retrieve a list of packaging types.

```php
$packList = $sdk->common()->getPackList();
```

**Returns:** an array with packaging types.

**API Documentation:** [Common/getPackList](https://developers.novaposhta.ua/documentation#/Common/getPackList) 