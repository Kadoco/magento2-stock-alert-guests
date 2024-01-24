<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Service;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Kadoco\StockAlertGuests\Api\Data\StockAlertInterface;

class SendInStockAlerts
{
    /**
     * @var GetAllStockAlerts
     */
    private $getAllStockAlerts;
    /**
     * @var SendStockAlertByEmailProductId
     */
    private $sendStockAlertByEmailProductId;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        GetAllStockAlerts $getAllStockAlerts,
        SendStockAlertByEmailProductId $sendStockAlertByEmailProductId,
        ProductRepositoryInterface $productRepository
    ) {
        $this->getAllStockAlerts = $getAllStockAlerts;
        $this->sendStockAlertByEmailProductId = $sendStockAlertByEmailProductId;
        $this->productRepository = $productRepository;
    }

    public function execute():void
    {
        $stockAlerts = $this->getAllStockAlerts->execute();

        $subscriptionByStoreIdProductId = $this->getStockAlertsByStoreIdProductProductId($stockAlerts);

        foreach ($subscriptionByStoreIdProductId as $storeId => $subscriptionByProductId) {
            foreach ($subscriptionByProductId as $productId => $emails) {
                $isInStock = $this->isProductInStockByProductId((int)$productId);
                if (!$isInStock || !is_array($emails)) {
                    continue;
                }

                $this->sendStockAlertsForEmails($emails, $productId, $storeId);
            }
        }
    }

    private function sendStockAlertsForEmails(array $emails, int $productId, int $storeId)
    {
        foreach ($emails as $email) {
            $this->sendStockAlertByEmailProductId->execute($email, $productId, $storeId);
        }
    }

    private function isProductInStockByProductId(int $productId):bool
    {
        try {
            $product = $this->productRepository->getById($productId);
            $qty = $product->getExtensionAttributes()->getStockItem()->getQty();
            $isInStock = $product->getExtensionAttributes()->getStockItem()->getIsInStock();

            return $qty > 0 && $isInStock;
        } catch (NoSuchEntityException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param StockAlertInterface[] $stockAlerts
     * @return array
     */
    private function getStockAlertsByStoreIdProductProductId(array $stockAlerts): array
    {
        $result = [];
        foreach ($stockAlerts as $stockAlert) {
            $result[$stockAlert->getStoreId()][$stockAlert->getProductId()][] = $stockAlert->getEmail();
        }

        return $result;
    }
}
