<?php

declare(strict_types=1);

namespace App\Core\Application\User\Command\DeleteUserDeliveryAddress;

use App\Shared\Application\Bus\Command\CommandInterface;

final readonly class DeleteUserDeliveryAddressCommand implements CommandInterface
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}