<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Thuata\UserBundle\Manager;

use Thuata\FrameworkBundle\Manager\AbstractManager;
use Thuata\UserBundle\Entity\User;

/**
 * Description of UserManager
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
class UserManager extends AbstractManager
{
    /**
     * {@inheritdoc}
     */
    protected function getEntityClassName()
    {
        return User::class;
    }
}
