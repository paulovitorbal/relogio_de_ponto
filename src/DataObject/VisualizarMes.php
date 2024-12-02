<?php

declare(strict_types=1);

namespace App\DataObject;

class VisualizarMes
{
    public function __construct(private \DateTimeImmutable $mesAno, private int $totalSegundosMes, private int $totalAcumulado) {
    }

    public function getMes(): string
    {
        return $this->mesAno->format('m');
    }
    public function getAno(): string
    {
        return $this->mesAno->format('Y');
    }

    public function getTotalSegundosMes(): int
    {
        return $this->totalSegundosMes;
    }

    public function getTotalAcumulado(): int
    {
        return $this->totalAcumulado;
    }


    public function __toString(): string
    {
        return json_encode($this);
    }

}