<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Application\Bus\Query\QueryInterface;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(private readonly MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @throws Throwable
     */
    public function ask(QueryInterface $query): mixed
    {
        try {
            return $this->handle($query);
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious() ?? $exception;
        }
    }
}