<?php

namespace Project\ErpPrice\Model\ResourceModel\ErpPrice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Project\ErpPrice\Model\ErpPrice as Model;
use Project\ErpPrice\Model\ResourceModel\ErpPrice as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'erp_price_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
