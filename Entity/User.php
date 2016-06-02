<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Thuata\UserBundle\Entity;

use Thuata\FrameworkBundle\Entity\AbstractEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Thuata\FrameworkBundle\Entity\Interfaces\TimestampableInterface;
use Thuata\FrameworkBundle\Entity\Traits\TimestampableTrait;

/**
 * User super class. Provides mechanics for user
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
abstract class User extends AbstractEntity implements UserInterface, TimestampableInterface
{

    use TimestampableTrait;

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
    protected $acl;

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
     * @return \Thuata\UserBundle\Entity\User
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
     * Sets the first name
     *
     * @param string $firstName
     *
     * @return \Thuata\UserBundle\Entity\User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = (string) $firstName;

        return $this;
    }

    /**
     * Gets the first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the last name
     *
     * @param string $lastName
     *
     * @return \Thuata\UserBundle\Entity\User
     */
    public function setLastName($lastName)
    {
        $this->lastName = (string) $lastName;

        return $this;
    }

    /**
     * Gets the last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets the password
     *
     * @param string $password
     *
     * @return \Thuata\UserBundle\Entity\User
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
     * @return \Thuata\UserBundle\Entity\User
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
     * @param integer $acl
     *
     * @return \Thuata\UserBundle\Entity\User
     */
    public function setAcl($acl)
    {
        $this->acl = (int) $acl;

        return $this;
    }

    /**
     * Gets the acl
     *
     * @return integer
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * Converts a bit to a role
     *
     * @param int $bit Can either be an int of a square of 2 (1, 2, 4, 8) etc. or a binary number : 0b0001, 0b0010, etc
     *
     * @return string
     */
    abstract protected function convertBitToRole($bit);

    /**
     * Converts a string role to the correspondint bit
     */
    abstract protected function convertRoleToBit($role);

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
            if (($this->getAcl() & $bit) == $bit) {
                $roles[] = $this->convertBitToRole($bit);
            }
        } while ($bit <= $this->getAcl());

        return roles;
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

    /**
     * Gets the full name
     *
     * @return string
     */
    public function getFullName()
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
    }
}
