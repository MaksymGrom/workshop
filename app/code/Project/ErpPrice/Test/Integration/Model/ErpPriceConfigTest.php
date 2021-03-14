<?php

declare(strict_types=1);

namespace Project\ErpPrice\Test\Integration\Model;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\Framework\ObjectManagerInterface;
use PHPUnit\Framework\TestCase;
use Project\ErpPrice\Model\ErpPriceConfig;

class ErpPriceConfigTest extends TestCase
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ErpPriceConfig
     */
    private $erpPriceConfig;

    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->erpPriceConfig = $this->objectManager->get(ErpPriceConfig::class);
    }

    public function testIsDefaultDisabled()
    {
        $this->assertFalse($this->erpPriceConfig->isEnabled());
    }

    /**
     * @magentoConfigFixture project/erp_price/enabled 1
     */
    public function testEnabled()
    {
        $this->assertTrue($this->erpPriceConfig->isEnabled());
    }
}
