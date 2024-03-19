<?php

namespace App\Api\Checkout\Infrastructure\Command;

use App\Api\Checkout\Application\ExpireCart\ExpireCartCommandHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExpireCartCommand extends Command
{
    protected static $defaultName = "app:expire-cart";

    public function __construct(
        private ExpireCartCommandHandler $handler
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Expires carts that have been inactive for a certain period of time.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->handler->__invoke();

        return Command::SUCCESS;
    }
}