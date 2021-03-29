<?php

declare(strict_types=1);

namespace Project\ErpPrice\Api\Data;

/**
 * Interface PriceResultInterface
 * @api
 */
interface PriceResultInterface
{
    /**
     * @return float|null
     */
    public function getPrice():? float;

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void;
}
