<?php

namespace App\Repository;

use App\Entity\ConsultantData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConsultantData>
 */
class ConsultantDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsultantData::class);
    }
    
    public function findByConsultant(int $consultantId): array
    {
        return $this->createQueryBuilder('cd')
            ->andWhere('cd.consultant = :consultantId')
            ->setParameter('consultantId', $consultantId)
            ->orderBy('cd.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return ConsultantData[] Returns an array of ConsultantData objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ConsultantData
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
