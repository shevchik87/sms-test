<?php

namespace App\Repository;

use App\Entity\FilterReportForm;
use App\Entity\SendLogAggregated;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class SendLogAggregatedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SendLogAggregated::class);
    }

    public function getAggregate(FilterReportForm $form)
    {
        $qb = $this->createQueryBuilder('l')
            ->select('l.logAggDate, SUM(l.logAggCountSentSuccess) as logAggCountSentSuccess, 
            SUM(l.logAggCountSentFail) as logAggCountSentFail')
            ->where('l.logAggDate BETWEEN :from AND :to')
            ->setParameter(':from', $form->getDateFrom()->format('Y-m-d'))
            ->setParameter(':to', $form->getDateTo()->format('Y-m-d'));
        if (!empty($form->getUserId())) {
            $qb->andWhere('l.logAggUsrId = :userId')
                ->setParameter(':userId', $form->getUserId());

        }

        if (!empty($form->getCountryId())) {
            $qb->andWhere('l.logAggCntId = :cntId')
                ->setParameter(':cntId', $form->getCountryId());
        }

        $data = $qb->groupBy('l.logAggDate')
            ->getQuery()
            ->getArrayResult();
        return $data;

    }
}
