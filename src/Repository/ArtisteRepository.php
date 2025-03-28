<?php

namespace App\Repository;

use App\Entity\Artiste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artiste>
 *
 * @method Artiste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artiste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artiste[]    findAll()
 * @method Artiste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artiste::class);
    }

//    /**
//     * @return Artiste[] Returns an array of Artiste objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function listeArtistesCompletePaginee():Query
    {
        return $this->createQueryBuilder('art')
            ->select('art', 'a')
            ->leftJoin('art.albums', 'a')
            ->orderBy('art.nom', 'ASC')
            ->getQuery();
    }
    public function listeArtistes():array
    {
        return $this->createQueryBuilder('art')
            ->select('art', 'a')
            ->leftJoin('art.albums', 'a')
            ->orderBy('art.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @return QueryBuilder
     */

    public function artisteListeSimple(): QueryBuilder{
        return $this->createQueryBuilder('art')
        ->orderBy('art.nom', 'ASC');
    }

}
