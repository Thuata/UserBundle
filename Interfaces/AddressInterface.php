<?php

namespace Thuata\UserBundle\Interfaces;

/**
 * Address
 */
interface AddressInterface
{
    /**
     * Get id
     *
     * @return int
     */
    public function getId();

    /**
     * Set street
     *
     * @param string $street
     *
     * @return AddressInterface
     */
    public function setStreet($street);

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet();

    /**
     * Set secondaryStreet
     *
     * @param string $secondaryStreet
     *
     * @return AddressInterface
     */
    public function setSecondaryStreet($secondaryStreet);

    /**
     * Get secondaryStreet
     *
     * @return string
     */
    public function getSecondaryStreet();

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return AddressInterface
     */
    public function setZipCode($zipCode);

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode();

    /**
     * Set city
     *
     * @param string $city
     *
     * @return AddressInterface
     */
    public function setCity($city);

    /**
     * Get city
     *
     * @return string
     */
    public function getCity();

    /**
     * Set country
     *
     * @param string $country
     *
     * @return AddressInterface
     */
    public function setCountry($country);

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry();
}

