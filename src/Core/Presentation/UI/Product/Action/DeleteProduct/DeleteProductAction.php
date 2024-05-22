<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\DeleteProduct;

use App\Core\Application\Product\Command\DeleteProduct\DeleteProductCommand;
use App\Core\Domain\Product\Entity\Product;
use App\Core\Domain\Product\Exception\ProductNotFoundException;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use App\Shared\Presentation\Service\ActionFlashService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products/delete/{id}', name: 'app.product.delete', methods: ['GET', 'DELETE'])]
final class DeleteProductAction extends AbstractController
{
    public function __construct(
        private readonly DeleteProductResponder $responder,
        private readonly CommandBusInterface    $commandBus,
        private readonly ActionFlashService     $actionFlashService,
    )
    {
    }

    public function __invoke(int $id): Response
    {
        try {
            $this->commandBus->dispatch(new DeleteProductCommand($id));
        } catch (ProductNotFoundException $exception) {
            throw $this->responder->createNotFoundException($exception->getMessage());
        }

        $this->actionFlashService->addEntityDeletedFlash(Product::class);

        return $this->responder->redirect();
    }
}