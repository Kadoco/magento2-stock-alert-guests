<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Service;

class HasStockAlertByEmailProductId
{
    /**
     * @var GetStockAlertByEmailProductId
     */
    private $getStockAlertByEmailProductId;

    public function __construct(
        GetStockAlertByEmailProductId $getStockAlertByEmailProductId
    ){
        $this->getStockAlertByEmailProductId = $getStockAlertByEmailProductId;
    }

    public function execute(string $email, int $productId, int $storeId):bool
    {
        return count($this->getStockAlertByEmailProductId->execute($email, $productId, $storeId)) > 0;
    }
}
