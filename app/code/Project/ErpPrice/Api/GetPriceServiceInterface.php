<?php

declare(strict_types=1);

namespace Project\ErpPrice\Api;

use Project\ErpPrice\Api\Data\PriceResultInterface;

/**
 * Interface GetPriceServiceInterface
 * @api
 */
interface GetPriceServiceInterface
{
    /**
     * @param string $sku
     * @return PriceResultInterface
     */
    public function execute(string $sku): PriceResultInterface;
}
