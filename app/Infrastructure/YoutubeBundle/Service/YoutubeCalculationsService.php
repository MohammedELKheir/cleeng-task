<?php
namespace App\Infrastructure\YoutubeBundle\Service;

use App\Domain\StreamingServiceCalculateServiceInterface;
use App\Infrastructure\YoutubeBundle\Repository\GuzzleYoutubeRepository;


class YoutubeCalculationsService implements StreamingServiceCalculateServiceInterface
{

    private $GuzzleYoutubeRepository;

    public function __construct(
        GuzzleYoutubeRepository $GuzzleYoutubeRepository

    ) {
        $this->GuzzleYoutubeRepository = $GuzzleYoutubeRepository;
    }

    public function calculateChannelStatistics()
    {
        $YoutubeChannels = $this->GuzzleYoutubeRepository->getChannels();

        if (is_null($YoutubeChannels)) {
           return null;
        }
        $avgAge = array_sum($YoutubeChannels->age) / count($YoutubeChannels->age);
        $avgViews = array_sum($YoutubeChannels->views) / count($YoutubeChannels->views);
        $avgFollowers = array_sum($YoutubeChannels->followers) / count($YoutubeChannels->followers);
        $avgVideoCount = array_sum($YoutubeChannels->videoCount) / count($YoutubeChannels->videoCount);
        $service='Youtube';
        $type='channel';
        $calculationsObject= new \stdclass();
        $calculationsObject->service=$service;
        $calculationsObject->type=$type;
        $calculationsObject->avgAge=$avgAge;
        $calculationsObject->avgFollowers=$avgFollowers;
	    $calculationsObject->avgViews=$avgViews;
	    $calculationsObject->avgVideoCount=$avgVideoCount;
        return $calculationsObject;

    }

    public function calculateVideoStatistics()
    {

        $videos = $this->GuzzleYoutubeRepository->getChannelsVideos();
        $resolutions = array_count_values($videos->resolutions);
        arsort($resolutions);
        $valueResolutions = key($resolutions);
        $percentageResolutions = (current($resolutions)/count($videos->resolutions))*100;
        $avgViews = array_sum($videos->views) / count($videos->views);
        $avgLengths = array_sum($videos->lengths) / count($videos->lengths);
        $avgDislikes = array_sum($videos->dislikes) / count($videos->dislikes);
        $avgLikes = array_sum($videos->likes) / count($videos->likes);
        $avgComments = array_sum($videos->comments) / count($videos->comments);
        $avgAge = array_sum($videos->age) / count($videos->age);

        $service='Youtube';
        $type='video';
        $calculationsObject= new \stdclass();
        $calculationsObject->service=$service;
        $calculationsObject->type=$type;
        $calculationsObject->avgAge=$avgAge;
        $calculationsObject->avgViews=$avgViews;
	    $calculationsObject->avgLengths=$avgLengths;
        $calculationsObject->avgLikes=$avgLikes;
        $calculationsObject->avgDislikes=$avgDislikes;
        $calculationsObject->avgComments=$avgComments;
	    $calculationsObject->valueResolutions=$valueResolutions;
	    $calculationsObject->percentageResolutions=$percentageResolutions;
        return $calculationsObject;

    }

}	