<?php

namespace App\Repository;

use App\DataObject\LinhaFolhaPonto;
use App\Entity\RegistroPonto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Webmozart\Assert\Assert;

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
     * @return RegistroPonto[] Returns an array of RegistroPonto objects
     */
    public function visualizarFolhaPontoMesAno(int $funcionario, int $ano, int $mes): array
    {
        $fromDate =  \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $ano.'-'.$mes.'-01 00:00:00');
        $toDate = $fromDate->modify('+1 month');
        $rows =  $this->createQueryBuilder('r')
            ->select('r.data_registro', 'r.id')
            ->andWhere('r.funcionario = :val')->setParameter('val', $funcionario)
            ->andWhere('r.data_registro >= :fromDate')->setParameter('fromDate', $fromDate)
            ->andWhere('r.data_registro < :toDate')->setParameter('toDate', $toDate)
            ->orderBy('r.data_registro', 'ASC')
            ->getQuery()
            ->getResult()
        ;
        $datas = [];
        foreach($rows as $row){
            $data = $row['data_registro'];
            $registro = new RegistroPonto();
            $registro->setDataRegistro($data)->setId($row['id']);
            $datas[$data->format('Ymd')][] = $registro;
        }
        $return = [];
        foreach($datas as $key =>$data){
            $total = $this->tempoTotal($data);
            $return[$key]=new LinhaFolhaPonto($data, $total);
        }
        return $return;

    }
    /**
     * @return RegistroPonto[] Returns an array of RegistroPonto objects
     */
    public function listMeses(): array
    {
        $rows = $this->createQueryBuilder('r')
            ->select('r.data_registro')
            ->orderBy('r.data_registro', 'desc')
            ->getQuery()
            ->getSingleColumnResult()
        ;
        $result = array_map(static function($e){
            $tmp = new \DateTimeImmutable($e);
            return $tmp->format('Ym');
        }, $rows);
        return array_unique($result);
    }

    /**
     * @param RegistroPonto[] $registros
     * @return int
     */
    public static function tempoTotal(array $registros, \DateTimeInterface $agora = null): int{
        Assert::allIsInstanceOf($registros, RegistroPonto::class);
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
            }
            if ($maior != null){
                $tempoTotal += $maior->getDataRegistro()->getTimestamp() - $menor->getDataRegistro()->getTimestamp();
            }
        }

        return $tempoTotal/60;
    }
}
