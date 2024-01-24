<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Service;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\ScopeInterface;

class SendStockAlertByEmailProductId
{
    const XML_PATH_EMAIL_STOCK_TEMPLATE = 'stockalertsguest/configuration/email_stock_template_guest';
    const XML_PATH_EMAIL_IDENTITY = 'stockalertsguest/configuration/email_identity';
    const XML_PATH_ACTIVE = 'stockalertsguest/configuration/active';

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var DeleteStockAlertByEmailProductId
     */
    private $deleteStockAlertByEmailProductId;

    public function __construct(
        TransportBuilder $transportBuilder,
        ProductRepositoryInterface $productRepository,
        ScopeConfigInterface $scopeConfig,
        DeleteStockAlertByEmailProductId $deleteStockAlertByEmailProductId
    ) {

        $this->transportBuilder = $transportBuilder;
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
        $this->deleteStockAlertByEmailProductId = $deleteStockAlertByEmailProductId;
    }

    public function execute(string $email, int $productId, int $storeId):void
    {
        $templateId = $this->getTemplateId($storeId);
        $fromEmail = $this->getFromEmail($storeId);
        try {
            $product = $this->productRepository->getById($productId, $storeId);
        } catch (NoSuchEntityException $e) {
            return;
        }

        $transport = $this->transportBuilder
            ->setTemplateIdentifier($templateId)
            ->setTemplateOptions(['area' => Area::AREA_FRONTEND,'store' => $storeId])
            ->setTemplateVars(['productName' => $product->getName(),'productUrl' => $product->getProductUrl()])
            ->setFromByScope($fromEmail, $storeId)
            ->addTo($email)
            ->getTransport();

        try {
            $transport->sendMessage();
        } catch (MailException $e) {
        }

        $this->deleteStockAlertByEmailProductId->execute($email, $productId, $storeId);
    }

    private function getFromEmail(int $storeId):string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    private function getTemplateId(int $storeId):string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_STOCK_TEMPLATE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
