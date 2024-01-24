<?php


namespace Kadoco\StockAlertGuests\Api;

use Magento\Framework\Api\SearchResultsInterface;
use Kadoco\StockAlertGuests\Api\Data\StockAlertInterface;
use Kadoco\StockAlertGuests\Api\Data\StockAlertSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface StockAlertRepositoryInterface
{
    /**
     * @param int $stockAlertId
     * @return StockAlertInterface
     */
    public function get(int $stockAlertId):StockAlertInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StockAlertSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;


    /**
     * @param StockAlertInterface $stockAlert
     * @return StockAlertInterface
     */
    public function save(StockAlertInterface $stockAlert):StockAlertInterface;


    /**
     * @param StockAlertInterface $stockAlert
     * @return bool
     */
    public function delete(StockAlertInterface $stockAlert):bool;
}
