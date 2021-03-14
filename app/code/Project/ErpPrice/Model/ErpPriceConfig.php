<?php

declare(strict_types=1);

namespace Project\ErpPrice\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ErpPriceConfig
{
    const XML_PATH_PROJECT_ERP_PRICE_ENABLED = 'project/erp_price/enabled';
    const XML_PATH_PROJECT_ERP_PRICE_FILE_PATH = 'project/erp_price/file_path';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * ErpPriceConfig constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PROJECT_ERP_PRICE_ENABLED);
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PROJECT_ERP_PRICE_FILE_PATH);
    }
}
