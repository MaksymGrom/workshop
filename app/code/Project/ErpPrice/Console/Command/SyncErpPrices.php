<?php

declare(strict_types=1);

namespace Project\ErpPrice\Console\Command;

use Project\ErpPrice\Model\Service\SyncErpPricesService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncErpPrices extends Command
{
    /**
     * @var SyncErpPricesService
     */
    private $syncErpPricesService;

    /**
     * SyncErpPrices constructor.
     * @param SyncErpPricesService $syncErpPricesService
     * @param string|null $name
     */
    public function __construct(
        SyncErpPricesService $syncErpPricesService,
        string $name = null
    ) {
        parent::__construct($name);
        $this->syncErpPricesService = $syncErpPricesService;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('project:erp_price:sync');
        $this->setDescription('Sync ErpPrice');
        parent::configure();
    }

    /**
     * CLI command description
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->syncErpPricesService->execute();
    }
}
