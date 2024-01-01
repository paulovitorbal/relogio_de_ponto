<?php

namespace App\Tests\Repository;

use App\Entity\RegistroPonto;
use App\Repository\RegistroPontoRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class RegistroPontoRepositoryTest extends TestCase
{

    public function testTempoTotal4entradas()
    {
        $valores=[];
        $valores[] = $this->createRegistroPonto('2024/01/01 13:01:00');
        $valores[] = $this->createRegistroPonto('2024/01/01 13:02:00');
        $valores[] = $this->createRegistroPonto('2024/01/01 13:03:00');
        $valores[] = $this->createRegistroPonto('2024/01/01 13:04:00');
        $repositorio = new RegistroPontoRepository($this->createMock(ManagerRegistry::class));

        $this->assertEquals(2, $repositorio->tempoTotal($valores));


    }
    public function testTempoTotal3entradas()
    {
        $valores=[];
        $valores[] = $this->createRegistroPonto('2024/01/01 13:01:00');
        $valores[] = $this->createRegistroPonto('2024/01/01 13:02:00');
        $valores[] = $this->createRegistroPonto('2024/01/01 13:03:00');
        $repositorio = new RegistroPontoRepository($this->createMock(ManagerRegistry::class));

        $this->assertEquals(8, $repositorio->tempoTotal($valores, new \DateTimeImmutable('2024/01/01 13:10:00')));


    }

    public function createRegistroPonto(string $tempo): RegistroPonto
    {
        $a = new RegistroPonto();
        $a->setDataRegistro(new \DateTimeImmutable($tempo));
        return $a;
    }
}
