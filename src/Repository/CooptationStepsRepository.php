<?php

namespace App\Repository;

use App\Entity\Cooptation;
use App\Entity\CooptationSteps;
use App\Entity\StepCooptation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CooptationSteps>
 *
 * @method CooptationSteps|null find($id, $lockMode = null, $lockVersion = null)
 * @method CooptationSteps|null findOneBy(array $criteria, array $orderBy = null)
 * @method CooptationSteps[]    findAll()
 * @method CooptationSteps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CooptationStepsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CooptationSteps::class);
    }

    public function save(CooptationSteps $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CooptationSteps $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function hasPreviousSteps(Cooptation $cooptation, StepCooptation $stepCooptation): bool
    {
        $lastCooptationStep = $this->createQueryBuilder('cs')
            ->where('cs.cooptation = :cooptation')
            ->setParameter('cooptation', $cooptation)
            ->orderBy('cs.stepCooptation', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        $lastStepCooptation = $lastCooptationStep?->getStepCooptation();
        return $lastCooptationStep !== null && $lastStepCooptation->getId() === ($stepCooptation->getId() - 1);

    }

//    /**
//     * @return CooptationSteps[] Returns an array of CooptationSteps objects
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

//    public function findOneBySomeField($value): ?CooptationSteps
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
