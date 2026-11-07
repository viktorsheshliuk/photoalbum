<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Api;

/**
 * Document API module for Nova Poshta API (shipments, TTNs)
 */
class DocumentApi extends BaseApi
{
    /**
     * @inheritDoc
     */
    protected string $modelName = 'InternetDocument';

    /**
     * Create a new shipping document (TTN)
     *
     * @param array $params Shipment parameters
     * @return array
     */
    public function save(array $params): array
    {
        return $this->request('save', $params);
    }

    /**
     * Delete a shipping document (TTN)
     *
     * @param string $documentRef Document reference ID
     * @return array
     */
    public function delete(string $documentRef): array
    {
        return $this->request('delete', [
            'DocumentRefs' => $documentRef,
        ]);
    }

    /**
     * Get the estimated shipping cost
     *
     * @param string $citySender City sender reference ID
     * @param string $cityRecipient City recipient reference ID
     * @param string $weight Weight in kg
     * @param int $cost Declared value
     * @param string $serviceType Service type (e.g., 'WarehouseWarehouse')
     * @param int|null $cargoType Cargo type reference ID
     * @param int|null $seatsAmount Number of seats
     * @param string|null $packageType Package type reference ID
     * @param int|null $width Width in cm
     * @param int|null $height Height in cm
     * @param int|null $length Length in cm
     * @return array
     */
    public function getDocumentPrice(
        string $citySender,
        string $cityRecipient,
        string $weight,
        int $cost,
        string $serviceType,
        ?int $cargoType = null,
        ?int $seatsAmount = null,
        ?string $packageType = null,
        ?int $width = null,
        ?int $height = null,
        ?int $length = null
    ): array {
        $params = [
            'CitySender' => $citySender,
            'CityRecipient' => $cityRecipient,
            'Weight' => $weight,
            'Cost' => $cost,
            'ServiceType' => $serviceType,
        ];

        if ($cargoType !== null) {
            $params['CargoType'] = $cargoType;
        }

        if ($seatsAmount !== null) {
            $params['SeatsAmount'] = $seatsAmount;
        }

        if ($packageType !== null) {
            $params['PackCalculate'] = [
                'PackRef' => $packageType,
            ];
        }

        if ($width !== null && $height !== null && $length !== null) {
            $params['OptionsSeat'] = [
                [
                    'weight' => $weight,
                    'volumetricWidth' => $width,
                    'volumetricHeight' => $height,
                    'volumetricLength' => $length,
                ],
            ];
        }

        return $this->request('getDocumentPrice', $params);
    }

    /**
     * Calculate delivery date
     *
     * @param string $citySender City sender reference ID
     * @param string $cityRecipient City recipient reference ID
     * @param string $serviceType Service type (e.g., 'WarehouseWarehouse')
     * @param string|null $dateTime Date time (defaults to current date)
     * @return array
     */
    public function getDocumentDeliveryDate(
        string $citySender,
        string $cityRecipient,
        string $serviceType,
        ?string $dateTime = null
    ): array {
        $params = [
            'CitySender' => $citySender,
            'CityRecipient' => $cityRecipient,
            'ServiceType' => $serviceType,
        ];

        if ($dateTime !== null) {
            $params['DateTime'] = $dateTime;
        }

        return $this->request('getDocumentDeliveryDate', $params);
    }

    /**
     * Get list of shipments (TTNs)
     *
     * @param string|null $dateTimeFrom Start date (format: dd.mm.yyyy)
     * @param string|null $dateTimeTo End date (format: dd.mm.yyyy)
     * @param string|null $page Page number
     * @param string|null $limit Items per page
     * @return array
     */
    public function getDocumentList(
        ?string $dateTimeFrom = null,
        ?string $dateTimeTo = null,
        ?string $page = null,
        ?string $limit = null
    ): array {
        $params = [];

        if ($dateTimeFrom !== null) {
            $params['DateTimeFrom'] = $dateTimeFrom;
        }

        if ($dateTimeTo !== null) {
            $params['DateTimeTo'] = $dateTimeTo;
        }

        if ($page !== null) {
            $params['Page'] = $page;
        }

        if ($limit !== null) {
            $params['Limit'] = $limit;
        }

        return $this->request('getDocumentList', $params);
    }

    /**
     * Get shipment (TTN) by reference ID
     *
     * @param string $ref Shipment reference ID
     * @return array
     */
    public function getDocument(string $ref): array
    {
        return $this->request('getDocument', [
            'Ref' => $ref,
        ]);
    }

    /**
     * Generate an electronic waybill (e-TTN)
     *
     * @param string $ref Shipment reference ID
     * @param string|null $type Type of the document (html, pdf, pdf_a4, pdf_a5, json)
     * @return array
     */
    public function generateReport(string $ref, ?string $type = null): array
    {
        $params = [
            'DocumentRefs' => $ref,
        ];

        if ($type !== null) {
            $params['Type'] = $type;
        }

        return $this->request('generateReport', $params);
    }
}
