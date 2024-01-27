<?php

namespace App\Entity;

use App\Repository\FuncionarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FuncionarioRepository::class)]
class Funcionario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1024)]
    private ?string $nome = null;

    #[ORM\Column]
    private ?int $custoDiarioPassagem = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCustoDiarioPassagem(): int
    {
        return $this->custoDiarioPassagem;
    }

    public function setCustoDiarioPassagem(string $custoDiarioPassagem): static
    {
        $this->custoDiarioPassagem = $custoDiarioPassagem;

        return $this;
    }
}
