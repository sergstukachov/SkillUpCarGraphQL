<?php

namespace SkillUp\CarsGraphQL\Model\ResourceModel\DataCars;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct(){
        $this->_init("SkillUp\CarsGraphQL\Model\DataCars","SkillUp\CarsGraphQL\Model\ResourceModel\DataCars");
    }
}
