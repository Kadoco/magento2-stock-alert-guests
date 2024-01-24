<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Api\Data;

interface StockAlertInterface
{
    public function getEmail():string;
    public function getStoreId():int;
    public function getProductId():int;
    public function getStatus():string;
    public function getCreatedAt():string;

    public function setEmail(string $email):StockAlertInterface;
    public function setStoreId(int $storeId):StockAlertInterface;
    public function setProductId(int $productId):StockAlertInterface;
    public function setStatus(string $status):StockAlertInterface;
    public function setCreatedAt(string $createdAt):StockAlertInterface;
}
