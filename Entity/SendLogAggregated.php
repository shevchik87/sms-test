<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SendLogAggregation
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SendLogAggregatedRepository")
 * @ORM\Table(name="send_log_aggregated")
 */
class SendLogAggregated
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(name="log_agg_id")
     */
    private $logAggId;

    /**
     * @var string
     * @ORM\Column(name="log_agg_date")
     */
    private $logAggDate;

    /**
     * @var int
     * @ORM\Column(name="log_agg_usr_id")
     */
    private $logAggUsrId;

    /**
     * @var int
     * @ORM\Column(name="log_agg_cnt_id")
     */
    private $logAggCntId;

    /**
     * @var int
     * @ORM\Column(name="log_agg_count_sent_success")
     */
    private $logAggCountSentSuccess;

    /**
     * @var int
     * @ORM\Column(name="log_agg_count_sent_fail")
     */
    private $logAggCountSentFail;

}
