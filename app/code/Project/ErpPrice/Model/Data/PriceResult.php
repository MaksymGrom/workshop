<?php

declare(strict_types=1);

namespace Project\ErpPrice\Model\Data;

use Project\ErpPrice\Api\Data\PriceResultInterface;

/**
 * {@inheritDoc}
 */
class PriceResult implements PriceResultInterface
{
    /**
     * @var float|null
     */
    private $price = null;

    /**
     * {@inheritDoc}
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * {@inheritDoc}
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }
}
