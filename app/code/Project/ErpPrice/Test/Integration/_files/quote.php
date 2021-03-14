<?php

use Magento\TestFramework\Workaround\Override\Fixture\Resolver;

require __DIR__ . '/erp_price.php';

Resolver::getInstance()->requireDataFixture('Magento/Sales/_files/quote.php');
