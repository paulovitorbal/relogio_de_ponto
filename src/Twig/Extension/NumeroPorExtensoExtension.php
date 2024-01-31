<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\MinutosExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WGenial\NumeroPorExtenso\NumeroPorExtenso;

class NumeroPorExtensoExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('numeroPorExtenso', static function($valor) {
                if (!is_numeric($valor)) {
                    throw new \RuntimeException("Valor inválido!".$valor);
                }
                $extenso = new NumeroPorExtenso;
                return $extenso->converter($valor);
            }),
        ];
    }
}
