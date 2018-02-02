<?php

namespace App\Infrastructure\YoutubeBundle\Service;

use App\Domain\StatisticInterface;
use App\Domain\StreamingServiceStatisticServiceInterface;
use App\Infrastructure\YoutubeBundle\Repository\GuzzleYoutubeRepository;
use App\Infrastructure\YoutubeBundle\service\YoutubeCalculationsService;


class YoutubeStatisticsService implements StreamingServiceStatisticServiceInterface
{

    private $YoutubeCalculationsService;
    private $StatisticInterface;

    public function __construct(
        YoutubeCalculationsService $YoutubeCalculationsService,
        StatisticInterface $StatisticInterface

    ) {
        $this->YoutubeCalculationsService = $YoutubeCalculationsService;
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
        $youtubeCalculations = $this->YoutubeCalculationsService->calculateChannelStatistics();

        if (is_null($youtubeCalculations)) {
           return null;
        }

        $Channels=array();
        $Channels[] = array('name' =>'Views','value'=>$youtubeCalculations->avgViews,'statistic' => 'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        $Channels[] = array('name' =>'Followers','value'=>$youtubeCalculations->avgFollowers,'statistic' =>'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        $Channels[] = array('name' =>'Videos','value'=>$youtubeCalculations->avgVideoCount,'statistic' =>'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        $Channels[] = array('name' =>'Age','value'=>$youtubeCalculations->avgAge,'statistic' =>'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        return $Channels;
    }


    public function generatevideoStatistics()
    {

        $youtubeCalculations = $this->YoutubeCalculationsService->calculateVideoStatistics();

        if (is_null($youtubeCalculations)) {
           return null;
        }

        $videos[] = array('name' =>'Top Resolutions','value'=>$youtubeCalculations->valueResolutions,'statistic' => $youtubeCalculations->percentageResolutions.'%','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        $videos[] = array('name' =>'Views','value'=>$youtubeCalculations->avgViews,'statistic' => 'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        $videos[] = array('name' =>'Lengths','value'=>$youtubeCalculations->avgLengths,'statistic' =>'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        $videos[] = array('name' =>'Likes','value'=>$youtubeCalculations->avgLikes,'statistic' =>'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        $videos[] = array('name' =>'Dislikes','value'=>$youtubeCalculations->avgDislikes,'statistic' => 'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        $videos[] = array('name' =>'Comments','value'=>$youtubeCalculations->avgComments,'statistic' => 'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);
        $videos[] = array('name' =>'Age','value'=>$youtubeCalculations->avgAge,'statistic' =>'Average','service'=>$youtubeCalculations->service,'type'=> $youtubeCalculations->type);

        return $videos;
    }
}
