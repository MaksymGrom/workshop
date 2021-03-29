<?php

declare(strict_types=1);

namespace Project\ErpPrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Project\ErpPrice\Model\Service\SetFinalPriceService;

class ErpPriceObserver implements ObserverInterface
{
    /**
     * @var SetFinalPriceService
     */
    private $setFinalPriceService;

    /**
     * ErpPriceObserver constructor.
     * @param SetFinalPriceService $setFinalPriceService
     */
    public function __construct(
        SetFinalPriceService $setFinalPriceService
    ) {

        $this->setFinalPriceService = $setFinalPriceService;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getData('product');

        $this->setFinalPriceService->execute($product);
    }
}
