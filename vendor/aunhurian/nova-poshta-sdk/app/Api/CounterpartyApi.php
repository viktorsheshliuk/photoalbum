<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Api;

/**
 * Counterparty API module for Nova Poshta API
 */
class CounterpartyApi extends BaseApi
{
    /**
     * @inheritDoc
     */
    protected string $modelName = 'Counterparty';

    /**
     * Create a new counterparty (customer, organization)
     *
     * @param string $counterpartyType Type of counterparty ('PrivatePerson' or 'Organization')
     * @param string $firstName First name (for PrivatePerson)
     * @param string $lastName Last name (for PrivatePerson)
     * @param string $middleName Middle name (for PrivatePerson)
     * @param string|null $phone Phone number (for PrivatePerson)
     * @param string|null $email Email (for PrivatePerson)
     * @param string|null $companyName Company name (for Organization)
     * @param string|null $edrpou EDRPOU code (for Organization)
     * @return array
     */
    public function save(
        string $counterpartyType,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $middleName = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $companyName = null,
        ?string $edrpou = null
    ): array {
        $params = [
            'CounterpartyType' => $counterpartyType,
            'CounterpartyProperty' => 'Recipient',
        ];

        if ($counterpartyType === 'PrivatePerson') {
            $params['FirstName'] = $firstName;
            $params['LastName'] = $lastName;
            $params['MiddleName'] = $middleName;

            if ($phone !== null) {
                $params['Phone'] = $phone;
            }

            if ($email !== null) {
                $params['Email'] = $email;
            }
        } elseif ($counterpartyType === 'Organization') {
            $params['CompanyName'] = $companyName;
            $params['EDRPOU'] = $edrpou;
        }

        return $this->request('save', $params);
    }

    /**
     * Update a counterparty (customer, organization)
     *
     * @param string $ref Counterparty reference ID
     * @param string $counterpartyType Type of counterparty ('PrivatePerson' or 'Organization')
     * @param string|null $firstName First name (for PrivatePerson)
     * @param string|null $lastName Last name (for PrivatePerson)
     * @param string|null $middleName Middle name (for PrivatePerson)
     * @param string|null $phone Phone number (for PrivatePerson)
     * @param string|null $email Email (for PrivatePerson)
     * @param string|null $companyName Company name (for Organization)
     * @param string|null $edrpou EDRPOU code (for Organization)
     * @return array
     */
    public function update(
        string $ref,
        string $counterpartyType,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $middleName = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $companyName = null,
        ?string $edrpou = null
    ): array {
        $params = [
            'Ref' => $ref,
            'CounterpartyType' => $counterpartyType,
            'CounterpartyProperty' => 'Recipient',
        ];

        if ($counterpartyType === 'PrivatePerson') {
            if ($firstName !== null) {
                $params['FirstName'] = $firstName;
            }

            if ($lastName !== null) {
                $params['LastName'] = $lastName;
            }

            if ($middleName !== null) {
                $params['MiddleName'] = $middleName;
            }

            if ($phone !== null) {
                $params['Phone'] = $phone;
            }

            if ($email !== null) {
                $params['Email'] = $email;
            }
        } elseif ($counterpartyType === 'Organization') {
            if ($companyName !== null) {
                $params['CompanyName'] = $companyName;
            }

            if ($edrpou !== null) {
                $params['EDRPOU'] = $edrpou;
            }
        }

        return $this->request('update', $params);
    }

    /**
     * Delete a counterparty
     *
     * @param string $ref Counterparty reference ID
     * @return array
     */
    public function delete(string $ref): array
    {
        return $this->request('delete', [
            'Ref' => $ref,
        ]);
    }

    /**
     * Get counterparty addresses
     *
     * @param string $ref Counterparty reference ID
     * @param string $counterpartyProperty Counterparty property ('Sender' or 'Recipient')
     * @return array
     */
    public function getCounterpartyAddresses(string $ref, string $counterpartyProperty = 'Recipient'): array
    {
        return $this->request('getCounterpartyAddresses', [
            'Ref' => $ref,
            'CounterpartyProperty' => $counterpartyProperty,
        ]);
    }

    /**
     * Get counterparty contact persons
     *
     * @param string $ref Counterparty reference ID
     * @param string $counterpartyProperty Counterparty property ('Sender' or 'Recipient')
     * @return array
     */
    public function getCounterpartyContactPersons(string $ref, string $counterpartyProperty = 'Recipient'): array
    {
        return $this->request('getCounterpartyContactPersons', [
            'Ref' => $ref,
            'CounterpartyProperty' => $counterpartyProperty,
        ]);
    }

    /**
     * Get counterparty options
     *
     * @param string $ref Counterparty reference ID
     * @return array
     */
    public function getCounterpartyOptions(string $ref): array
    {
        return $this->request('getCounterpartyOptions', [
            'Ref' => $ref,
        ]);
    }

    /**
     * Search for counterparties
     *
     * @param string $findByString Search query
     * @param string $counterpartyProperty Counterparty property ('Sender' or 'Recipient')
     * @param int|null $page Page number
     * @param int|null $limit Items per page
     * @return array
     */
    public function getCounterparties(
        string $findByString,
        string $counterpartyProperty = 'Recipient',
        ?int $page = null,
        ?int $limit = null
    ): array {
        $params = [
            'FindByString' => $findByString,
            'CounterpartyProperty' => $counterpartyProperty,
        ];

        if ($page !== null) {
            $params['Page'] = $page;
        }

        if ($limit !== null) {
            $params['Limit'] = $limit;
        }

        return $this->request('getCounterparties', $params);
    }
}
