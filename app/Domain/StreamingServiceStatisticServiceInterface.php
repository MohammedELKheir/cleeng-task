<?php

namespace App\Domain;

/**
 * Interface StreamingServiceStatisticServiceInterface defines the common methods a concrete StreamingServiceStatisticServiceInterface class must implement.
 *
 */
interface StreamingServiceStatisticServiceInterface
{
    /**
     * Saving channels data 
     * 
     */
    public function save();
    /**
     * generating channel data  
     * 
     */    
    public function generateChannelStatistics();
    /**
     * generating videos data  
     * 
     */
    public function generateVideoStatistics();


}