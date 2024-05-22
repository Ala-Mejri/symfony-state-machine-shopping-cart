<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Service;

use App\Shared\Domain\Primitive\Entity\Entity;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ActionFormHandler
{
    public function __construct(private FormFactoryInterface $formFactory)
    {
    }

    public function handleFormRequest(string $type = FormType::class, Request $request = null, Entity $data = null): FormInterface
    {
        $form = $this->formFactory->create($type, $data);

        return $form->handleRequest($request);
    }

    public function isFormSubmittedAndValid(FormInterface $form): bool
    {
        return $form->isSubmitted() && $form->isValid();
    }
}