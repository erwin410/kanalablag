<?php

namespace App\Repository;

use App\Entity\Blag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Blag>
 *
 * @method Blag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blag[]    findAll()
 * @method Blag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blag::class);
    }

    public function findAllWithCategory()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
            SELECT p, c
            FROM App\Entity\Blag p
            JOIN p.category c
        ');

        return $query->getResult();
    }

//    /**
//     * @return Blag[] Returns an array of Blag objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Blag
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
