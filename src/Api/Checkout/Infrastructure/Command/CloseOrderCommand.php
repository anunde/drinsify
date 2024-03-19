<?php

namespace App\Api\Checkout\Infrastructure\Command;

use App\Api\Checkout\Application\GetOpenedOrders\GetOpenedOrdersQueryHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CloseOrderCommand extends Command
{
    protected static $defaultName = "app:close-order";

    public function __construct(
        private readonly GetOpenedOrdersQueryHandler $handler
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Iterate activated Orders and send tokenization if paid or cancels if it expires');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $startTime = new \DateTimeImmutable();
        $endTime = $startTime->modify('+50 seconds');

        //Repeat the process each 10 seconds to give the user a faster response than only the minimum of a cron
        while (new \DateTime() <= $endTime) {
            $orders = $this->handler->__invoke();

            foreach ($orders as $order) {
                if ($order->getStatus->value() && $order->getPaid()->value() && !$order->getTokenized()->value()) {
                    foreach ($order->getLines() as $line) {
                        $timesToProcess = $line->getQuantity()->value();

                        for ($i = 0; $i < $timesToProcess; $i++) {
                            dump('Mintear');
                        }
                    }
                }
            }

            return Command::SUCCESS;

            sleep(10);
        }

        return Command::SUCCESS;
    }
}