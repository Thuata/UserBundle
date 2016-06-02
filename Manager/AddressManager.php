<?php
/*
    Created by the Thuata's Intercession bundle.
    see https://github.com/Thuata/IntercessionBundle
*/

namespace Thuata\UserBundle\Manager;

use Thuata\FrameworkBundle\Manager\AbstractManager;
use Thuata\UserBundle\Entity\Address;

/**
 * Class AddressManager.
 */
class AddressManager extends AbstractManager
{
    /**
     * Returns the class name for the entity
     *
     * @return string
     */
    public function getEntityClassName()
    {
        return Address::class;
    }
}
