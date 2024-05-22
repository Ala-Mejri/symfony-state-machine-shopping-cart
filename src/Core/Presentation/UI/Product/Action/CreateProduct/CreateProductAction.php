<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\CreateProduct;

use App\Core\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Core\Domain\Product\Entity\Product;
use App\Core\Presentation\UI\Product\Form\ProductType;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use App\Shared\Presentation\Service\ActionFlashService;
use App\Shared\Presentation\Service\ActionFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products/create', name: 'app.product.create')]
final class CreateProductAction extends AbstractController
{
    public function __construct(
        private readonly ActionFormHandler      $actionFormHandler,
        private readonly CreateProductResponder $responder,
        private readonly CommandBusInterface    $commandBus,
        private readonly ActionFlashService     $actionFlashService,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->actionFormHandler->handleFormRequest(ProductType::class, $request);

        if (!$this->actionFormHandler->isFormSubmittedAndValid($form)) {
            return $this->responder->respond($form);
        }

        $id = $this->createProduct($form);

        $this->actionFlashService->addEntityCreatedFlash(Product::class);

        return $this->responder->redirect($id);
    }

    private function createProduct(FormInterface $form): int
    {
        /* @var Product $product */
        $product = $form->getData();

        return $this->commandBus->dispatch(
            new CreateProductCommand(
                $product->getName(),
                $product->getDescription(),
                $product->getPrice(),
                $form->get('imagePath')->getData(),
            ),
        );
    }
}