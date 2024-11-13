<?php

namespace App\Feed\Repository;

use App\Feed\Entity\SingleFeedMemento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\ResourceRepositoryTrait;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @extends ServiceEntityRepository<SingleFeedMemento>
 */
class SingleFeedMementoRepository extends ServiceEntityRepository implements RepositoryInterface
{
    use ResourceRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SingleFeedMemento::class);
    }

    public function countFeedsForGivenGeneration(string $generationId): int
    {
        return $this->createQueryBuilder('o')
            ->select('COUNT(o) as count')
            ->andWhere('o.generationId = :generationId')
            ->setParameter('generationId', $generationId)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

//    /**
//     * @return SingleFeedMemento[] Returns an array of SingleFeedMemento objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SingleFeedMemento
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
