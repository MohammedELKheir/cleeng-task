<?php

namespace App\Domain;

/**
 * Interface StatisticInterface defines the common methods a concrete StatisticInterface class must implement.
 *
 * @package CoreDomain
 */
interface StatisticServiceInterface
{
    /**
     * Returns an array with the Statistics
     *
     *
     *
     * @return array of Statistic instances
     */
    public function getStatistics();

        /**
     * Returns a CSV file with the Statistics
     *
     *
     *
     * @return array of Statistic instances
     */
    public function getStatisticsCSV();

        /**
     * Returns an array with the Statistics for view
     *
     *
     *
     * @return array of Statistic instances
     */
    public function getStatisticsView();
}