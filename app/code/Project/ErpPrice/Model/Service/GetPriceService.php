<?php

declare(strict_types=1);

namespace Project\ErpPrice\Model\Service;

use Project\ErpPrice\Api\Data\PriceResultInterface;
use Project\ErpPrice\Api\Data\PriceResultInterfaceFactory;
use Project\ErpPrice\Api\GetPriceServiceInterface;
use Project\ErpPrice\Model\ResourceModel\ErpPrice\Collection;
use Project\ErpPrice\Model\ResourceModel\ErpPrice\CollectionFactory;

/**
 * {@inheritDoc}
 */
class GetPriceService implements GetPriceServiceInterface
{
    /**
     * @var PriceResultInterfaceFactory
     */
    private $priceResultFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * GetPriceService constructor.
     * @param PriceResultInterfaceFactory $priceResultFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        PriceResultInterfaceFactory $priceResultFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->priceResultFactory = $priceResultFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(string $sku): PriceResultInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        /** @var PriceResultInterface $priceResult */
        $priceResult = $this->priceResultFactory->create();

        $collection->addFieldToFilter('sku', $sku)
            ->setPageSize(1)
            ->setCurPage(1);

        $price = (float)$collection->getFirstItem()->getPrice();

        if ($price > 0) {
            $priceResult->setPrice($price);
        }

        return $priceResult;
    }
}
