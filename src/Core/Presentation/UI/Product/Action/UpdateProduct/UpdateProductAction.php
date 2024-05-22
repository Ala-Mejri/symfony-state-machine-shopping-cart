<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\UpdateProduct;

use App\Core\Application\Product\Command\UpdateProduct\UpdateProductCommand;
use App\Core\Application\Product\Query\FindProduct\FindProductQuery;
use App\Core\Domain\Product\Entity\Product;
use App\Core\Domain\Product\Exception\ProductNotFoundException;
use App\Core\Presentation\UI\Product\Form\ProductType;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use App\Shared\Presentation\Service\ActionFlashService;
use App\Shared\Presentation\Service\ActionFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products/update/{id}', name: 'app.product.update')]
final class UpdateProductAction extends AbstractController
{
    public function __construct(
        private readonly ActionFormHandler      $actionFormHandler,
        private readonly UpdateProductResponder $responder,
        private readonly QueryBusInterface      $queryBus,
        private readonly CommandBusInterface    $commandBus,
        private readonly ActionFlashService     $actionFlashService,
    )
    {
    }

    public function __invoke(int $id, Request $request): Response|NotFoundHttpException
    {
        try {
            $product = $this->queryBus->ask(new FindProductQuery($id));
        } catch (ProductNotFoundException $exception) {
            throw $this->responder->createNotFoundException($exception->getMessage());
        }

        $form = $this->actionFormHandler->handleFormRequest(ProductType::class, $request, $product);

        if (!$this->actionFormHandler->isFormSubmittedAndValid($form)) {
            return $this->responder->respond($product, $form);
        }

        $product = $this->updateProduct($form);
        $this->actionFlashService->addEntityUpdatedFlash(Product::class);

        return $this->responder->redirect($product);
    }

    private function updateProduct(FormInterface $form): Product
    {
        /* @var Product $product */
        $product = $form->getData();

        $this->commandBus->dispatch(
            new UpdateProductCommand(
                $product->getId(),
                $product->getName(),
                $product->getDescription(),
                $product->getPrice(),
                $form->get('imagePath')->getData(),
            ),
        );

        return $product;
    }
}