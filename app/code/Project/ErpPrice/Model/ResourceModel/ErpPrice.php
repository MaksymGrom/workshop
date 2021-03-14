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

    public function setAllIsDeleted()
    {
        return $this->getConnection()->update($this->getMainTable(), ['is_deleted' => '1']);
    }

    public function deleteIsDeleted()
    {
        return $this->getConnection()->delete($this->getMainTable(), 'is_deleted = 1');
    }

    public function insertOnDuplicate(array $data)
    {
        if (empty($data)) {
            return 0;
        }

        return $this->getConnection()->insertOnDuplicate(
            $this->getMainTable(),
            $data,
            ['price', 'sku', 'is_deleted']
        );
    }
}
