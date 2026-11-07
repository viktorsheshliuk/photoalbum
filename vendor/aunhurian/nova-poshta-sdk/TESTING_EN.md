# Testing Nova Poshta SDK

This document describes the testing approach and procedures for Nova Poshta SDK.

## Testing Framework

The SDK uses PHPUnit for unit testing. All tests are located in the `tests` directory.

## Running Tests

To run the test suite:

```bash
vendor/bin/phpunit
```

To run a specific test:

```bash
vendor/bin/phpunit --filter TestClassName
```

## Test Structure

The test suite is organized according to the SDK's module structure:

- `tests/Unit/` - Unit tests for individual components
  - `tests/Unit/Api/AddressApiTest.php` - Tests for the AddressApi module
  - `tests/Unit/Api/CounterpartyApiTest.php` - Tests for the CounterpartyApi module
  - `tests/Unit/Api/DocumentApiTest.php` - Tests for the DocumentApi module
  - `tests/Unit/Api/TrackingApiTest.php` - Tests for the TrackingApi module
  - `tests/Unit/Api/CommonApiTest.php` - Tests for the CommonApi module
  - `tests/Unit/NovaPoshtaSDKTest.php` - Tests for the main SDK class
  - `tests/Unit/NovaPoshtaHttpClientTest.php` - Tests for the HTTP client

## Mocking Approach

Tests use the Mockery library to mock HTTP responses from the Nova Poshta API. This approach allows for testing without actual API calls.

Example of mocking HTTP responses:

```php
// Create a mock HTTP client
$httpClient = Mockery::mock(NovaPoshtaHttpClient::class);

// Define the expected request and response
$httpClient->shouldReceive('request')
    ->with('Address', 'getAreas', [])
    ->andReturn([
        'success' => true,
        'data' => [
            ['Ref' => '123', 'Description' => 'Area 1'],
            ['Ref' => '456', 'Description' => 'Area 2'],
        ],
    ]);

// Inject the mock client into the API class
$addressApi = new AddressApi($httpClient);

// Test the method
$result = $addressApi->getAreas();
```

## Using Mock Responses in Integration Tests

In addition to the Mockery approach described above, which is used internally for SDK unit tests, the SDK also provides a built-in mechanism for setting up mock responses that can be used in your own integration tests.

This approach is more convenient when you want to test your application's code that uses the Nova Poshta SDK, as it doesn't require you to modify the SDK's internals.

```php
// Create SDK instance with your API key
$sdk = new \AUnhurian\NovaPoshta\SDK\NovaPoshtaSDK('your_api_key');

// Set up mock responses
$mockResponses = [
    // Define a mock response for Address.getAreas
    'Address.getAreas' => [
        'response' => [
            'success' => true,
            'data' => [
                ['Ref' => '123', 'Description' => 'Area 1'],
                ['Ref' => '456', 'Description' => 'Area 2'],
            ],
            'errors' => [],
            'warnings' => [],
            'info' => []
        ],
    ],
    
    // Mock response for getCities with parameter matching
    'Address.getCities' => [
        'params' => [
            'FindByString' => 'Test City',
        ],
        'response' => [
            'success' => true,
            'data' => [
                ['Ref' => '789', 'Description' => 'Test City'],
            ],
            'errors' => [],
            'warnings' => [],
            'info' => []
        ],
    ],
];

// Apply the mock responses to the SDK
$sdk->setMockResponses($mockResponses);

// Now all API calls will use the mock data
$areas = $sdk->address()->getAreas();
// $areas will contain the mock data defined above

// Clean up after testing
$sdk->clearMockResponses();
```

The mock responses system supports parameter matching, which allows you to define different responses for the same API method based on the input parameters. This is particularly useful for testing different scenarios:

