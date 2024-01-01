<?php

namespace App\Repository;

use App\Entity\RegistroPonto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RegistroPonto>
 *
 * @method RegistroPonto|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegistroPonto|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegistroPonto[]    findAll()
 * @method RegistroPonto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistroPontoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistroPonto::class);
    }

    /**
     * @return RegistroPonto[] Returns an array of RegistroPonto objects
     */
    public function findByFuncionario($value): array
    {
        $fromDate = new \DateTimeImmutable('now');
        $fromDate = $fromDate->setTime(0, 0);
        $toDate = $fromDate->modify('+1 day');
        return $this->createQueryBuilder('r')
            ->andWhere('r.funcionario = :val')->setParameter('val', $value)
            ->andWhere('r.data_registro >= :fromDate')->setParameter('fromDate', $fromDate)
            ->andWhere('r.data_registro <= :toDate')->setParameter('toDate', $toDate)
            ->orderBy('r.data_registro', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param RegistroPonto[] $registros
     * @return int
     */
    public function tempoTotal(array $registros, \DateTimeInterface $agora = null): int{
        usort($registros, static function(RegistroPonto $a, RegistroPonto $b){
            return $a->getDataRegistro()->getTimestamp() - $b->getDataRegistro()->getTimestamp();
        });
        $tempoTotal = 0;
        $pares = array_chunk($registros, 2);
        foreach($pares as $par){
            /** @var RegistroPonto $maior */
            $maior = $par[1] ?? null;
            /** @var RegistroPonto $menor */
            $menor = $par[0] ?? null;
            if ($maior==null && $agora != null){

                $tempoTotal += $agora->getTimestamp() - $menor->getDataRegistro()->getTimestamp();
            }else{
                $tempoTotal += $maior->getDataRegistro()->getTimestamp() - $menor->getDataRegistro()->getTimestamp();
            }
        }

        return $tempoTotal/60;
    }
}
