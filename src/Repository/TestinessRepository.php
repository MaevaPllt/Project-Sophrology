<?php

namespace App\Repository;

use App\Entity\Testiness;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Testiness|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testiness|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testiness[]    findAll()
 * @method Testiness[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestinessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testiness::class);
    }

    // FILTRE DE TÉMOIGNAGES PAR MOTS-CLÉS
    public function findLikeName( string $name)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->Where("t.name LIKE :name")
            ->setParameter('name', '%' . $name . '%')
        ;
        return $queryBuilder->getQuery()->getResult();
    }


    // /**
    //  * @return Testiness[] Returns an array of Testiness objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Testiness
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
