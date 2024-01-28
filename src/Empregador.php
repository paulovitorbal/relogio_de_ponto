<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class Empregador
{
    private String $cpf;
    private String $nome;

    public function __construct(
        ContainerBagInterface $params,
    ) {
        $this->nome = $params->get("EMPREGADOR");
        $this->cpf = $params->get("CPF_EMPREGADOR");
    }

    public function getCpf(): mixed
    {
        return $this->cpf;
    }

    public function getNome(): mixed
    {
        return $this->nome;
    }



}