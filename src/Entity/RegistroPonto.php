<?php

namespace App\Entity;

use App\Repository\RegistroPontoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistroPontoRepository::class)]
class RegistroPonto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeInterface $data_registro = null;

    #[ORM\Column(type: Types::STRING,length: 25, enumType: TipoRegistro::class)]
    private ?TipoRegistro $tipo = null;

    #[ORM\Column]
    private ?int $funcionario = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $processado_em = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataRegistro(): ?\DateTimeInterface
    {
        return $this->data_registro;
    }

    public function setDataRegistro(\DateTimeInterface $data_registro): static
    {
        $this->data_registro = $data_registro;

        return $this;
    }

    public function getTipo(): ?TipoRegistro
    {
        return $this->tipo;
    }

    public function setTipo(TipoRegistro $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
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

    public function getProcessadoEm(): ?\DateTimeInterface
    {
        return $this->processado_em;
    }

    public function setProcessadoEm(?\DateTimeInterface $processado_em): static
    {
        $this->processado_em = $processado_em;

        return $this;
    }
}
