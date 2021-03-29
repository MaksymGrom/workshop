<?php

declare(strict_types=1);

namespace Project\ErpPrice\Test\Integration\Api;

use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;
use Project\ErpPrice\Api\GetPriceServiceInterface;
use Project\ErpPrice\Model\ErpPrice;
use Project\ErpPrice\Model\ErpPriceFactory;
use Project\ErpPrice\Model\ResourceModel\ErpPrice as ErpPriceResource;

class GetPriceServiceInterfaceTest extends TestCase
{
    const TEST_SKU = 'get_price_service_sku_test';
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var GetPriceServiceInterface
     */
    private $getPriceService;

    /**
     * @var ErpPriceResource
     */
    private $resource;

    /**
     * @var ErpPriceFactory
     */
    private $erpPriceFactory;

    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->getPriceService = $this->objectManager->get(GetPriceServiceInterface::class);
        $this->resource = $this->objectManager->get(ErpPriceResource::class);
        $this->erpPriceFactory = $this->objectManager->get(ErpPriceFactory::class);
    }

    /**
     * @magentoDbIsolation enabled
     * @dataProvider dataProvider
     * @param array $data
     * @param float|null $expectedValue
     */
    public function testPriceScenario(array $data, $expectedValue)
    {
        $this->fillData($data);
        $priceResult = $this->getPriceService->execute(self::TEST_SKU);
        $this->assertTrue($priceResult->getPrice() === $expectedValue);
    }

    /**
     * @param array $data
     */
    private function fillData(array $data)
    {
        foreach ($data as $price) {
            /** @var ErpPrice $erpPrice */
            $erpPrice = $this->erpPriceFactory->create();
            $erpPrice->setSku(self::TEST_SKU);
            $erpPrice->setPrice($price);
            $this->resource->save($erpPrice);
        }
    }

    public static function dataProvider()
    {
        return [
            'Not found case. Price eq null' => [
                'data' => [],
                'expectedValue' => null
            ],
            '3 prices where the second is lowest and eq 10.' => [
                'data' => [
                    50.,
                    10.,
                    150.
                ],
                'expectedValue' => 10.
            ],
            '3 Prices where the second is gt 0' => [
                'data' => [
                    -50.,
                    10.,
                    0.
                ],
                'expectedValue' => 10.
            ],
            '3 prices where all lt 0 or eq 0' => [
                'data' => [
                    -50.,
                    0.,
                    -150.
                ],
                'expectedValue' => null
            ],
            '3 prices all lt 0' => [
                'data' => [
                    -100.,
                    -50.,
                    -150.
                ],
                'expectedValue' => null
            ]
        ];
    }
}
