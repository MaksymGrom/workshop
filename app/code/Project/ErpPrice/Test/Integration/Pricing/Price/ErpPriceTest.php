<?php

declare(strict_types=1);

namespace Project\ErpPrice\Test\Integration\Pricing\Price;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Pricing\Price\BasePrice;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Framework\ObjectManagerInterface;
use PHPUnit\Framework\TestCase;

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

    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->productRepository = $this->objectManager->create(ProductRepositoryInterface::class);
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture dataFixture
     * @magentoConfigFixture project/erp_price/enabled 1
     */
    public function testErpPrice()
    {
        /** @var Product $product */
        $product = $this->productRepository->get('simple');

        $price = $product->getPriceInfo()->getPrice(BasePrice::PRICE_CODE);
        $this->assertEquals(1., $price->getValue(), 'ErpPrice must be eq 1.0');
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture dataFixture
     */
    public function testDisabledErpPrice()
    {
        /** @var Product $product */
        $product = $this->productRepository->get('simple');

        $price = $product->getPriceInfo()->getPrice(BasePrice::PRICE_CODE);
        $this->assertEquals(100., $price->getValue(), 'ErpPrice must be disabled');
    }

    public static function dataFixture()
    {
        require __DIR__ . '/../../_files/simple_product.php';
        require __DIR__ . '/../../_files/erp_price.php';
    }
}
