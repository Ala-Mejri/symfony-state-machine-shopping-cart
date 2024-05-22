<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\ShowUserDeliveryAddress;

use App\Core\Application\User\Query\FindUserDeliveryAddress\FindUserDeliveryAddressQuery;
use App\Core\Domain\User\Exception\UserDeliveryAddressNotFoundException;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use App\Shared\Domain\Primitive\Exception\EntityAccessForbiddenException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user-delivery-address/{id}', name: 'app.address.detail')]
final class ShowUserDeliveryAddressAction extends AbstractController
{
    public function __construct(
        private readonly ShowUserDeliveryAddressResponder $responder,
        private readonly QueryBusInterface                $queryBus,
    )
    {
    }

    public function __invoke(int $id): RedirectResponse|Response
    {
        try {
            $userDeliveryAddress = $this->queryBus->ask(new FindUserDeliveryAddressQuery($id));
        } catch (UserDeliveryAddressNotFoundException $exception) {
            throw $this->responder->createNotFoundException($exception->getMessage());
        } catch (EntityAccessForbiddenException $exception) {
            throw $this->responder->createAccessDeniedException($exception->getMessage());
        }

        return $this->responder->respond($userDeliveryAddress);
    }
}