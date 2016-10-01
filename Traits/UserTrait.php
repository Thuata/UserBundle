<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Thuata\UserBundle\Traits;

use Thuata\ComponentBundle\SoftDelete\SoftDeletableTrait;
use Thuata\FrameworkBundle\Entity\Traits\TimestampableTrait;
use Thuata\UserBundle\Interfaces\UserInterface;
use Thuata\UserBundle\Component\AclMapper;

/**
 * <b>UserTrait</b><br>
 * Defines the methods from \Thuata\UserBundle\Entity\UserInterface
 *
 * @package Thuata\UserBundle\Entity
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
trait UserTrait
{

    use TimestampableTrait,
        SoftDeletableTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var integer
     */
    protected $roles;

    /**
     * Gets the id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the email
     *
     * @param string $email
     *
     * @return UserInterface
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;

        return $this;
    }

    /**
     * Gets the email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the password
     *
     * @param string $password
     *
     * @return UserInterface
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;

        return $this;
    }

    /**
     * Gets the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the salt
     *
     * @param string $salt
     *
     * @return UserInterface
     */
    public function setSalt($salt)
    {
        $this->salt = (string) $salt;

        return $this;
    }

    /**
     * Gets the salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the acl
     *
     * @param integer $roles
     *
     * @return UserInterface
     */
    public function setBinaryRoles($roles)
    {
        $this->roles = (int) $roles;

        return $this;
    }

    /**
     * Adds a role to the acl
     *
     * @param integer $roles
     *
     * @return UserInterface
     */
    public function addBinaryRoles($role)
    {
        $this->roles |= (int) $role;

        return $this;
    }

    /**
     * Gets the acl
     *
     * @return integer
     */
    public function getBinaryRoles()
    {
        return $this->roles;
    }

    /**
     * Converts a bit to a role
     *
     * @param int $bit Can either be an int of a square of 2 (1, 2, 4, 8) etc. or a binary number : 0b0001, 0b0010, etc
     *
     * @return string
     */
    protected function convertBitToRole($bit)
    {
        return AclMapper::getInstance()->getRoleFromBitRole($bit);
    }

    /**
     * Converts a string role to the correspondint bit
     */
    protected function convertRoleToBit($role)
    {
        return AclMapper::getInstance()->getBitFromRole($role);
    }

    /**
     * Erases the password and salt
     */
    public function eraseCredentials()
    {
        $this->password = null;
        $this->salt = null;
    }

    /**
     * Gets the roles corresponding to acl
     *
     * @return array
     */
    public function getRoles()
    {
        $bit = 0b01;
        $roles = [];

        do {
            if (($this->getBinaryRoles() & $bit) == $bit) {
                $roles[] = $this->convertBitToRole($bit);
            }
        } while ($bit <= $this->getBinaryRoles());

        return $roles;
    }

    /**
     * Gets the username (name)
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getEmail();
    }
}
