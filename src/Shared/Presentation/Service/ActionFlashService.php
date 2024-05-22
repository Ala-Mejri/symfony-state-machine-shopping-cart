<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Service;

use App\Shared\Application\Helper\StringHelper;

final readonly class ActionFlashService
{
    public function __construct(private FlashService $flashService, private StringHelper $stringHelper)
    {
    }

    public function addEntityCreatedFlash(string $entityClass): void
    {
        $message = sprintf('%s was created successfully!', $this->getClassName($entityClass));

        $this->flashService->addSuccessFlash($message);
    }

    public function addEntityUpdatedFlash(string $entityClass): void
    {
        $message = sprintf('%s was updated successfully!', $this->getClassName($entityClass));

        $this->flashService->addSuccessFlash($message);
    }

    public function addEntityDeletedFlash(string $entityClass): void
    {
        $message = sprintf('%s was deleted successfully!', $this->getClassName($entityClass));

        $this->flashService->addSuccessFlash($message);
    }

    private function getClassName(string $entityClass): string
    {
        $classBasename = basename($entityClass);

        return $this->stringHelper->addSeparatorBetweenCaps($classBasename);
    }
}