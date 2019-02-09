<?php

declare(strict_types = 1);

namespace Domain\Common\ValueObject;

/**
 * Description of Location
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class Location
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $province;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $zipCode;

    public function address(): string
    {
        return $this->address;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function province(): string
    {
        return $this->province;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function zipCode(): string
    {
        return $this->zipCode;
    }

    public function __construct(string $address, string $city, string $province, string $country, string $zipCode)
    {
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->zipCode = $zipCode;
        $this->province = $province;
    }
}
