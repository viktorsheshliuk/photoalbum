# Nova Poshta SDK for PHP

PHP SDK for integration with Nova Poshta API

[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-blue.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

## Requirements

- PHP 7.4 or higher
- Composer

## Installation

```bash
composer require aunhurian/nova-poshta-sdk
```

Or clone the repository:

```bash
git clone https://github.com/aunhurian/nova-poshta-sdk.git
cd nova-poshta-sdk
composer install
```

## Quick Start

```php
// Create SDK instance
$apiKey = 'your_api_key';
$sdk = new \AUnhurian\NovaPoshta\SDK\NovaPoshtaSDK($apiKey);

// Get list of cities
$cities = $sdk->address()->getCities(null, 'Kyiv');

// Get list of warehouses
$warehouses = $sdk->address()->getWarehouses(
    cityRef: '8d5a980d-391c-11dd-90d9-001a92567626', // Kyiv Ref
    findByString: 'Department'
);

// Track package
$trackingInfo = $sdk->tracking()->getStatusDocuments('59000000000000');
```

## Nova Poshta API Documentation

This SDK is based on the official Nova Poshta API. Detailed API documentation can be found at:
[Nova Poshta API Documentation](https://developers.novaposhta.ua/documentation)

## Detailed SDK Documentation

Detailed description of all available methods and their parameters can be found in a separate document:
[Detailed API Documentation](API-DOCUMENTATION_EN.md)

## SDK Structure

The SDK is divided into modules, each responsible for a specific part of the Nova Poshta API:

- **AddressApi** - Work with addresses, settlements, streets, and warehouses
- **CounterpartyApi** - Work with counterparties (clients)
- **DocumentApi** - Create, edit, and delete shipments (waybills)
- **TrackingApi** - Track shipment status
- **CommonApi** - Reference information

## Detailed Module Descriptions

### AddressApi

```php
// Get list of regions (oblasts)
$areas = $sdk->address()->getAreas();

// Search for settlements
$settlements = $sdk->address()->searchSettlements('Kyiv');

// Get list of cities with filtering
$cities = $sdk->address()->getCities(null, 'Kyiv', 1, 20);

// Get list of warehouses
$warehouses = $sdk->address()->getWarehouses(
    cityRef: '8d5a980d-391c-11dd-90d9-001a92567626',
    findByString: 'Department',
    page: 1,
    limit: 20
);

// Get warehouse types
$warehouseTypes = $sdk->address()->getWarehouseTypes();

// Get streets in a city
$streets = $sdk->address()->getStreet('city_ref', 'Khreshchatyk', 1, 10);
```

### CounterpartyApi

```php
// Create a new counterparty (individual)
$counterparty = $sdk->counterparty()->save(
    counterpartyType: 'PrivatePerson',
    firstName: 'John',
    lastName: 'Smith',
    middleName: 'Michael',
    phone: '380991234567',
    email: 'test@example.com'
);

// Create a new counterparty (organization)
$counterparty = $sdk->counterparty()->save(
    counterpartyType: 'Organization',
    companyName: 'LLC "Company"',
    edrpou: '12345678'
);

// Search for counterparties
$counterparties = $sdk->counterparty()->getCounterparties(null, 'Smith', 1, 10);

// Get counterparty contact persons
$contactPersons = $sdk->counterparty()->getCounterpartyContactPersons(
    ref: '005056801329',
    counterpartyProperty: 'Recipient'
);
```

### DocumentApi

```php
// Calculate delivery cost
$cost = $sdk->document()->getDocumentPrice(
    citySender: '8d5a980d-391c-11dd-90d9-001a92567626',
    cityRecipient: 'db5c88de-391c-11dd-90d9-001a92567626',
    weight: '1',
    serviceType: 'WarehouseWarehouse',
    cost: 500,
    cargoType: 1,
    seatsAmount: 1
);

// Calculate delivery date
$date = $sdk->document()->getDocumentDeliveryDate(
    citySender: '8d5a980d-391c-11dd-90d9-001a92567626',
    cityRecipient: 'db5c88de-391c-11dd-90d9-001a92567626',
    serviceType: 'WarehouseWarehouse',
    dateTime: '01.01.2023'
);

// Get list of shipments
$documents = $sdk->document()->getDocumentList(
    dateTimeFrom: '01.01.2023',
    dateTimeTo: '01.02.2023',
    page: 1,
    limit: 100
);

// Create a new shipment (simplified example)
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

### TrackingApi

```php
// Get status of a single shipment
$status = $sdk->tracking()->getStatusDocuments('59000000000000');

// Get status of multiple shipments
$statuses = $sdk->tracking()->getStatusDocumentsBatch([
    ['DocumentNumber' => '59000000000000'],
    ['DocumentNumber' => '59000000000001'],
]);

// Get complete shipment history
$history = $sdk->tracking()->getStatusHistory('59000000000000');
```

### CommonApi

```php
// Get cargo types
$cargoTypes = $sdk->common()->getCargoTypes();

// Get payment types
$paymentTypes = $sdk->common()->getTypesOfPayment();

// Get payer types
$payerTypes = $sdk->common()->getTypesOfPayers();

// Get service types
$serviceTypes = $sdk->common()->getServiceTypes();

// Get time intervals for delivery
$timeIntervals = $sdk->common()->getTimeIntervals(
    recipientCityRef: 'db5c88de-391c-11dd-90d9-001a92567626',
    dateTime: '01.01.2023'
);
```

## API Response Class

The SDK contains the `NovaPoshtaResponse` class for working with Nova Poshta API responses. By default, the SDK returns only the data from the response, but you can get the full response object that contains additional information:

```php
// Get full API response
$response = $sdk->requestWithFullResponse('Address', 'getAreas', []);

// Get data from response
$data = $response->getData();

// Check response status
$isSuccess = $response->isSuccess();

// Get warnings
$warnings = $response->getWarnings();

// Get information messages
$info = $response->getInfo();

// Get HTTP status code
$statusCode = $response->getStatusCode();

// Get raw response data
$rawData = $response->getRawData();
```

You can also use direct API requests instead of module methods:

```php
// Direct API usage through SDK
$cities = $sdk->request('Address', 'getCities', ['FindByString' => 'Kyiv']);

// Direct API usage with full response
$response = $sdk->requestWithFullResponse('Address', 'getCities', ['FindByString' => 'Kyiv']);
$cities = $response->getData();
```

## Contributing

We welcome contributions from the community! If you want to improve the SDK:

1. Fork the repository
2. Clone it locally
3. Make changes
4. Submit a Pull Request

Detailed instructions for contribution can be found in [CONTRIBUTING_EN.md](CONTRIBUTING_EN.md).

## Testing

The SDK has a complete set of tests to verify functionality. To run the tests, use:

```bash
# Run tests with PHPUnit
vendor/bin/phpunit
```

Tests are organized by API modules and use HTTP request mocking to simulate working with the Nova Poshta API without actual network requests.

A detailed description of the testing system can be found in [TESTING_EN.md](TESTING_EN.md).

## Using Mock Responses in Your Tests

The SDK provides a mechanism for setting up fake API responses for your integration tests. This can be useful when you want to test your application's interaction with the Nova Poshta API without making actual API calls.

```php
// Create SDK instance
$sdk = new \AUnhurian\NovaPoshta\SDK\NovaPoshtaSDK('your_api_key');

// Set up mock responses
$mockResponses = [
    // Mock for getAreas request
    'Address.getAreas' => [
        'response' => [
            'success' => true,
            'data' => [
                [
                    'Ref' => '71508128-9b87-11de-822f-000c2965ae0e',
                    'Description' => 'Kyiv oblast',
                    'AreasCenter' => '8d5a980d-391c-11dd-90d9-001a92567626',
                ]
            ],
            'errors' => [],
            'warnings' => [],
            'info' => [],
        ],
    ],
    
    // Mock with parameter matching
    'Address.getCities' => [
        // This will only match if parameters include 'FindByString' => 'Kyiv'
        'params' => [
            'FindByString' => 'Kyiv',
        ],
        'response' => [
            'success' => true,
            'data' => [
                [
                    'Ref' => '8d5a980d-391c-11dd-90d9-001a92567626',
                    'Description' => 'Kyiv',
                ]
            ],
            'errors' => [],
            'warnings' => [],
            'info' => [],
        ],
    ],
    
    // Mock for a failed request
    'Address.getWarehouses' => [
        'response' => [
            'success' => false,
            'data' => [],
            'errors' => ['API error message'],
            'warnings' => [],
            'info' => [],
        ],
        'statusCode' => 400,
    ],
];

// Set the mock responses
$sdk->setMockResponses($mockResponses);

// Now SDK will use mock responses instead of making actual API calls
$areas = $sdk->address()->getAreas();
// $areas will contain the mock data

// For requests with matching parameters
$cities = $sdk->address()->getCities(null, 'Kyiv');
// $cities will contain the mock data because parameters match

// Clear mock responses to revert to normal behavior
$sdk->clearMockResponses();
```

The mock responses system supports parameter matching, allowing you to define different responses based on the input parameters. This is particularly useful for testing different scenarios with the same API method.

Each mock response should be structured as follows:

- Use `'response'` to define the full response structure (including `success`, `data`, `errors`, etc.)
- Optionally use `'params'` to define parameters that must match for this mock to be used
- Optionally set `'statusCode'` (defaults to 200) to simulate different HTTP status codes

When using this feature in your tests, it's recommended to always clear mock responses after each test to ensure that tests don't affect each other.

## Exceptions

The SDK uses an exception system for error handling:

- `NovaPoshtaApiException` - Exception that occurs with Nova Poshta API errors
- `NovaPoshtaHttpException` - Exception that occurs with HTTP errors

```php
try {
    $result = $sdk->address()->getAreas();
} catch (AUnhurian\NovaPoshta\SDK\Exceptions\NovaPoshtaApiException $e) {
    // Nova Poshta API error
    echo "API error: " . $e->getMessage();
} catch (AUnhurian\NovaPoshta\SDK\Exceptions\NovaPoshtaHttpException $e) {
    // HTTP error (network error)
    echo "HTTP error: " . $e->getMessage();
} catch (Exception $e) {
    // Other errors
    echo "Error: " . $e->getMessage();
}
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details. 

// Parameters for warehouses search
$warehouseParams = [
    'FindByString' => 'Department'
    // Other parameters...
]; 