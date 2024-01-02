<?php

namespace App\DataObject;

class LinhaFolhaPonto
{
    private array $valores;
    private int $total;

    public function __construct(
        array $valores,
        int $total
    ){
        $this->valores = $valores;
        $this->total = $total;
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


}