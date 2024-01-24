<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StockAlert extends AbstractDb
{
    const MAIN_TABLE = 'kadoco_stockalert_guest';
    const ID_FIELD = 'id';
    const EMAIL_FIELD = 'email';
    const PRODUCT_ID_FIELD = 'product_id';
    const STATUS_FIELD = 'status';
    const CREATED_AT = 'created_at';
    const STORE_ID_FIELD = 'store_id';

    protected function _construct()
    {
        $this->_init(
            self::MAIN_TABLE,
            self::ID_FIELD
        );
    }
}
