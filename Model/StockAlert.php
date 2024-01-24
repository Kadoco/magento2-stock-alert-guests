<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Model;

use Magento\Framework\Model\AbstractModel;
use Kadoco\StockAlertGuests\Api\Data\StockAlertInterface;
use Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert as StockAlertResourceModel;

class StockAlert extends AbstractModel implements StockAlertInterface
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var int
     */
    private $productId;
    /**
     * @var string
     */
    private $status;
    /**
     * @var string
     */
    private $createdAt;
    /**
     * @var int
     */
    private $storeId;

    protected function _construct()
    {
        $this->_init(StockAlertResourceModel::class);
    }

    public function getEmail(): string
    {
        return (string) $this->getData(StockAlertResourceModel::EMAIL_FIELD);
    }

    public function getProductId(): int
    {
        return (int) $this->getData(StockAlertResourceModel::PRODUCT_ID_FIELD);
    }

    public function getStatus(): string
    {
        return (string) $this->getData(StockAlertResourceModel::STATUS_FIELD);
    }

    public function getCreatedAt(): string
    {
        return (string) $this->getData(StockAlertResourceModel::CREATED_AT);
    }

    public function setEmail(string $email): StockAlertInterface
    {
        $this->setData(StockAlertResourceModel::EMAIL_FIELD, $email);

        return $this;
    }

    public function setProductId(int $productId): StockAlertInterface
    {
        $this->setData(StockAlertResourceModel::PRODUCT_ID_FIELD, $productId);

        return $this;
    }

    public function setStatus(string $status): StockAlertInterface
    {
        $this->setData(StockAlertResourceModel::STATUS_FIELD, $status);

        return $this;
    }

    public function setCreatedAt(string $createdAt): StockAlertInterface
    {
        $this->setData(StockAlertResourceModel::CREATED_AT, $createdAt);

        return $this;
    }

    public function getStoreId(): int
    {
        return (int) $this->getData(StockAlertResourceModel::STORE_ID_FIELD);
    }

    public function setStoreId(int $storeId): StockAlertInterface
    {
        $this->setData(StockAlertResourceModel::STORE_ID_FIELD, $storeId);

        return $this;
    }
}
