<?php

namespace App\Domain;

/**
 * Interface StatisticInterface defines the common methods a concrete StatisticInterface class must implement.
 *
 * @package CoreDomain
 */
interface StatisticInterface
{
    /**
     * Returns an array with the Statistics
     *
     *
     *
     * @return array of Statistic instances
     */
    public function getStatisticsCSV();
    public function getStatisticsView();
    public function getStatistics();
    public function create(array $data);

}