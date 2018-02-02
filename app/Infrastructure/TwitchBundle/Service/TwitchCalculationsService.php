<?php
namespace App\Infrastructure\TwitchBundle\Service;

use App\Domain\StreamingServiceCalculateServiceInterface;
use App\Infrastructure\TwitchBundle\Repository\GuzzleTwitchRepository;


class TwitchCalculationsService implements StreamingServiceCalculateServiceInterface
{

    private $GuzzleTwitchRepository;

    public function __construct(
        GuzzleTwitchRepository $GuzzleTwitchRepository

    ) {
        $this->GuzzleTwitchRepository = $GuzzleTwitchRepository;
    }

    public function calculateChannelStatistics()
    {
        $twitchChannels = $this->GuzzleTwitchRepository->getChannels();

        if (is_null($twitchChannels)) {
           return null;
        }
        $language = array_count_values($twitchChannels->language);
        arsort($language);
        $valueLanguage = key($language);
        $percentageLanguage = (current($language)/count($twitchChannels->language))*100;
        $game = array_count_values($twitchChannels->game);
        arsort($game);
        $valueGame = key($game);
        $percentageGame = (current($game)/count($twitchChannels->game))*100;
        $avgViews = array_sum($twitchChannels->views) / count($twitchChannels->views);
        $avgFollowers = array_sum($twitchChannels->followers) / count($twitchChannels->followers);
        $avgAge = array_sum($twitchChannels->age) / count($twitchChannels->age);
        $service='Twitch';
        $type='channel';
        $calculationsObject= new \stdclass();
        $calculationsObject->service=$service;
        $calculationsObject->type=$type;
        $calculationsObject->avgAge=$avgAge;
        $calculationsObject->avgFollowers=$avgFollowers;
	    $calculationsObject->avgViews=$avgViews;
	    $calculationsObject->valueGame=$valueGame;
	    $calculationsObject->percentageGame=$percentageGame;
	    $calculationsObject->valueLanguage=$valueLanguage;
	    $calculationsObject->percentageLanguage=$percentageLanguage;
        return $calculationsObject;

    }

    public function calculateVideoStatistics()
    {

        $videos = $this->GuzzleTwitchRepository->getChannelsVideos();
        $resolutions = array_count_values($videos->resolutions);
        arsort($resolutions);
        $valueResolutions = key($resolutions);
        $percentageResolutions = (current($resolutions)/count($videos->resolutions))*100;
        $language = array_count_values($videos->language);
        arsort($language);
        $valueLanguage = key($language);
        $percentageLanguage = (current($language)/count($videos->language))*100;
        $game = array_count_values($videos->game);
        arsort($game);
        $valueGame = key($game);
        $percentageGame = (current($game)/count($videos->game))*100;
        $avgViews = array_sum($videos->views) / count($videos->views);
        $avgLengths = array_sum($videos->lengths) / count($videos->lengths);
        $avgAge = array_sum($videos->age) / count($videos->age);        
        $service='Twitch';
        $type='video';
        $calculationsObject= new \stdclass();
        $calculationsObject->service=$service;
        $calculationsObject->type=$type;
        $calculationsObject->avgViews=$avgViews;
        $calculationsObject->avgAge=$avgAge;
	    $calculationsObject->avgLengths=$avgLengths;
	    $calculationsObject->language=$language;
	    $calculationsObject->valueGame=$valueGame;
	    $calculationsObject->percentageGame=$percentageGame;
	    $calculationsObject->valueLanguage=$valueLanguage;
	    $calculationsObject->percentageLanguage=$percentageLanguage;
	    $calculationsObject->valueResolutions=$valueResolutions;
	    $calculationsObject->percentageResolutions=$percentageResolutions;
        return $calculationsObject;

    }

}	