<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Kadoco\StockAlertGuests\Service\SubscribeToStockAlert;

class Subscribe extends Action
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
        $resultRedirect = $this->resultRedirectFactory->create();

        $request = $this->getRequest();
        $productId = (int) $request->getParam('subscribe_id');
        $email = $request->getParam('email');

        if (!$productId) {
            $this->messageManager->addErrorMessage(__('Product is not set'));
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());

            return $resultRedirect;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->messageManager->addErrorMessage(__('Invalid email'));
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());

            return $resultRedirect;
        }
        $storeId = (int) $this->storeManager->getStore()->getId();

        $this->subscribeToStockAlert->execute($email, $productId, $storeId);
        $this->messageManager->addSuccessMessage(__('You will get an email when the product gets back in stock'));
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;
    }
}
