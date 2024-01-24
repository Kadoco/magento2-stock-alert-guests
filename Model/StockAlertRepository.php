<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Kadoco\StockAlertGuests\Api\Data\StockAlertInterface;
use Kadoco\StockAlertGuests\Api\Data\StockAlertInterfaceFactory;
use Kadoco\StockAlertGuests\Api\Data\StockAlertSearchResultsInterface;
use Kadoco\StockAlertGuests\Api\Data\StockAlertSearchResultsInterfaceFactory;
use Kadoco\StockAlertGuests\Api\StockAlertRepositoryInterface;
use Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert as StockAlertResourceModel;
use Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert\Collection;
use Kadoco\StockAlertGuests\Model\ResourceModel\StockAlert\CollectionFactory;

class StockAlertRepository implements StockAlertRepositoryInterface
{
    /**
     * @var StockAlertInterfaceFactory
     */
    private $stockAlertFactory;
    /**
     * @var StockAlertResourceModel
     */
    private $stockAlertResourceModel;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var StockAlertSearchResultsInterfaceFactory
     */
    private $stockAlertSearchResultsFactory;

    public function __construct(
        StockAlertInterfaceFactory $stockAlertFactory,
        StockAlertResourceModel $stockAlertResourceModel,
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory,
        StockAlertSearchResultsInterfaceFactory $stockAlertSearchResultsFactory
    ) {
        $this->stockAlertFactory = $stockAlertFactory;
        $this->stockAlertResourceModel = $stockAlertResourceModel;
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->stockAlertSearchResultsFactory = $stockAlertSearchResultsFactory;
    }

    public function get(int $stockAlertId):StockAlertInterface
    {
        /** @var StockAlertInterface $stockAlert */
        $stockAlert = $this->stockAlertFactory->create();
        $this->stockAlertResourceModel->load($stockAlert, $stockAlertId);

        if (!$stockAlert->getId()) {
            throw new NoSuchEntityException(__("No such stock alert with id.", $stockAlertId));
        }

        return $stockAlert;
    }

    public function save(StockAlertInterface $stockAlert):StockAlertInterface
    {
        try {
            $this->stockAlertResourceModel->save($stockAlert);
        } catch (AlreadyExistsException $e) {
        }

        return $stockAlert;
    }

    public function delete(StockAlertInterface $stockAlert):bool
    {
        try {
            $this->stockAlertResourceModel->delete($stockAlert);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var StockAlertSearchResultsInterface $searchResult */
        $searchResult = $this->stockAlertSearchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria)
            ->setItems($collection->getItems())
            ->setTotalCount($collection->getSize());

        return $searchResult;
    }
}
