<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\ShowProduct;

use App\Core\Application\CheckoutProcess\Service\CartManagerService;
use App\Core\Application\Product\Query\FindProduct\FindProductQuery;
use App\Core\Domain\Product\Exception\ProductNotFoundException;
use App\Core\Presentation\UI\CheckoutProcess\Form\AddToCartType;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use App\Shared\Application\Service\CurrentUserService;
use App\Shared\Presentation\Service\ActionFormHandler;
use App\Shared\Presentation\Service\FlashService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products/{id}', name: 'app.product.detail')]
final class ShowProductAction extends AbstractController
{
    public function __construct(
        private readonly ActionFormHandler    $actionFormHandler,
        private readonly ShowProductResponder $responder,
        private readonly QueryBusInterface    $queryBus,
        private readonly CartManagerService   $cartManagerService,
        private readonly CurrentUserService   $currentUserService,
        private readonly FlashService         $flashService,
    )
    {
    }

    public function __invoke(int $id, Request $request): Response
    {
        try {
            $product = $this->queryBus->ask(new FindProductQuery($id));
        } catch (ProductNotFoundException $exception) {
            throw $this->responder->createNotFoundException($exception->getMessage());
        }

        $form = $this->actionFormHandler->handleFormRequest(AddToCartType::class, $request);
        if (!$this->actionFormHandler->isFormSubmittedAndValid($form)) {
            return $this->responder->respond($product, $form);
        }

        $user = $this->currentUserService->getUser();
        if (!$user) {
            $this->flashService->addNoticeFlash('You need to be logged in first!');

            return $this->responder->redirect($product);
        }

        $this->cartManagerService->addProduct($product);
        $this->flashService->addSuccessFlash('Product was added to cart successfully!');

        return $this->responder->redirect($product);
    }
}