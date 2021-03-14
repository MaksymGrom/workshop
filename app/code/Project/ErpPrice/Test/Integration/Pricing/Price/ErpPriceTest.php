<?php

declare(strict_types=1);

namespace Project\ErpPrice\Test\Integration\Pricing\Price;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Pricing\Price\BasePrice;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Framework\ObjectManagerInterface;
use PHPUnit\Framework\TestCase;
use Project\ErpPrice\Model\Service\GetErpPriceFileDataService;
use Project\ErpPrice\Model\Service\SyncErpPricesService;

class ErpPriceTest extends TestCase
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var SyncErpPricesService
     */
    private $syncErpPriceService;

    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->productRepository = $this->objectManager->create(ProductRepositoryInterface::class);
        $this->syncErpPriceService = $this->objectManager->get(SyncErpPricesService::class);
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture dataFixture
     * @magentoConfigFixture project/erp_price/enabled 1
     * @magentoConfigFixture project/erp_price/file_path /app/code/Project/ErpPrice/Test/Integration/_files/erp_price.json
     */
    public function testErpPrice()
    {
        $this->syncErpPriceService->execute();
        /** @var Product $product */
        $product = $this->productRepository->get('simple');

        $price = $product->getPriceInfo()->getPrice(BasePrice::PRICE_CODE);
        $this->assertEquals(1., $price->getValue(), 'ErpPrice must be eq 1.0');
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture dataFixture
     * @magentoConfigFixture project/erp_price/enabled 1
     */
    public function testErpPriceWithTwoSetsOfImportData()
    {
        $getErpPriceMock = $this->createMock(GetErpPriceFileDataService::class);
        $getErpPriceMock->method('execute')->willReturn([
            ['id' => 1, 'sku' => 'simple', 'price' => 1.],
            ['id' => 2, 'sku' => 'simple', 'price' => 10.],
        ], [
            ['id' => 2, 'sku' => 'simple', 'price' => 7.],
            ['id' => 3, 'sku' => 'simple', 'price' => 5.],
        ]);

        $syncErpPriceService = $this->objectManager->create(SyncErpPricesService::class, [
            'getErpPriceFileDataService' => $getErpPriceMock
        ]);
        $syncErpPriceService->execute();
        /** @var Product $product */
        $product = $this->productRepository->get('simple', false, null, true);

        $price = $product->getPriceInfo()->getPrice(BasePrice::PRICE_CODE);
        $this->assertEquals(1., $price->getValue(), 'ErpPrice must be eq 1.0');

        $syncErpPriceService->execute();
        /** @var Product $product */
        $product = $this->productRepository->get('simple', false, null, true);

        $price = $product->getPriceInfo()->getPrice(BasePrice::PRICE_CODE);
        $this->assertEquals(5., $price->getValue(), 'ErpPrice must be eq 5.0');
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture dataFixture
     * @magentoConfigFixture project/erp_price/file_path /app/code/Project/ErpPrice/Test/Integration/_files/erp_price.json
     */
    public function testDisabledErpPrice()
    {
        $this->syncErpPriceService->execute();
        /** @var Product $product */
        $product = $this->productRepository->get('simple');

        $price = $product->getPriceInfo()->getPrice(BasePrice::PRICE_CODE);
        $this->assertEquals(100., $price->getValue(), 'ErpPrice must be disabled');
    }

    public static function dataFixture()
    {
        require __DIR__ . '/../../_files/simple_product.php';
    }
}
