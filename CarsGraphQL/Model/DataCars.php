<?php

namespace SkillUp\CarsGraphQL\Model;

use Magento\Framework\Model\AbstractModel;

class DataCars extends AbstractModel
{
    public function _construct(){
        $this->_init("SkillUp\CarsGraphQL\Model\ResourceModel\DataCars");
    }
}
