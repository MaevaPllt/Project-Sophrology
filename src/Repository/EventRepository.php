<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    // filtre actualités admin
    public function findLikeName( string $name)
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->Where("e.name LIKE :name")
            ->orWhere("e.resume LIKE :name")
            ->setParameter('name', '%' . $name . '%')
                  ;
              return $queryBuilder->getQuery()->getResult();
    }

    // filtre dernières actualités homepage
    public function getLastNews()
    {
        $queryBuilder = $this->createQueryBuilder("e")
            ->orderBy("e.date", "DESC")
            ->setMaxResults("3")
        ;
        return $queryBuilder->getQuery()->getResult();
    }

    /*

          // paginer les events
            public function getPaginatedEvents(int $page, $length)
            {
                $queryBuilder = $this->createQueryBuilder("p")
                    ->orderBy("p.date", "DESC")
                    ->setFirstResult(($page * $length) - $length )
                    ->setMaxResults($length)
                    ;

                return $queryBuilder->getQuery()->getResult();

            }

            // récupération du nombre d'éléments pour gérer le nombre de pages
            public function getCountEvents()
            {
                return $this->createQueryBuilder("p")
                    ->select("COUNT(p.id)")
                    ->getQuery()
                    ->getSingleScalarResult();
            }
    */

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
