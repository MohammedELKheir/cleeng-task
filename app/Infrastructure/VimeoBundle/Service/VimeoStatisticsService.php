<?php

namespace App\Infrastructure\VimeoBundle\Service;

use App\Domain\StatisticInterface;
use App\Domain\StreamingServiceStatisticServiceInterface;
use App\Infrastructure\VimeoBundle\Repository\GuzzleVimeoRepository;
use App\Infrastructure\VimeoBundle\service\VimeoCalculationsService;


class VimeoStatisticsService implements StreamingServiceStatisticServiceInterface
{

    private $VimeoCalculationsService;
    private $StatisticInterface;

    public function __construct(
        VimeoCalculationsService $VimeoCalculationsService,
        StatisticInterface $StatisticInterface

    ) {
        $this->VimeoCalculationsService = $VimeoCalculationsService;
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
        $VimeoCalculations = $this->VimeoCalculationsService->calculateChannelStatistics();

        if (is_null($VimeoCalculations)) {
           return null;
        }

        $Channels=array();
        $Channels[] = array('name' =>'Followers','value'=>$VimeoCalculations->avgFollowers,'statistic' =>'Average','service'=>$VimeoCalculations->service,'type'=> $VimeoCalculations->type);
        $Channels[] = array('name' =>'Videos','value'=>$VimeoCalculations->avgVideoCount,'statistic' =>'Average','service'=>$VimeoCalculations->service,'type'=> $VimeoCalculations->type);
        $Channels[] = array('name' =>'Age','value'=>$VimeoCalculations->avgAge,'statistic' =>'Average','service'=>$VimeoCalculations->service,'type'=> $VimeoCalculations->type);

        return $Channels;
    }


    public function generateVideoStatistics()
    {

        $VimeoCalculations = $this->VimeoCalculationsService->calculateVideoStatistics();

        if (is_null($VimeoCalculations)) {
           return null;
        }

        $videos[] = array('name' =>'Views','value'=>$VimeoCalculations->avgViews,'statistic' => 'Average','service'=>$VimeoCalculations->service,'type'=> $VimeoCalculations->type);
        $videos[] = array('name' =>'Lengths','value'=>$VimeoCalculations->avgLengths,'statistic' =>'Average','service'=>$VimeoCalculations->service,'type'=> $VimeoCalculations->type);
        $videos[] = array('name' =>'Likes','value'=>$VimeoCalculations->avgLikes,'statistic' =>'Average','service'=>$VimeoCalculations->service,'type'=> $VimeoCalculations->type);
        $videos[] = array('name' =>'Age','value'=>$VimeoCalculations->avgAge,'statistic' => 'Average','service'=>$VimeoCalculations->service,'type'=> $VimeoCalculations->type);
        $videos[] = array('name' =>'Comments','value'=>$VimeoCalculations->avgComments,'statistic' => 'Average','service'=>$VimeoCalculations->service,'type'=> $VimeoCalculations->type);

        return $videos;
    }
}
