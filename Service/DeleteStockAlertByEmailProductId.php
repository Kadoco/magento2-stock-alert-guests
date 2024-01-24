<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Service;

use Kadoco\StockAlertGuests\Api\StockAlertRepositoryInterface;

class DeleteStockAlertByEmailProductId
{
    /**
     * @var GetStockAlertByEmailProductId
     */
    private $getStockAlertByEmailProductId;
    /**
     * @var StockAlertRepositoryInterface
     */
    private $stockAlertRepository;

    public function __construct(
        GetStockAlertByEmailProductId $getStockAlertByEmailProductId,
        StockAlertRepositoryInterface $stockAlertRepository
    ) {
        $this->getStockAlertByEmailProductId = $getStockAlertByEmailProductId;
        $this->stockAlertRepository = $stockAlertRepository;
    }

    public function execute(string $email, int $productId, int $storeId):bool
    {
        $stockAlerts = $this->getStockAlertByEmailProductId->execute($email, $productId, $storeId);
        if (empty($stockAlerts)) {
            return false;
        }
        foreach ($stockAlerts as $stockAlert) {
            $this->stockAlertRepository->delete($stockAlert);
        }
        return true;
    }
}
