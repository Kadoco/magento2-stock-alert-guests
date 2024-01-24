<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Console\Command;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\State;
use Magento\Framework\Exception\NoSuchEntityException;
use Kadoco\StockAlertGuests\Service\GetAllStockAlerts;

class GetSubscribers extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var State
     */
    private $appState;
    /**
     * @var GetAllStockAlerts
     */
    private $getAllStockAlerts;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        State $appState,
        GetAllStockAlerts $getAllStockAlerts,
        ProductRepositoryInterface $productRepository
    ) {
        parent::__construct();
        $this->appState = $appState;
        $this->getAllStockAlerts = $getAllStockAlerts;
        $this->productRepository = $productRepository;
    }

    protected function configure()
    {
        $this->setName('kadoco:stockalert:list');
        $this->setDescription('Get list of stock alerts');

        parent::configure();
    }

    protected function execute(
        \Symfony\Component\Console\Input\InputInterface $input,
        \Symfony\Component\Console\Output\OutputInterface $output
    ) {
        $time = microtime(true);
        $output->writeln("\n\t<comment>List of all current stock alerts</comment>");

        $this->appState->setAreaCode('adminhtml');
        $stockAlerts = $this->getAllStockAlerts->execute();
        foreach ($stockAlerts as $alert) {
            try {
                $product = $this->productRepository->getById($alert->getProductId());
            } catch (NoSuchEntityException $e) {
                continue;
            }
            $output->writeln("<info>{$product->getSku()} \t{$alert->getStatus()}\t{$alert->getCreatedAt()}\t{$alert->getEmail()}\t</info>");
        }

        $executionTime = microtime(true) - $time;
        $output->writeln("\t<comment>... completed in $executionTime seconds</comment>\n");
    }
}
