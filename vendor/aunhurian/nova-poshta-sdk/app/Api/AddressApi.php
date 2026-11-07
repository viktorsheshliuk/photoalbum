<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Api;

/**
 * Address API module for Nova Poshta API
 */
class AddressApi extends BaseApi
{
    /**
     * @inheritDoc
     */
    protected string $modelName = 'Address';

    /**
     * Search for settlements (cities, villages)
     *
     * @param string $search Search query
     * @param int $page Page number (default: 1)
     * @param int $limit Items per page (default: 20)
     * @return array
     */
    public function searchSettlements(string $search, int $page = 1, int $limit = 20): array
    {
        return $this->request('searchSettlements', [
            'CityName' => $search,
            'Limit' => $limit,
            'Page' => $page,
        ]);
    }

    /**
     * Search for streets in a settlement
     *
     * @param string $settlementRef Settlement reference ID
     * @param string $search Search query
     * @param int $page Page number (default: 1)
     * @param int $limit Items per page (default: 20)
     * @return array
     */
    public function searchSettlementStreets(string $settlementRef, string $search, int $page = 1, int $limit = 20): array
    {
        return $this->request('searchSettlementStreets', [
            'SettlementRef' => $settlementRef,
            'StreetName' => $search,
            'Limit' => $limit,
            'Page' => $page,
        ]);
    }

    /**
     * Get a list of regions (oblasts)
     *
     * @return array
     */
    public function getAreas(): array
    {
        return $this->request('getAreas');
    }

    /**
     * Get a list of cities
     *
     * @param string|null $ref City reference ID
     * @param string|null $findByString Search query
     * @param int|null $page Page number
     * @param int|null $limit Items per page
     * @return array
     */
    public function getCities(?string $ref = null, ?string $findByString = null, ?int $page = null, ?int $limit = null): array
    {
        $params = [];

        if ($ref !== null) {
            $params['Ref'] = $ref;
        }

        if ($findByString !== null) {
            $params['FindByString'] = $findByString;
        }

        if ($page !== null) {
            $params['Page'] = $page;
        }

        if ($limit !== null) {
            $params['Limit'] = $limit;
        }

        return $this->request('getCities', $params);
    }

    /**
     * Get a list of warehouses (departments)
     *
     * @param string|null $cityRef City reference ID
     * @param string|null $findByString Search query
     * @param int|null $page Page number
     * @param int|null $limit Items per page
     * @param string|null $typeOfWarehouseRef Warehouse type reference ID
     * @return array
     */
    public function getWarehouses(
        ?string $cityRef = null,
        ?string $findByString = null,
        ?int $page = null,
        ?int $limit = null,
        ?string $typeOfWarehouseRef = null
    ): array {
        $params = [];

        if ($cityRef !== null) {
            $params['CityRef'] = $cityRef;
        }

        if ($findByString !== null) {
            $params['FindByString'] = $findByString;
        }

        if ($page !== null) {
            $params['Page'] = $page;
        }

        if ($limit !== null) {
            $params['Limit'] = $limit;
        }

        if ($typeOfWarehouseRef !== null) {
            $params['TypeOfWarehouseRef'] = $typeOfWarehouseRef;
        }

        return $this->request('getWarehouses', $params);
    }

    /**
     * Get a list of warehouse types
     *
     * @return array
     */
    public function getWarehouseTypes(): array
    {
        return $this->request('getWarehouseTypes');
    }

    /**
     * Get a list of streets in a city
     *
     * @param string $cityRef City reference ID
     * @param string|null $findByString Search query
     * @param int|null $page Page number
     * @param int|null $limit Items per page
     * @return array
     */
    public function getStreet(
        string $cityRef,
        ?string $findByString = null,
        ?int $page = null,
        ?int $limit = null
    ): array {
        $params = [
            'CityRef' => $cityRef,
        ];

        if ($findByString !== null) {
            $params['FindByString'] = $findByString;
        }

        if ($page !== null) {
            $params['Page'] = $page;
        }

        if ($limit !== null) {
            $params['Limit'] = $limit;
        }

        return $this->request('getStreet', $params);
    }

    /**
     * Create a new address (counterparty address)
     *
     * @param string $counterpartyRef Counterparty reference ID
     * @param string $streetRef Street reference ID
     * @param string $buildingNumber Building number
     * @param string|null $flat Flat/apartment number
     * @param string|null $note Note
     * @return array
     */
    public function save(
        string $counterpartyRef,
        string $streetRef,
        string $buildingNumber,
        ?string $flat = null,
        ?string $note = null
    ): array {
        $params = [
            'CounterpartyRef' => $counterpartyRef,
            'StreetRef' => $streetRef,
            'BuildingNumber' => $buildingNumber,
        ];

        if ($flat !== null) {
            $params['Flat'] = $flat;
        }

        if ($note !== null) {
            $params['Note'] = $note;
        }

        return $this->request('save', $params);
    }

    /**
     * Delete an address
     *
     * @param string $ref Address reference ID
     * @return array
     */
    public function delete(string $ref): array
    {
        return $this->request('delete', [
            'Ref' => $ref,
        ]);
    }
}
