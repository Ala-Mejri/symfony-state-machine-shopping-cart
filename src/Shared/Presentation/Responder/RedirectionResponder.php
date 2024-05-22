<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Responder;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final readonly class RedirectionResponder
{
    public function __construct(private RouterInterface $router)
    {
    }

    public function redirectToRoute(string $route, array $parameters = [], int $status = 302): RedirectResponse
    {
        return $this->redirect($this->generateUrl($route, $parameters), $status);
    }

    public function redirect(string $url, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }

    protected function generateUrl(
        string $route,
        array  $parameters = [],
        int    $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
    ): string
    {
        return $this->router->generate($route, $parameters, $referenceType);
    }
}