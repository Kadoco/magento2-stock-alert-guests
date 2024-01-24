<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Service;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Kadoco\StockAlertGuests\Api\Data\StockAlertInterface;
use Kadoco\StockAlertGuests\Api\StockAlertRepositoryInterface;
use Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert;

class GetStockAlertByEmailProductId
{
    /**
     * @var StockAlertRepositoryInterface
     */
    private $stockAlertRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        StockAlertRepositoryInterface $stockAlertRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->stockAlertRepository = $stockAlertRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param string $email
     * @param int $productId
     * @param int $storeId
     * @return StockAlertInterface[]
     */
    public function execute(string $email, int $productId, int $storeId):array
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(StockAlert::EMAIL_FIELD, $email)
            ->addFilter(StockAlert::PRODUCT_ID_FIELD, $productId)
            ->addFilter(StockAlert::STORE_ID_FIELD, $storeId)
            ->create();

        return $this->stockAlertRepository->getList($searchCriteria)->getItems();
    }
}
