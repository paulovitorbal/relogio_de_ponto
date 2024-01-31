<?php

namespace App\Repository;

use App\Entity\ValeTransporte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ValeTransporte>
 *
 * @method ValeTransporte|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValeTransporte|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValeTransporte[]    findAll()
 * @method ValeTransporte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValeTransporteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ValeTransporte::class);
    }

//    /**
//     * @return ValeTransporte[] Returns an array of ValeTransporte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ValeTransporte
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
