<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        $this->createStockAlertGuestTable($setup);

        $setup->endSetup();
    }

    private function createStockAlertGuestTable(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable('kadoco_stockalert_guest');

        if ($setup->getConnection()->isTableExists($tableName)) {
            return;
        }

        $table = $setup->getConnection()
            ->newTable($tableName)
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'id'
            )
            ->addColumn(
                'email',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ],
                'Email'
            )
            ->addColumn(
                'product_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => false,
                    'nullable' => false,
                    'primary' => false
                ],
                'Product id')
            ->addColumn(
                'store_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => false,
                    'nullable' => false,
                    'primary' => false
                ],
                'store id')
            ->addColumn(
                'status',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => false,
                    'nullable' => true,
                    'primary' => false
                ],
                'Status')
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Created At')
            ->setComment(
                'Stock alert guest table'
            );

        $setup->getConnection()->createTable($table);
    }
}
