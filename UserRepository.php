<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{

    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $query
     * @param int $limit
     * @return array
     */
    public function findUserByQuery(?string $query, int $limit = 5): array
    {
        if (empty($query)) {
            return [];
        }
        $data = $this->createQueryBuilder('u')
            ->select('u.usrName', 'u.usrId')
            ->andWhere('u.usrName LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
        $result = [];
        foreach ($data as $item) {
            $result[] = ['label' => $item['usrName'], 'value' => $item['usrId']];
        }
        return $result;
    }
}
