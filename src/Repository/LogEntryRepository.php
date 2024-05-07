<?php

namespace App\Repository;

use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    public function countLogsByFilters(array $filters): int
    {
        $qb = $this->createQueryBuilder('l');
        $qb->select('COUNT(l.id)');

        if (isset($filters['serviceNames'])) {
            $qb->andWhere('l.serviceName IN (:serviceNames)')
               ->setParameter('serviceNames', explode(',', $filters['serviceNames']));
        }

        if (isset($filters['statusCode'])) {
            $qb->andWhere('l.statusCode = :statusCode')
               ->setParameter('statusCode', $filters['statusCode']);
        }

        if (isset($filters['startDate'])) {
            $qb->andWhere('l.createdAt >= :startDate')
               ->setParameter('startDate', new \DateTime($filters['startDate']));
        }

        if (isset($filters['endDate'])) {
            $qb->andWhere('l.createdAt <= :endDate')
               ->setParameter('endDate', new \DateTime($filters['endDate']));
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
