<?php

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CountryRepository extends ServiceEntityRepository
{
    /**
     * CountryRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }

    /**
     * @param string $query
     * @param int $limit
     * @return array
     */
    public function findCountryByQuery(?string $query, int $limit = 5): array
    {
        if (empty($query)) {
            return [];
        }
        $data = $this->createQueryBuilder('c')
            ->andWhere('c.cntTitle LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
        $result = [];
        foreach ($data as $item) {
            $result[] = ['label'=>$item['cntTitle'], 'value' => $item['cntId']];
        }
        return $result;
    }
}
