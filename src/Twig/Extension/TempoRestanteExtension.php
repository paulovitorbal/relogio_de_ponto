<?php

namespace App\Twig\Extension;

use App\Entity\RegistroPonto;
use App\Repository\RegistroPontoRepository;
use App\Twig\Runtime\TempoRestanteRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Webmozart\Assert\Assert;

class TempoRestanteExtension extends AbstractExtension
{
    /**
     * @param RegistroPonto[] $valores
     * @return string
     */
    public static function tempoRestante(array $valores): string
    {
        Assert::allIsInstanceOf($valores, RegistroPonto::class);
        $somatorio = RegistroPontoRepository::tempoTotal($valores);
        if ($somatorio === 0 && count($valores)===1){
            return $valores[0]->getDataRegistro()->add(\DateInterval::createFromDateString("8 hours"))->format("H:i");
        }
        if ($somatorio>0 && count($valores)>1){
            return end($valores)->getDataRegistro()->add(\DateInterval::createFromDateString((8*60-$somatorio)." minutes"))->format("H:i");
        }
        dump($somatorio);
        return "";
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('tempoRestante', function($valores){
                return self::tempoRestante($valores);
            }),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('tempoRestante', function($valores){
                return self::tempoRestante($valores);
            }),
        ];
    }
}
