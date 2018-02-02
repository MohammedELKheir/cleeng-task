<?php

namespace App\Infrastructure\TwitchBundle\Service;

use App\Domain\StatisticInterface;
use App\Domain\StreamingServiceStatisticServiceInterface;
use App\Infrastructure\TwitchBundle\Repository\GuzzleTwitchRepository;
use App\Infrastructure\TwitchBundle\service\TwitchCalculationsService;

class TwitchStatisticsService implements StreamingServiceStatisticServiceInterface
{

    private $TwitchCalculationsService;
    private $StatisticInterface;

    public function __construct(
        TwitchCalculationsService $TwitchCalculationsService,
        StatisticInterface $StatisticInterface

    ) {
        $this->TwitchCalculationsService = $TwitchCalculationsService;
        $this->StatisticInterface = $StatisticInterface;
    }

    public function save()
    {
       $channelsData=$this->generateChannelStatistics();
       $videosData=$this->generatevideoStatistics();
       $data = array_merge($channelsData,$videosData);
       return $this->StatisticInterface->create($data);
    }

    public function generateChannelStatistics()
    {
        $twitchCalculations = $this->TwitchCalculationsService->calculateChannelStatistics();

        if (is_null($twitchCalculations)) {
           return null;
        }

        $Channels=array();
        $Channels[] = array('name' =>'Views','value'=>$twitchCalculations->avgViews,'statistic' => 'Average','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        $Channels[] = array('name' =>'Followers','value'=>$twitchCalculations->avgFollowers,'statistic' =>'Average','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        $Channels[] = array('name' =>'Age','value'=>$twitchCalculations->avgAge,'statistic' =>'Average','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        $Channels[] = array('name' =>'Top Game','value'=>$twitchCalculations->valueGame,'statistic' =>$twitchCalculations->percentageGame.'%','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        $Channels[] = array('name' =>'Top Language','value'=>$twitchCalculations->valueLanguage,'statistic' => $twitchCalculations->percentageLanguage.'%','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);

        return $Channels;
    }


    public function generateVideoStatistics()
    {

        $twitchCalculations = $this->TwitchCalculationsService->calculateVideoStatistics();

        if (is_null($twitchCalculations)) {
           return null;
        }

        $videos[] = array('name' =>'Top Resolutions','value'=>$twitchCalculations->valueResolutions,'statistic' => $twitchCalculations->percentageResolutions.'%','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        $videos[] = array('name' =>'Views','value'=>$twitchCalculations->avgViews,'statistic' => 'Average','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        $videos[] = array('name' =>'Age','value'=>$twitchCalculations->avgAge,'statistic' =>'Average','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        $videos[] = array('name' =>'Lengths','value'=>$twitchCalculations->avgLengths,'statistic' =>'Average','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        $videos[] = array('name' =>'Top Game','value'=>$twitchCalculations->valueGame,'statistic' =>$twitchCalculations->percentageGame.'%','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        $videos[] = array('name' =>'Top Language','value'=>$twitchCalculations->valueLanguage,'statistic' => $twitchCalculations->percentageLanguage.'%','service'=>$twitchCalculations->service,'type'=> $twitchCalculations->type);
        return $videos;
    }
}
