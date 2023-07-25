<?php

namespace App\Repository;

use App\Entity\SkillsLevels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SkillsLevels>
 *
 * @method SkillsLevels|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillsLevels|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillsLevels[]    findAll()
 * @method SkillsLevels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillsLevelsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillsLevels::class);
    }

//    /**
//     * @return SkillsLevels[] Returns an array of SkillsLevels objects
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

//    public function findOneBySomeField($value): ?SkillsLevels
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
