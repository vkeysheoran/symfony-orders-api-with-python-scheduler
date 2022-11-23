<?php

namespace App\Repository;

use App\Entity\DelayedOrders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DelayedOrders>
 *
 * @method DelayedOrders|null find($id, $lockMode = null, $lockVersion = null)
 * @method DelayedOrders|null findOneBy(array $criteria, array $orderBy = null)
 * @method DelayedOrders[]    findAll()
 * @method DelayedOrders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DelayedOrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DelayedOrders::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DelayedOrders $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(DelayedOrders $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return DelayedOrders[] Returns an array of DelayedOrders objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DelayedOrders
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
