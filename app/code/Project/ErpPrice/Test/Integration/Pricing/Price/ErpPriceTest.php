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
        $this->productRepository = $this->objectManager->get(ProductRepositoryInterface::class);
    }
    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture dataFixture
     */
    public function testErpPrice()
    {
        /** @var Product $product */
        $product = $this->productRepository->get('simple');

        $price = $product->getPriceInfo()->getPrice(BasePrice::PRICE_CODE);
        $this->assertEquals(1., $price->getValue(), 'ErpPrice must be eq 1.0');
    }

    public static function dataFixture()
    {
        require __DIR__ . '/../../_files/simple_product.php';
    }
}
