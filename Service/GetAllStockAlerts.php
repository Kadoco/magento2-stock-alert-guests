<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Service;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Kadoco\StockAlertGuests\Api\Data\StockAlertInterface;
use Kadoco\StockAlertGuests\Api\StockAlertRepositoryInterface;

class GetAllStockAlerts
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var StockAlertRepositoryInterface
     */
    private $stockAlertRepository;
    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StockAlertRepositoryInterface $stockAlertRepository,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->stockAlertRepository = $stockAlertRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @param int $productId
     * @return StockAlertInterface[]
     */
    public function execute($productId = 0):array
    {
        if ($productId) {
            $this->searchCriteriaBuilder->addFilter('product_id', $productId);
        }
        $sortOrder = $this->sortOrderBuilder
            ->setField('product_id')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addSortOrder($sortOrder)
            ->create();

        return $this->stockAlertRepository->getList($searchCriteria)->getItems();
    }
}
