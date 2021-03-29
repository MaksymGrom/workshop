<?php

declare(strict_types=1);

namespace Project\ErpPrice\Test\Integration\Model\Service;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\Framework\ObjectManagerInterface;
use PHPUnit\Framework\TestCase;
use Project\ErpPrice\Model\Service\GetErpPriceFileDataService;

class GetErpPriceFileDataServiceTest extends TestCase
{
    /**
     * @var GetErpPriceFileDataService
     */
    private $getErpPriceDataService;

    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->getErpPriceDataService = $this->objectManager->get(GetErpPriceFileDataService::class);
    }

    /**
     * @magentoConfigFixture project/erp_price/file_path /app/code/Project/ErpPrice/Test/Integration/_files/erp_price.json
     */
    public function testGetFileData()
    {
        $data = $this->getErpPriceDataService->execute();

        $this->assertCount(3, $data);

        foreach ($data as $priceData) {
            $this->assertTrue(in_array($priceData['id'], [1, 3, 5]));
            $this->assertTrue(in_array($priceData['price'], [1., 75., 350.]));
            $this->assertEquals('simple', $priceData['sku']);
        }
    }
}
