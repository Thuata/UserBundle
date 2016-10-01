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

namespace Thuata\UserBundle\Component;

use Thuata\UserBundle\Exception\AclExistingValueException;
use Thuata\UserBundle\Exception\AclInvalidValueException;

/**
 * <b>AclMapper</b><br>
 * Provides conversion from and to the different roles display.<br><ul>
 * <li>A binary role an integer in witch each role is represented by a bit. ie : 0b01001 (int : 9)</li>
 * <li>A role (name) is a string constant representing the role ie : role_admin<./li>
 * <li>A human role is the human readable representation of the role. ie : "Administrator"</li></ul>
 * Roles and human roles can be in arrays<br>
 * To be converted a role must be added througt the add version or being configured in the application config file
 *
 * @package Thuata\UserBundle\Component
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
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
     * @var array
     */
    private $metaRolesRegistry;

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
     * @return AclMapper
     *
     * @throws AclExistingValueException
     * @throws AclInvalidValueException
     */
    public function addRole($name, $value, $human)
    {
        if (!is_int($value) and substr_count(decbin($value), '1') > 1) {
            throw new AclInvalidValueException($value);
        }

        if ($this->getRoleFromBitRole($value)) {
            throw new AclExistingValueException($value, $name, $this->getRoleFromBitRole($value));
        }

        $this->rolesRegistry[ $name ] = $value;
        $this->humanRegistry[ $name ] = $human;

        return $this;
    }

    /**
     * Gets the role corresponding to $value
     *
     * @param integer $value
     *
     * @return string
     *
     * @throws \Thuata\UserBundle\Exception\AclInvalidValueException
     */
    public function getRoleFromBitRole($value)
    {
        if (!is_int($value) and substr_count(decbin($value), '1') > 1) {
            throw new AclInvalidValueException($value);
        }

        return array_search($value, $this->rolesRegistry);
    }

    /**
     * @param string $role
     *
     * @return mixed
     */
    public function getHumanFromRole($role)
    {
        return $this->humanRegistry[ $role ];
    }

    /**
     * Gets an array of roles from a binary role
     *
     * @param int $binaryRole
     *
     * @return array
     */
    public function getRolesFromBinaryRole($binaryRole)
    {
        $bit = 0b01;
        $roles = [];

        do {
            if (($binaryRole & $bit) == $bit) {
                $roles[] = $this->getRoleFromBitRole($bit);
            }

            $bit = $bit << 1;
        } while ($bit <= $binaryRole);

        return $roles;
    }

    /**
     * Gets an array of roles from a binary role
     *
     * @param array $roles
     *
     * @return int
     */
    public function getBinaryRoleFromRoles(array $roles)
    {
        $result = 0;
        foreach ($roles as $role) {
            $result += $this->getBitFromRole($role);
        }

        return $result;
    }

    /**
     * Gets an array of human roles from a list of roles
     *
     * @param array $roles
     *
     * @return array
     */
    public function getHumanFromRoles(array $roles)
    {
        $result = [];
        foreach ($roles as $role) {
            $result[] = $this->getHumanFromRole($role);
        }

        return $result;
    }

    /**
     * Gets a list of human roles from a binary role list
     *
     * @param int $binaryRole
     *
     * @return array
     */
    public function getHumanFromBinaryRole($binaryRole)
    {
        return $this->getHumanFromRoles($this->getRolesFromBinaryRole($binaryRole));
    }

    /**
     * Gets the bit value from a role
     *
     * @param string $role
     *
     * @return integer
     */
    public function getBitFromRole($role)
    {
        return $this->rolesRegistry[ $role ];
    }

    /**
     * Adds a meta role
     *
     * @param string $name
     * @param array $roles
     */
    public function addMetaRole($name, array $roles)
    {
        $this->metaRolesRegistry[ $name ] = $this->getBinaryRoleFromRoles($roles);
    }

    /**
     * Gets the binary from a metarole
     *
     * @param string $metaRole
     *
     * @return int
     */
    public function getBinaryFromMetaRole($metaRole)
    {
        return $this->metaRolesRegistry[ $metaRole ];
    }

    /**
     * Gets a human list of roles from a metarole
     *
     * @param string $metaRole
     *
     * @return array
     */
    public function getHumanFromMetaRole($metaRole)
    {
        return $this->getHumanFromBinaryRole($this->getBinaryFromMetaRole($metaRole));
    }
}