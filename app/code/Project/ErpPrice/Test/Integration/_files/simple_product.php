<?php

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\Product\Visibility;
use Magento\TestFramework\Helper\Bootstrap;

/** @var $product Product */
$product = Bootstrap::getObjectManager()->create(Product::class);
$product->setTypeId(
    Type::TYPE_SIMPLE
)->setAttributeSetId(
    4
)->setStoreId(
    1
)->setWebsiteIds(
    [1]
)->setName(
    'Simple Product Three'
)->setSku(
    'simple'
)->setPrice(
    100
)->setStockData(
    ['use_config_manage_stock' => 0]
)->setVisibility(
    Visibility::VISIBILITY_BOTH
)->setStatus(
    Status::STATUS_ENABLED
)->save();
