<?php

namespace App\DataObject;

use App\Entity\RegistroPonto;

class LinhaFolhaPonto
{
    private array $valores;
    private int $total;
    private \DateTimeImmutable $data;

    /**
     * @param RegistroPonto[] $valores
     * @param int $total
     * @throws \Exception
     */
    public function __construct(
        array $valores,
        int $total
    ){
        $this->valores = $valores;
        $this->total = $total;
        if (count($valores)){
            $this->data = current($valores)->getDataRegistro();
        }
    }

    /**
     * @return array
     */
    public function getValores(): array
    {
        return $this->valores;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    public function getData(): \DateTimeImmutable
    {
        return $this->data;
    }


}