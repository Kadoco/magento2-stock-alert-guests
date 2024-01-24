<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductPageProductProvider implements ArgumentInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        RequestInterface $request
    ) {
        $this->productRepository = $productRepository;
        $this->request = $request;
    }

    /**
     * @return ProductInterface
     */
    public function execute(): ?ProductInterface
    {
        $productId = $this->getProductId();
        if (!$productId) {
            return null;
        }
        try {
            $product = $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            return null;
        }

        return $product;
    }

    public function getProductId():int
    {
        return (int)$this->request->getParam('id');
    }
}
