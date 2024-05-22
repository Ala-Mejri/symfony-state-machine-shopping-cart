<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Authentication\Action\Registration;

use App\Core\Application\User\Command\CreateUser\CreateUserCommand;
use App\Core\Presentation\UI\User\Form\RegistrationFormType;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use App\Shared\Presentation\Service\ActionFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/register', name: 'app_register')]
final class RegistrationAction extends AbstractController
{
    public function __construct(
        private readonly ActionFormHandler     $actionFormHandler,
        private readonly CommandBusInterface   $commandBus,
        private readonly RegistrationResponder $responder,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->actionFormHandler->handleFormRequest(RegistrationFormType::class, $request);

        if (!$this->actionFormHandler->isFormSubmittedAndValid($form)) {
            return $this->responder->respond($form);
        }

        $this->commandBus->dispatch(new CreateUserCommand(
            $form->get('name')->getData(),
            $form->get('email')->getData(),
            $form->get('plainPassword')->getData(),
        ));

        return $this->responder->redirect();
    }
}
