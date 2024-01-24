<?php
declare(strict_types=1);

namespace Kadoco\StockAlertGuests\Console\Command;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\State;
use Kadoco\StockAlertGuests\Service\GetAllStockAlerts;
use Kadoco\StockAlertGuests\Service\SendInStockAlerts;

class SendStockAlerts extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var State
     */
    private $appState;
    /**
     * @var SendInStockAlerts
     */
    private $sendInStockAlerts;

    public function __construct(
        State $appState,
        SendInStockAlerts $sendInStockAlerts
    ) {
        parent::__construct();
        $this->appState = $appState;
        $this->sendInStockAlerts = $sendInStockAlerts;
    }


    protected function configure()
    {
        $this->setName('kadoco:stockalert:send');
        $this->setDescription('Send stock alerts');

        parent::configure();
    }

    protected function execute(
        \Symfony\Component\Console\Input\InputInterface $input,
        \Symfony\Component\Console\Output\OutputInterface $output
    ) {
        $time = microtime(true);
        $output->writeln("\n\t<comment>List of all current stock alerts</comment>");

        $this->appState->setAreaCode('adminhtml');
        $this->sendInStockAlerts->execute();

        $executionTime = microtime(true) - $time;
        $output->writeln("\t<comment>... completed in $executionTime seconds</comment>\n");
    }
}
