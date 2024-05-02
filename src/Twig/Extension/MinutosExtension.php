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
                if (!is_numeric($minutes)) {
                    throw new \RuntimeException("Quantidade de minutos inválido!".$minutes);
                }
                $negative = $minutes<0;
                if ($negative){
                    $minutes *= -1;
                }
                $hours = floor($minutes / 60);
                $remainingMinutes = $minutes % 60;
                return sprintf('%s%02d:%02d', $negative?'-': '', $hours, $remainingMinutes);
            }),
        ];
    }
}
