<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Application\Bus\Command\CommandInterface;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final readonly class MessengerCommandBus implements CommandBusInterface
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @throws Throwable
     */
    public function dispatch(CommandInterface $command): ?int
    {
        try {
            return $this->commandBus->dispatch($command)->last(HandledStamp::class)->getResult();
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious() ?? $exception;
        }
    }
}