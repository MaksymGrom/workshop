<?php

namespace Project\ErpPrice\Model;

use Magento\Framework\Model\AbstractModel;
use Project\ErpPrice\Model\ResourceModel\ErpPrice as ResourceModel;

/**
 * Class ErpPrice
 * @method getPrice(): float
 * @method setPrice(float $price): ErpPrice
 * @method getSku(): string
 * @method setSku(string $sku): ErpPrice
 * @method setIsDeleted(bool $isDeleted): ErpPrice
 */
class ErpPrice extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'erp_price_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
