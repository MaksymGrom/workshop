<?php

namespace Project\ErpPrice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ErpPrice extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'erp_price_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('erp_price', 'entity_id');
    }

    public function insertOnDuplicate(array $data)
    {
        if (empty($data)) {
            return 0;
        }

        return $this->getConnection()->insertOnDuplicate(
            $this->getMainTable(),
            $data,
            ['price', 'sku']
        );
    }
}
