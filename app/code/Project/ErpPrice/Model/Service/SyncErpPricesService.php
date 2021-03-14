<?php

declare(strict_types=1);

namespace Project\ErpPrice\Model\Service;

use Magento\Framework\Exception\FileSystemException;
use Project\ErpPrice\Model\ResourceModel\ErpPrice as ErpPriceResource;

class SyncErpPricesService
{
    /**
     * @var GetErpPriceFileDataService
     */
    private $getErpPriceFileDataService;

    /**
     * @var ErpPriceResource
     */
    private $erpPriceResource;

    /**
     * SyncErpPricesService constructor.
     * @param GetErpPriceFileDataService $getErpPriceFileDataService
     * @param ErpPriceResource $erpPriceResource
     */
    public function __construct(
        GetErpPriceFileDataService $getErpPriceFileDataService,
        ErpPriceResource $erpPriceResource
    ) {
        $this->getErpPriceFileDataService = $getErpPriceFileDataService;
        $this->erpPriceResource = $erpPriceResource;
    }

    /**
     * @throws FileSystemException
     */
    public function execute(): void
    {
        $prices = $this->getErpPriceFileDataService->execute();

        $dbData = [];

        foreach ($prices as $price) {
            $dbData[] = [
                'entity_id' => $price['id'],
                'sku' => $price['sku'],
                'price' => $price['price'],
            ];
        }

        $this->erpPriceResource->insertOnDuplicate($dbData);
    }
}
