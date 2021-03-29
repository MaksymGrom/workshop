<?php

declare(strict_types=1);

use Magento\TestFramework\Helper\Bootstrap;
use Project\ErpPrice\Model\ErpPrice;
use Project\ErpPrice\Model\ResourceModel\ErpPrice as ErpPriceResource;

/** @var $eprPrice ErpPrice */
$eprPrice = Bootstrap::getObjectManager()->create(ErpPrice::class);

$eprPrice->setSku('simple');
$eprPrice->setPrice(1.);

/** @var ErpPriceResource $resourceModel */
$resourceModel = Bootstrap::getObjectManager()->get(ErpPriceResource::class);

$resourceModel->save($eprPrice);
