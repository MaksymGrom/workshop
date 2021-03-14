<?php

declare(strict_types=1);

namespace Project\ErpPrice\Model\Service;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Project\ErpPrice\Model\ErpPriceConfig;

class GetErpPriceFileDataService
{
    /**
     * @var ErpPriceConfig
     */
    private $erpPriceConfig;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var Json
     */
    private $json;

    /**
     * GetErpPriceFileDataService constructor.
     * @param ErpPriceConfig $erpPriceConfig
     * @param DirectoryList $directoryList
     * @param DriverInterface $driver
     * @param Json $json
     */
    public function __construct(
        ErpPriceConfig $erpPriceConfig,
        DirectoryList $directoryList,
        DriverInterface $driver,
        Json $json
    ) {

        $this->erpPriceConfig = $erpPriceConfig;
        $this->directoryList = $directoryList;
        $this->driver = $driver;
        $this->json = $json;
    }

    /**
     * @return array
     * @throws FileSystemException
     */
    public function execute(): array
    {
        $getAbsFilePath = $this->directoryList->getRoot() . $this->erpPriceConfig->getFilePath();

        if (!$this->driver->isFile($getAbsFilePath)) {
            return [];
        }

        $jsonString = $this->driver->fileGetContents($getAbsFilePath);

        if (empty($jsonString)) {
            return [];
        }

        try {
            $jsonData = $this->json->unserialize($jsonString);
        } catch (\InvalidArgumentException $exception) {
            return [];
        }

        if (empty($jsonData['Prices'])) {
            return [];
        }

        return $jsonData['Prices'];
    }
}
