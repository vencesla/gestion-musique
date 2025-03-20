<?php

namespace App\Repository;

use App\Entity\Morceau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Morceau>
 *
 * @method Morceau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Morceau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Morceau[]    findAll()
 * @method Morceau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MorceauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Morceau::class);
    }

//    /**
//     * @return Morceau[] Returns an array of Morceau objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Morceau
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
