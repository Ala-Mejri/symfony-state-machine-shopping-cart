<?php

declare(strict_types=1);

namespace App\Core\Presentation\CLI\CheckoutProcess;

use App\Core\Application\Order\Command\DeleteExpiredOrders\DeleteExpiredOrdersCommand;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:remove-expired-carts')]
final class RemoveExpiredCartsCommand extends Command
{
    const DEFAULT_MAX_INACTIVITY_DAYS = 7;

    public function __construct(private readonly CommandBusInterface $commandBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Removes expired carts that have been inactive for a defined period')
            ->addArgument(
                'days',
                InputArgument::OPTIONAL,
                'The number of days a cart can remain inactive',
                self::DEFAULT_MAX_INACTIVITY_DAYS
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $days = $input->getArgument('days');

        if ($days <= 0) {
            $io->error('The number of days should be greater than 0.');

            return Command::FAILURE;
        }

        $deletedExpiredCartsCount = $this->commandBus->dispatch(new DeleteExpiredOrdersCommand($days));
        $this->displayConsoleResultMessage($io, $deletedExpiredCartsCount);

        return Command::SUCCESS;
    }

    private function displayConsoleResultMessage(SymfonyStyle $io, int $deletedExpiredCartsCount): void
    {
        if ($deletedExpiredCartsCount > 0) {
            $io->success("$deletedExpiredCartsCount cart(s) have been removed.");

            return;
        }

        $io->info('No expired carts found.');
    }
}
