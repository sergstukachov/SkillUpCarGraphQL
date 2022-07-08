<?php

namespace SkillUp\CarsGraphQL\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class DataCars extends AbstractDb
{
    public function _construct(){
        $this->_init("skillup_cars","id");
    }
}
