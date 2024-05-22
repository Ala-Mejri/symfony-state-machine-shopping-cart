<?php

declare(strict_types=1);

namespace App\Core\Application\User\Command\CreateAdmin;

use App\Shared\Application\Bus\Command\CommandInterface;

final readonly class CreateAdminCommand implements CommandInterface
{
    public function __construct(private string $name, private string $email, private string $plainPassword)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}