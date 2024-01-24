<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert as StockAlertResourceModel;
use Kadoco\StockAlertGuests\Model\StockAlert as StockAlertModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            StockAlertModel::class,
            StockAlertResourceModel::class
        );
    }
}
