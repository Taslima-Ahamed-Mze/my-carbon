<?php

namespace App\Repository;

use App\Entity\Formation;
use App\Entity\FormationRegister;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormationRegister>
 *
 * @method FormationRegister|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationRegister|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationRegister[]    findAll()
 * @method FormationRegister[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRegisterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationRegister::class);
    }


    public function save(FormationRegister $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FormationRegister $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function isUserRegistered(Formation $formation, User $user): bool
    {
        $formationRegister = $this->findOneBy(['formation' => $formation, 'collaborator' => $user]);
        return $formationRegister !== null;
    }

    public function formationRegister(Formation $formation, User $user): FormationRegister|null
    {
        $formationRegister = $this->findOneBy(['formation' => $formation, 'collaborator' => $user]);
        return $formationRegister;
    }

    public function paginationQuery($collaborator)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
        SELECT f
        FROM App\Entity\FormationRegister f
        JOIN f.collaborator c
        WHERE c = :collaborator
    ')
            ->setParameter('collaborator', $collaborator);
        return $query->getResult();

    }
    public function findNotNullCertificateNames()
    {
        return $this->createQueryBuilder('fr')
            ->where('fr.certificateName IS NOT NULL')
            ->andWhere('fr.status = :status')
            ->setParameter('status', false)
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return FormationRegister[] Returns an array of FormationRegister objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FormationRegister
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}