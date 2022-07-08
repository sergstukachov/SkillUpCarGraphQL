<?php

namespace SkillUp\CarsGraphQL\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\DB\TransactionFactory;
use SkillUp\CarsGraphQL\Model\DataCarsFactory;

/**
 * Patch for update data in 'skillup_cars' table
 */
class TableCars implements DataPatchInterface
{
    /**
     * Table name
     */
    private const TABLE_NAME = 'skillup_cars';

    /**
     * Fild name : Car brand
     */
    private const CAR_BRAND  = 'brand';

    /**
     * Fild name: Car model
     */
    private const CAR_MODEL = 'model';


    /**
     * @var TransactionFactory
     */
    private $transactionModel;

    /**
     * @var DataCarsFactory
     */
    private $modelFactory;

    public function __construct(
        TransactionFactory $transactionFactory,
        DataCarsFactory $dataCarFactory
    ) {
        $this->transactionModel = $transactionFactory;
        $this->modelFactory = $dataCarFactory;
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return DataPatchInterface|void
     * @throws \Exception
     */
    public function apply()
    {
        $statusData = [
            [
                self::CAR_BRAND => 'ford',
                self::CAR_MODEL => 'fiesta',
            ],
            [
                self::CAR_BRAND => 'bmw',
                self::CAR_MODEL => 'x5',
            ],
            [
                self::CAR_BRAND => 'fiat',
                self::CAR_MODEL => 'punto',
            ],
            [
                self::CAR_BRAND => 'vaz',
                self::CAR_MODEL => '2109',
            ],
            [
                self::CAR_BRAND => 'pegoute',
                self::CAR_MODEL => '206',
            ],
        ];

        $transactionalModel = $this->transactionModel->create();

        foreach ($statusData as $data) {
            $model = $this->modelFactory->create();
            $model->addData($data);
            $transactionalModel->addObject($model);
        }

        $transactionalModel->save();
    }
}
{

}
