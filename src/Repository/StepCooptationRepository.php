<?php

namespace App\Repository;

use App\Entity\StepCooptation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StepCooptation>
 *
 * @method StepCooptation|null find($id, $lockMode = null, $lockVersion = null)
 * @method StepCooptation|null findOneBy(array $criteria, array $orderBy = null)
 * @method StepCooptation[]    findAll()
 * @method StepCooptation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StepCooptationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StepCooptation::class);
    }

//    /**
//     * @return StepCooptation[] Returns an array of StepCooptation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StepCooptation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
