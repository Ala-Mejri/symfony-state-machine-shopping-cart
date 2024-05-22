<?php

declare(strict_types=1);

namespace App\Shared\Application\Helper;

final class StringHelper
{
    public function addSeparatorBetweenCaps(string $string, ?string $separator = ' '): string
    {
        return preg_replace('/\B([A-Z])/', $separator . '$1', $string);
    }
}