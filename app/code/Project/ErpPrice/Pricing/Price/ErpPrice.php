<?php

declare(strict_types=1);

namespace Project\ErpPrice\Pricing\Price;

use Magento\Framework\Pricing\Adjustment\CalculatorInterface;
use Magento\Framework\Pricing\Price\AbstractPrice;
use Magento\Framework\Pricing\Price\BasePriceProviderInterface;
use Magento\Framework\Pricing\SaleableInterface;
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
     * ErpPrice constructor.
     * @param SaleableInterface $saleableItem
     * @param $quantity
     * @param CalculatorInterface $calculator
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param ErpPriceConfig $erpPriceConfig
     */
    public function __construct(
        SaleableInterface $saleableItem,
        $quantity,
        CalculatorInterface $calculator,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        ErpPriceConfig $erpPriceConfig
    ) {
        parent::__construct($saleableItem, $quantity, $calculator, $priceCurrency);
        $this->erpPriceConfig = $erpPriceConfig;
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

            $this->value = 1.;
        }

        return $this->value;
    }
}
