<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    App\Entity\Setting;

class SettingRepository extends EntityRepository
{
    /**
     * Saves a setting
     * 
     * @param Setting $setting
     * @param string $value 
     */
    public function saveSetting(Setting $setting, $value)
    {
        $setting->setValue($value);
        
        $this->getEntityManager()->persist($setting);
    }
}