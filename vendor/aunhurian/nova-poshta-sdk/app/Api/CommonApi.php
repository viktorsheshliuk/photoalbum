<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Api;

/**
 * Common API module for Nova Poshta API (reference data)
 */
class CommonApi extends BaseApi
{
    /**
     * @inheritDoc
     */
    protected string $modelName = 'Common';

    /**
     * Get list of cargo types
     *
     * @return array
     */
    public function getCargoTypes(): array
    {
        return $this->request('getCargoTypes');
    }

    /**
     * Get list of cargo description
     *
     * @param string|null $findByString Search query
     * @param int|null $page Page number
     * @param int|null $limit Items per page
     * @return array
     */
    public function getCargoDescriptionList(?string $findByString = null, ?int $page = null, ?int $limit = null): array
    {
        $params = [];

        if ($findByString !== null) {
            $params['FindByString'] = $findByString;
        }

        if ($page !== null) {
            $params['Page'] = $page;
        }

        if ($limit !== null) {
            $params['Limit'] = $limit;
        }

        return $this->request('getCargoDescriptionList', $params);
    }

    /**
     * Get messaging codes for the first order attempt
     *
     * @return array
     */
    public function getMessageCodeText(): array
    {
        return $this->request('getMessageCodeText');
    }

    /**
     * Get list of service types (delivery types)
     *
     * @return array
     */
    public function getServiceTypes(): array
    {
        return $this->request('getServiceTypes');
    }

    /**
     * Get list of pallet types
     *
     * @return array
     */
    public function getPalletsList(): array
    {
        return $this->request('getPalletsList');
    }

    /**
     * Get list of types of payers
     *
     * @return array
     */
    public function getTypesOfPayers(): array
    {
        return $this->request('getTypesOfPayers');
    }

    /**
     * Get list of types of payment
     *
     * @return array
     */
    public function getTypesOfPayment(): array
    {
        return $this->request('getTypesOfPayment');
    }

    /**
     * Get list of payment forms
     *
     * @return array
     */
    public function getPaymentForms(): array
    {
        return $this->request('getPaymentForms');
    }

    /**
     * Get list of time intervals
     *
     * @param string|null $recipientCityRef Recipient city reference ID
     * @param string|null $dateTime Date (format: dd.mm.yyyy)
     * @return array
     */
    public function getTimeIntervals(?string $recipientCityRef = null, ?string $dateTime = null): array
    {
        $params = [];

        if ($recipientCityRef !== null) {
            $params['RecipientCityRef'] = $recipientCityRef;
        }

        if ($dateTime !== null) {
            $params['DateTime'] = $dateTime;
        }

        return $this->request('getTimeIntervals', $params);
    }

    /**
     * Get list of package types
     *
     * @param string|null $lengthString Length in cm
     * @param string|null $widthString Width in cm
     * @param string|null $heightString Height in cm
     * @return array
     */
    public function getPackList(?string $lengthString = null, ?string $widthString = null, ?string $heightString = null): array
    {
        $params = [];

        if ($lengthString !== null) {
            $params['Length'] = $lengthString;
        }

        if ($widthString !== null) {
            $params['Width'] = $widthString;
        }

        if ($heightString !== null) {
            $params['Height'] = $heightString;
        }

        return $this->request('getPackList', $params);
    }

    /**
     * Get list of tires and wheels
     *
     * @return array
     */
    public function getTiresWheelsList(): array
    {
        return $this->request('getTiresWheelsList');
    }

    /**
     * Get list of backward delivery cargo types
     *
     * @return array
     */
    public function getBackwardDeliveryCargoTypes(): array
    {
        return $this->request('getBackwardDeliveryCargoTypes');
    }

    /**
     * Get list of ownership forms
     *
     * @return array
     */
    public function getOwnershipFormsList(): array
    {
        return $this->request('getOwnershipFormsList');
    }
}
