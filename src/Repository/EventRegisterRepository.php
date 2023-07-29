<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventRegister;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventRegister>
 *
 * @method EventRegister|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRegister|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRegister[]    findAll()
 * @method EventRegister[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRegisterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRegister::class);
    }

    public function save(EventRegister $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EventRegister $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function isUserRegistered(Event $event, User $user): bool
    {
        $eventRegister = $this->findOneBy(['event' => $event, 'collaborator' => $user]);
        return $eventRegister !== null;
    }

//    /**
//     * @return EventRegister[] Returns an array of EventRegister objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EventRegister
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
