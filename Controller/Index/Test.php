<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Kadoco\StockAlertGuests\Model\StockAlert;

class Test extends Action
{
    public function execute()
    {
        /** @var \Kadoco\StockAlertGuests\Service\GetStockAlertByEmailProductId $getStockAlert */
        $getStockAlert = $this->_objectManager->create(\Kadoco\StockAlertGuests\Service\GetStockAlertByEmailProductId::class);

        $result = $getStockAlert->execute("kristoffer124@gmail.com", 212, 1);
        /** @var \Kadoco\StockAlertGuests\Api\StockAlertRepositoryInterface $stockAlertRepository */
        $stockAlertRepository = $this->_objectManager->create(\Kadoco\StockAlertGuests\Api\StockAlertRepositoryInterface::class);

        die;
        $stockAlert = $stockAlertRepository->get(3);

        /** @var \Kadoco\StockAlertGuests\Model\StockAlert $stockAlert */
        $stockAlert = $this->_objectManager->create(\Kadoco\StockAlertGuests\Model\StockAlertFactory::class)->create();
        $stockAlert->setData(
            [
                'email' => 'kristoffer124@gmail.com',
                'product_id' => 213,
                'store_id' => 1
            ]
        );

        /** @var \Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert $stockAlertRM */
        $stockAlertRM = $this->_objectManager->create(\Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert::class);
        $stockAlertRM->save($stockAlert);

        die;


        /** @var \Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert\Collection $stockAlertRM */
        $stockAlertCollection = $this->_objectManager->create(\Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert\Collection::class);

        die;
    }
}
