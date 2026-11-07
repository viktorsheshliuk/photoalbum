<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Api;

/**
 * Tracking API module for Nova Poshta API
 */
class TrackingApi extends BaseApi
{
    /**
     * @inheritDoc
     */
    protected string $modelName = 'TrackingDocument';

    /**
     * Get status of a shipment by its tracking number (TTN)
     *
     * @param string $documentNumber Tracking number (TTN)
     * @param string|null $phone Phone number (optional)
     * @return array
     */
    public function getStatusDocuments(string $documentNumber, ?string $phone = null): array
    {
        $document = [
            'DocumentNumber' => $documentNumber,
        ];

        if ($phone !== null) {
            $document['Phone'] = $phone;
        }

        return $this->request('getStatusDocuments', [
            'Documents' => [$document],
        ]);
    }

    /**
     * Get status of multiple shipments by their tracking numbers (TTNs)
     *
     * @param array $documents Array of documents, each with DocumentNumber and optional Phone
     * @return array
     */
    public function getStatusDocumentsBatch(array $documents): array
    {
        return $this->request('getStatusDocuments', [
            'Documents' => $documents,
        ]);
    }

    /**
     * Get the full tracking history of a shipment by its tracking number (TTN)
     *
     * @param string $documentNumber Tracking number (TTN)
     * @return array
     */
    public function getStatusHistory(string $documentNumber): array
    {
        return $this->request('getStatusHistory', [
            'Documents' => [
                [
                    'DocumentNumber' => $documentNumber,
                ],
            ],
        ]);
    }
}
