<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\ProjectSearch;
use App\Entity\TypeProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findAllVisible(ProjectSearch $search):Query
    {
        $query = $this->createQueryBuilder('p');
        $query = $query->innerJoin('p.client','c');
        $query = $query->select('p','c');
        //$query = $query->innerJoin(TypeProject::class,'t');
        if ($search->getTypeProject()->count()>0)
        {
            $query = $query
                ->andWhere('p.TypeProject IN (:TypeProject)')
                ->setParameter('TypeProject',$search->getProjects());
        }
        return $query->getQuery();
    }

    // /**
    //  * @return Project[] Returns an array of Project objects
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
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param string $project
     * @param int $maxResults
     * @return int|array|string
     */
    public function search(string $project, int $maxResults = 15)
    {
        return $this->createQueryBuilder('p')
            ->where('p.code LIKE :project')
            ->setParameter('project' , "%$project%")
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getArrayResult();
    }
}
