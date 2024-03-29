<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $page->getConfig()->getTitle()->set(__('Stock subscription'));


        return $page;
    }
}
