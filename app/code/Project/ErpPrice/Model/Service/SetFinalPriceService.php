<?php

declare(strict_types=1);

namespace Project\ErpPrice\Model\Service;

use Magento\Catalog\Model\Product;
use Project\ErpPrice\Api\GetPriceServiceInterface;
use Project\ErpPrice\Model\ErpPriceConfig;

/**
 * Class SetFinalPriceService
 *
 * Service responsible for set final price from ERP PRICES
 */
class SetFinalPriceService
{
    /**
     * @var ErpPriceConfig
     */
    private $erpPriceConfig;

    /**
     * @var GetPriceServiceInterface
     */
    private $getPriceService;

    /**
     * SetFinalPriceService constructor.
     * @param ErpPriceConfig $erpPriceConfig
     * @param GetPriceServiceInterface $getPriceService
     */
    public function __construct(
        ErpPriceConfig $erpPriceConfig,
        GetPriceServiceInterface $getPriceService
    ) {
        $this->erpPriceConfig = $erpPriceConfig;
        $this->getPriceService = $getPriceService;
    }

    /**
     * @param Product $product
     */
    public function execute(Product $product): void
    {

        if (!$this->erpPriceConfig->isEnabled()) {
            return;
        }

        $finalPrice = $product->getData('final_price');

        $priceResult = $this->getPriceService->execute($product->getSku());

        if ($priceResult->getPrice() === null) {
            return;
        }

        $product->setData('final_price', min($finalPrice, $priceResult->getPrice()));
    }
}
