<?php

namespace App\Repository;

use App\Entity\SeanceEntrainement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SeanceEntrainement|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeanceEntrainement|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeanceEntrainement[]    findAll()
 * @method SeanceEntrainement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceEntrainementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeanceEntrainement::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SeanceEntrainement $entity, bool $flush = true): void
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
    public function remove(SeanceEntrainement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return SeanceEntrainement[] Returns an array of SeanceEntrainement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SeanceEntrainement
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
