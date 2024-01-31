<?php

namespace App\Entity;

use App\Repository\ValeTransporteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValeTransporteRepository::class)]
class ValeTransporte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $funcionario = null;

    #[ORM\Column]
    private int $quantidadeDias = 0;

    #[ORM\Column]
    private int $custoDiarioPassagem = 0;

    #[ORM\Column]
    private int $mes = 0;

    #[ORM\Column]
    private int $ano = 0;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeInterface $dataEmissao = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFuncionario(): ?int
    {
        return $this->funcionario;
    }

    public function setFuncionario(int $funcionario): static
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    public function getQuantidadeDias(): int
    {
        return $this->quantidadeDias;
    }

    public function setQuantidadeDias(int $quantidadeDias): static
    {
        $this->quantidadeDias = $quantidadeDias;

        return $this;
    }

    public function getCustoDiarioPassagem(): int
    {
        return $this->custoDiarioPassagem;
    }

    public function setCustoDiarioPassagem(int $custoDiarioPassagem): static
    {
        $this->custoDiarioPassagem = $custoDiarioPassagem;

        return $this;
    }

    public function getMes(): int
    {
        return $this->mes;
    }

    public function setMes(int $mes): static
    {
        $this->mes = $mes;

        return $this;
    }

    public function getAno(): int
    {
        return $this->ano;
    }

    public function setAno(int $ano): static
    {
        $this->ano = $ano;

        return $this;
    }

    public function getDataEmissao(): ?\DateTimeInterface
    {
        return $this->dataEmissao;
    }

    public function setDataEmissao(\DateTimeInterface $dataEmissao): static
    {
        $this->dataEmissao = $dataEmissao;

        return $this;
    }
}
