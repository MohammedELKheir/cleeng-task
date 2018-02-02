<?php
namespace App\Infrastructure\VimeoBundle\Service;

use Exception;
use App\Domain\StreamingServiceCalculateServiceInterface;
use App\Infrastructure\VimeoBundle\Repository\GuzzleVimeoRepository;
class VimeoCalculationsService implements StreamingServiceCalculateServiceInterface
{

    private $GuzzleVimeoRepository;

    public function __construct(
        GuzzleVimeoRepository $GuzzleVimeoRepository

    ) {
        $this->GuzzleVimeoRepository = $GuzzleVimeoRepository;
    }


    public function calculateChannelStatistics()
    {
        $VimeoChannels = $this->GuzzleVimeoRepository->getChannels();

        if (is_null($VimeoChannels)) {
           return null;
        }
        $avgAge = array_sum($VimeoChannels->age) / count($VimeoChannels->age);
        $avgFollowers = array_sum($VimeoChannels->followers) / count($VimeoChannels->followers);
        $avgVideoCount = array_sum($VimeoChannels->videoCount) / count($VimeoChannels->videoCount);
        $service='Vimeo';
        $type='channel';
        $calculationsObject= new \stdclass();
        $calculationsObject->service=$service;
        $calculationsObject->type=$type;
        $calculationsObject->avgAge=$avgAge;
        $calculationsObject->avgFollowers=$avgFollowers;
	    $calculationsObject->avgVideoCount=$avgVideoCount;
        
        return $calculationsObject;

    }


    public function calculateVideoStatistics()
    {

        $videos = $this->GuzzleVimeoRepository->getChannelsVideos();
        $avgViews = array_sum($videos->views) / count($videos->views);
        $avgLengths = array_sum($videos->lengths) / count($videos->lengths);
        $avgAge = array_sum($videos->age) / count($videos->age);
        $avgLikes = array_sum($videos->likes) / count($videos->likes);
        $avgComments = array_sum($videos->comments) / count($videos->comments);
        $service='Vimeo';
        $type='video';
        $calculationsObject= new \stdclass();
        $calculationsObject->service=$service;
        $calculationsObject->type=$type;
        $calculationsObject->avgViews=$avgViews;
	    $calculationsObject->avgLengths=$avgLengths;
        $calculationsObject->avgLikes=$avgLikes;
        $calculationsObject->avgAge=$avgAge;
        $calculationsObject->avgComments=$avgComments;

        return $calculationsObject;

    }

}	