```php
$mockResponses = [
    // Different responses for getCities based on parameters
    'Address.getCities' => [
        'params' => [
            'FindByString' => 'Kyiv',
        ],
        'response' => [
            'success' => true,
            'data' => [
                ['Ref' => '123', 'Description' => 'Kyiv'],
            ],
            'errors' => [],
            'warnings' => [],
            'info' => []
        ],
    ],
    
    // Another mock for the same method but with different parameters
    'Address.getCities' => [
        'params' => [
            'FindByString' => 'Lviv',
        ],
        'response' => [
            'success' => true,
            'data' => [
                ['Ref' => '456', 'Description' => 'Lviv'],
            ],
            'errors' => [],
            'warnings' => [],
            'info' => []
        ],
    ],
    
    // Mock for error response
    'Address.getCities' => [
        'params' => [
            'FindByString' => 'Error',
        ],
        'response' => [
            'success' => false,
            'data' => [],
            'errors' => ['City not found'],
            'warnings' => [],
            'info' => []
        ],
        'statusCode' => 400,
    ],
];

$sdk->setMockResponses($mockResponses);

// Each call will get a different response based on parameters
$kyivCities = $sdk->address()->getCities(null, 'Kyiv');
$lvivCities = $sdk->address()->getCities(null, 'Lviv');

// This will throw an exception because success is false
try {
    $errorCities = $sdk->address()->getCities(null, 'Error');
} catch (NovaPoshtaApiException $e) {
    // Handle the exception
}
```

### Best Practices for Mock Responses

1. **Clear mocks after tests**: Always clear mock responses after each test to prevent interference between tests.

2. **Match the actual API structure**: Make sure your mock responses match the structure of actual Nova Poshta API responses.

3. **Test error scenarios**: Use mock responses to test how your code handles API errors by setting `'success' => false`.

4. **Use parameter matching**: When testing methods that accept different parameters, set up different mock responses for each parameter combination.

5. **Set appropriate status codes**: For error responses, set appropriate HTTP status codes to simulate real-world conditions.

## Writing New Tests

When adding new functionality or fixing bugs, follow these guidelines for writing tests:

1. **Test Method Naming**: Use descriptive method names that explain what is being tested, e.g., `testGetAreasReturnsExpectedData`.

2. **Test Isolation**: Each test should be independent. Do not rely on the state from other tests.

3. **AAA Pattern**: Structure your tests following the Arrange-Act-Assert pattern:
   - Arrange: Set up the test environment and mock dependencies
   - Act: Execute the method being tested
   - Assert: Verify the result matches expectations

4. **Coverage**: Aim for comprehensive test coverage, including:
   - Happy path tests (expected, normal operation)
   - Edge cases (boundary conditions)
   - Error handling (how the code responds to invalid inputs or failures)

5. **Test Readability**: Make tests easy to understand. Use clear variable names and comments where necessary.

Example of a well-structured test:

```php
public function testGetAreasReturnsExpectedData()
{
    // Arrange
    $mockResponse = [
        'success' => true,
        'data' => [
            ['Ref' => '123', 'Description' => 'Area 1'],
            ['Ref' => '456', 'Description' => 'Area 2'],
        ],
    ];
    
    $httpClient = Mockery::mock(NovaPoshtaHttpClient::class);
    $httpClient->shouldReceive('request')
        ->with('Address', 'getAreas', [])
        ->andReturn($mockResponse);
    
    $addressApi = new AddressApi($httpClient);
    
    // Act
    $result = $addressApi->getAreas();
    
    // Assert
    $this->assertCount(2, $result);
    $this->assertEquals('123', $result[0]['Ref']);
    $this->assertEquals('Area 1', $result[0]['Description']);
}
```

## Testing Error Handling

Test how your code handles errors from the API:

```php
public function testHandlesApiError()
{
    // Arrange
    $mockResponse = [
        'success' => false,
        'errors' => ['API error message'],
        'data' => [],
    ];
    
    $httpClient = Mockery::mock(NovaPoshtaHttpClient::class);
    $httpClient->shouldReceive('request')
        ->andReturn($mockResponse);
    
    $addressApi = new AddressApi($httpClient);
    
    // Act & Assert
    $this->expectException(NovaPoshtaApiException::class);
    $addressApi->getAreas();
}
```

## Test Coverage

The project aims for high test coverage. Use PHPUnit's coverage reports to identify untested code:

```bash
vendor/bin/phpunit --coverage-html coverage
```

This will generate an HTML coverage report in the `coverage` directory.

## Continuous Integration

Tests are run automatically in the CI/CD pipeline for every pull request and commit to the main branch. Please ensure all tests pass before submitting your changes. 