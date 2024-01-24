<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Kadoco\StockAlertGuests\Service\SubscribeToStockAlert;

class Post extends Action
{

    /**
     * @var SubscribeToStockAlert
     */
    private $subscribeToStockAlert;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        SubscribeToStockAlert $subscribeToStockAlert
    ) {
        parent::__construct($context);

        $this->subscribeToStockAlert = $subscribeToStockAlert;
        $this->storeManager = $storeManager;
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $jsonResult */
        $jsonResult = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);

        $request = $this->getRequest();
        $productId = (int) $request->getParam('subscribe_id');
        $email = $request->getParam('email');

        if (!$productId) {
            $jsonResult->setData([
                'error' => true
            ]);
            return $jsonResult;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $jsonResult->setData([
                'error' => true
            ]);
            return $jsonResult;
        }
        $storeId = (int) $this->storeManager->getStore()->getId();

        $this->subscribeToStockAlert->execute($email, $productId, $storeId);
        $jsonResult->setData([
            'success' => true
        ]);
        return $jsonResult;
    }
}
