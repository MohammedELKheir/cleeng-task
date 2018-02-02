<?php

namespace App\Domain;

/**
 * Interface StreamingServiceStatisticServiceInterface defines the common methods a concrete StreamingServiceStatisticServiceInterface class must implement.
 *
 */
interface ServerStatisticServiceInterface
{
    /**
     * generating and saving services data 
     * 
     */
    public function serverStatisticsGenerator();


}