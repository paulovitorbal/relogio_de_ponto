<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\MinutosExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MinutosExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('minutos', static function(int $minutes) {
                if (!is_numeric($minutes) || $minutes < 0) {
                    throw new \RuntimeException("Quantidade de minutos inválido!");
                }

                $hours = floor($minutes / 60);
                $remainingMinutes = $minutes % 60;

                return sprintf('%02d:%02d', $hours, $remainingMinutes);
            }),
        ];
    }
}
