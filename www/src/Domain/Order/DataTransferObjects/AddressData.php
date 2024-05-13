<?php

namespace Domain\Order\DataTransferObjects;

use Spatie\LaravelData\Data;

class AddressData extends Data
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $surname,
        public readonly ?string $company_name,
        public readonly ?string $phone,
        public readonly ?string $email,
        public readonly ?string $country,
        public readonly ?string $state,
        public readonly ?string $city,
        public readonly ?string $address,
        public readonly ?string $address_2,
        public readonly ?string $zip_code,
        public readonly ?string $telegram_username,
        public readonly ?string $note = null,
    ) {
    }

    /**
     * Parse response from WordPress API
     */
    public static function fromResponse(array $address, ?string $telegram_username = null): self
    {
        return new self(
            name: $address['first_name'],
            surname: $address['last_name'],
            company_name: $address['company'],
            phone: $address['phone'],
            email: $address['email'],
            country: $address['country'],
            state: $address['state'],
            city: $address['city'],
            address: $address['address_1'],
            address_2: $address['address_2'],
            zip_code: $address['postcode'],
            telegram_username: $telegram_username,
        );
    }
}
