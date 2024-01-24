<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Block;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\View\Element\Template;

class CategoryStockAlert extends Template
{
    /** @var ProductInterface $product */
    private ProductInterface $product;

    public function setProduct(ProductInterface $product): CategoryStockAlert
    {
        $this->product = $product;

        return $this;
    }

    public function getProduct():ProductInterface
    {
        return $this->product;
    }
}
