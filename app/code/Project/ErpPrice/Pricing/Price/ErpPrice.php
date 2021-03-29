<?php

declare(strict_types=1);

namespace Project\ErpPrice\Pricing\Price;

use Magento\Framework\Pricing\Adjustment\CalculatorInterface;
use Magento\Framework\Pricing\Price\AbstractPrice;
use Magento\Framework\Pricing\Price\BasePriceProviderInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Pricing\SaleableInterface;
use Project\ErpPrice\Api\GetPriceServiceInterface;
use Project\ErpPrice\Model\ErpPriceConfig;

/**
 * Class ErpPrice
 */
class ErpPrice extends AbstractPrice implements BasePriceProviderInterface
{
    /**
     * Price type identifier string
     */
    const PRICE_CODE = 'erp_price';

    /**
     * @var ErpPriceConfig
     */
    private $erpPriceConfig;

    /**
     * @var GetPriceServiceInterface
     */
    private $getPriceService;

    /**
     * ErpPrice constructor.
     * @param SaleableInterface $saleableItem
     * @param float $quantity
     * @param CalculatorInterface $calculator
     * @param PriceCurrencyInterface $priceCurrency
     * @param ErpPriceConfig $erpPriceConfig
     * @param GetPriceServiceInterface $getPriceService
     */
    public function __construct(
        SaleableInterface $saleableItem,
        $quantity,
        CalculatorInterface $calculator,
        PriceCurrencyInterface $priceCurrency,
        ErpPriceConfig $erpPriceConfig,
        GetPriceServiceInterface $getPriceService
    ) {
        parent::__construct($saleableItem, $quantity, $calculator, $priceCurrency);
        $this->erpPriceConfig = $erpPriceConfig;
        $this->getPriceService = $getPriceService;
    }

    /**
     * Get Base Price Value
     *
     * @return float|bool
     */
    public function getValue()
    {
        if ($this->value === null) {
            $this->value = false;

            if (!$this->erpPriceConfig->isEnabled()) {
                return $this->value;
            }

            $priceResult = $this->getPriceService->execute($this->getProduct()->getSku());

            $this->value = $priceResult->getPrice() ?: false;
        }

        return $this->value;
    }
}
