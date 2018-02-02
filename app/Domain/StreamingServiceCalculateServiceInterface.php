<?php

namespace App\Domain;

/**
 * Interface StreamingServiceCalculateServiceInterface defines the common methods a concrete StreamingServiceCalculateServiceInterface class must implement.
 *
 */
interface StreamingServiceCalculateServiceInterface
{
    /**
     * calculates statistic data from channels
     * 
     * @return array object of statistics data
     */
    public function calculateChannelStatistics();
    /**
     * calculates statistic data from videos
     * 
     * @return array object of statistics data
     */
    public function calculateVideoStatistics();



}