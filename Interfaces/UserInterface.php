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

namespace Thuata\UserBundle\Interfaces;

use Thuata\ComponentBundle\SoftDelete\SoftDeleteInterface;
use Thuata\FrameworkBundle\Entity\Interfaces\TimestampableInterface;

/**
 * <b>UserInterface</b><br>
 * Provides methods for a user entity? The default ORM configuration can be found in
 * vendor/thuata/userbundle/Resources/config/doctrine/User.orm.dist.yml.<br>
 * <i>About roles</i> : ThuataUserBundle provides bitwise roles. Each role correspond to a bit, the sum of roles for
 * a user gives an integer.<br>
 * That integer is stored in database and can be converted to an array of strings using the getRole method provided by
 * the UserTrait.<br>
 * The Thuata\UserBundle\Component\AclMapper class provides static methods the convert a bit role to a string role and
 * inverse.
 * Roles are defined
 *
 * @package thuata\userbundle\Entity
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
interface UserInterface extends
    \Symfony\Component\Security\Core\User\UserInterface,
    SoftDeleteInterface, TimestampableInterface
{

    /**
     * Sets the email
     *
     * @param string $email
     *
     * @return UserInterface
     */
    public function setEmail($email);

    /**
     * Gets the email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Gets the binary rôle
     *
     * @return int
     */
    public function getRinaryRoles();

    /**
     * Adds a binary rôle
     *
     * @param int $role
     *
     * @return UserInterface
     */
    public function addBinaryRole($role);

    /**
     * Sets the binary roles
     *
     * @param int $role
     *
     * @return UserInterface
     */
    public function setBinaryRole($role);
}