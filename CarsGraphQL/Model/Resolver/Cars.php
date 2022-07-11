<?php

namespace SkillUp\CarsGraphQL\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Webapi\ServiceOutputProcessor;
use SkillUp\CarsGraphQL\Model\ResourceModel\DataCars\CollectionFactory;


class Cars implements ResolverInterface
{
    /**
     * @var ValueFactory
     */
    private $valueFactory;

    /**
     * @var CollectionFactory
     */
    private $carFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param ValueFactory $valueFactory
     * @param CollectionFactory $carFactory
     * @param ServiceOutputProcessor $serviceOutputProcessor
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ValueFactory $valueFactory,
        CollectionFactory $carFactory,
        ServiceOutputProcessor $serviceOutputProcessor,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->valueFactory = $valueFactory;
        $this->carFactory = $carFactory;
        $this->serviceOutputProcessor = $serviceOutputProcessor;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) : Value {

        try {
            $data = $this->getCarData($args);
            $result = function () use ($data) {
                return !empty($data) ? $data : [];
            };
            return $this->valueFactory->create($result);
        } catch (NoSuchEntityException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        } catch (LocalizedException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        }
    }

    private function getCarData($args) : array
    {
        try {
            $carData = [];
            $carCollection = $this->carFactory->create();
            if(isset($args['filter']['id'])) {
                $carCollection->addFieldToFilter('id', $args['filter']['id']);
            }
            elseif(isset($args['filter']['brand'])) {
                $carCollection->addFieldToFilter('brand', $args['filter']['brand']);
            }
            elseif(isset($args['filter']['model'])) {
                $carCollection->addFieldToFilter('model', $args['filter']['model']);
            }
            foreach ($carCollection as $car) {
                array_push($carData, $car->getData());
            }
            return $carData;
        } catch (NoSuchEntityException $e) {
            return [];
        } catch (LocalizedException $e) {
            throw new NoSuchEntityException(__($e->getMessage()));
        }
    }
}
