<?php

declare(strict_types=1);

namespace Project\ErpPrice\Model\Service;

use Project\ErpPrice\Api\Data\PriceResultInterface;
use Project\ErpPrice\Api\Data\PriceResultInterfaceFactory;
use Project\ErpPrice\Api\GetPriceServiceInterface;

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
     * GetPriceService constructor.
     * @param PriceResultInterfaceFactory $priceResultFactory
     */
    public function __construct(
        PriceResultInterfaceFactory $priceResultFactory
    ) {
        $this->priceResultFactory = $priceResultFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(string $sku): PriceResultInterface
    {
        /** @var PriceResultInterface $priceResult */
        $priceResult = $this->priceResultFactory->create();

        $priceResult->setPrice(1.);

        return $priceResult;
    }
}
