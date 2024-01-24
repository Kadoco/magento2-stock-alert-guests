<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Service;

use Kadoco\StockAlertGuests\Api\Data\StockAlertInterfaceFactory;
use Kadoco\StockAlertGuests\Api\Data\StockAlertInterface;
use Kadoco\StockAlertGuests\Api\StockAlertRepositoryInterface;

class SubscribeToStockAlert
{
    /**
     * @var HasStockAlertByEmailProductId
     */
    private $hasStockAlertByEmailProductId;
    /**
     * @var StockAlertInterfaceFactory
     */
    private $stockAlertFactory;
    /**
     * @var StockAlertRepositoryInterface
     */
    private $stockAlertRepository;

    public function __construct(
        HasStockAlertByEmailProductId $hasStockAlertByEmailProductId,
        StockAlertInterfaceFactory $stockAlertFactory,
        StockAlertRepositoryInterface $stockAlertRepository
    ) {
        $this->hasStockAlertByEmailProductId = $hasStockAlertByEmailProductId;
        $this->stockAlertFactory = $stockAlertFactory;
        $this->stockAlertRepository = $stockAlertRepository;
    }

    public function execute(string $email, int $productId, int $storeId):bool
    {
        $hasStockAlert = $this->hasStockAlertByEmailProductId->execute($email, $productId, $storeId);
        if ($hasStockAlert) {
            return true;
        }
        /** @var StockAlertInterface $stockAlert */
        $stockAlert = $this->stockAlertFactory->create();
        $stockAlert->setEmail($email)
            ->setProductId($productId)
            ->setStoreId($storeId);

        $this->stockAlertRepository->save($stockAlert);

        return true;
    }
}
