<?php

namespace App\Repository;

use App\Entity\ProjectDocuments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectDocuments|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectDocuments|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectDocuments[]    findAll()
 * @method ProjectDocuments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectDocumentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectDocuments::class);
    }

    // /**
    //  * @return ProjectDocuments[] Returns an array of ProjectDocuments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectDocuments
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
