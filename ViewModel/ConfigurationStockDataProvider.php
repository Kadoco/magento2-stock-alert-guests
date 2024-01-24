<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\ViewModel;

use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Kadoco\StockAlertGuests\Service\SendStockAlertByEmailProductId;

class ConfigurationStockDataProvider implements ArgumentInterface
{
    /**
     * @var ProductPageProductProvider
     */
    private $productPageProductProvider;
    /**
     * @var UrlInterface
     */
    private $url;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        ProductPageProductProvider $productPageProductProvider,
        UrlInterface $url,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->productPageProductProvider = $productPageProductProvider;
        $this->url = $url;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    public function execute():array
    {
        $product = $this->productPageProductProvider->execute();
        if (!$product) {
            return [];
        }
        /** @var ConfigurableType $configurableType */
        $configurableType = $product->getTypeInstance();

        $childrens = $configurableType->getUsedProducts($product);

        $result = [];
        foreach ($childrens as $child) {
            $result[$child->getId()] = (bool)$child->isSalable();
        }
        $storeId = (int)$this->storeManager->getStore()->getId();

        return [
            'stock' => $result,
            'stockUrl' => $this->url->getUrl('stockalert/index/post', ['_secure' => true]),
            'isActive' => $this->getIsActive($storeId)
        ];
    }

    private function getIsActive(int $storeId):bool
    {
        return (bool)$this->scopeConfig->getValue(
            SendStockAlertByEmailProductId::XML_PATH_ACTIVE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
