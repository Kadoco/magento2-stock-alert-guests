<?php


namespace Kadoco\StockAlertGuests\Api\Data;


use Magento\Framework\Api\SearchResultsInterface;

interface StockAlertSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get LogInterfaces
     *
     * @return StockAlertInterface[]
     */
    public function getItems();

    /**
     * Set LogInterface
     *
     * @param StockAlertInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
