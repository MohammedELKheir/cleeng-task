<?php

namespace App\Domain\Service;
use App\Domain\StatisticServiceInterface;
use App\Domain\StatisticInterface;

/**
 * Class StatisticService is the entry point to our domain layer and implements those actions.
 *
 * @package  App\Domain\Service
 */
class StatisticService implements StatisticServiceInterface
{

    private $StatisticInterface;

    /**
     * StatisticService constructor.
     * @param TweetRepository $repository
     */
    public function __construct(StatisticInterface $StatisticInterface)
    {
        $this->StatisticInterface = $StatisticInterface;
    }

    /**
     * Returns an array with the Statistics

     * @return array of Statistic instances
     */
    public function getStatistics() {
        return $this->StatisticInterface->getStatistics();
    }

        /**
     * Returns an CSV file with the Statistics

     * @return CSV file of Statistics
     */
    public function getStatisticsCSV(){
        return $this->StatisticInterface->getStatisticsCSV();
    }

        /**
     * Returns an statistics data for view 

     * @return an object of arrays of Statistics
     */    
    public function getStatisticsView(){
        return $this->StatisticInterface->getStatisticsView();
    }
}