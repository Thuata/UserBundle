<?php
/*
 * The MIT License
 *
 * Copyright 2015 Anthony Maudry <anthony.maudry@thuata.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace thuata\userbundle\Component;
use Thuata\UserBundle\Exception\AclExistingValueExceprion;
use Thuata\UserBundle\Exception\AclInvalidValueException;

/**
 * Class AclMapper
 *
 * @package thuata\userbundle\Component
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
class AclMapper
{
    /**
     * @var array
     */
    private $rolesRegistry;

    /**
     * @var array
     */
    private $humanRegistry;

    /**
     * @var AclMapper
     */
    private static $instance;

    /**
     * Gets the AclMapper instance
     *
     * @return AclMapper
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * AclMapper constructor.
     */
    private function __construct()
    {
        $this->rolesRegistry = [];
        $this->humanRegistry = [];
    }

    /**
     * Ads a role
     *
     * @param $name
     * @param $value
     * @param $human
     *
     * @throws AclExistingValueExceprion
     * @throws AclInvalidValueException
     */
    public function addRole($name, $value, $human)
    {
        if (!is_int($value) and substr_count(decbin($value), '1') > 1) {
            throw new AclInvalidValueException($value);
        }
        
        if ($this->getRoleFromValue($value)) {
            throw new AclExistingValueExceprion($value, $name, $this->getRoleFromValue($value));
        }

        $this->rolesRegistry[$name] = $value;
        $this->humanRegistry[$name] = $human;
    }

    /**
     * Gets the role corresponding to $value
     *
     * @param integer $value
     *
     * @return string
     */
    public function getRoleFromValue($value)
    {
        return array_search($value, $this->rolesRegistry);
    }

    /**
     * @param string $role
     *
     * @return mixed
     */
    public function getHumanFromRole($role)
    {
        return $this->humanRegistry[$role];
    }
}