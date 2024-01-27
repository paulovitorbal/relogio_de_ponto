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
    private ?\DateTimeImmutable $data_registro = null;

    #[ORM\Column(type: Types::STRING,length: 25, enumType: TipoRegistro::class)]
    private ?TipoRegistro $tipo = null;

    #[ORM\Column]
    private ?int $funcionario = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $processado_em = null;


    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataRegistro(): ?\DateTimeImmutable
    {
        return $this->data_registro;
    }

    public function setDataRegistro(\DateTimeImmutable $data_registro): static
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

    public function getProcessadoEm(): ?\DateTimeImmutable
    {
        return $this->processado_em;
    }

    public function setProcessadoEm(?\DateTimeImmutable $processado_em): static
    {
        $this->processado_em = $processado_em;

        return $this;
    }
}
