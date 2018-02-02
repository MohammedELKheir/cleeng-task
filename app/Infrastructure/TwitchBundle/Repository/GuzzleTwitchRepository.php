<?php

namespace App\Infrastructure\TwitchBundle\Repository;

use App\Domain\GuzzleDataInterface;
use GuzzleHttp\Client;
use App\Infrastructure\Helpers\DateTimeHelper;


/**
 * Class GuzzleTwitchRepository is a concrete implementation of App\Domain\GuzzleDataInterface based on Guzzle library.
 *
 * @package TwitchBundle\Repository
 */
class GuzzleTwitchRepository implements GuzzleDataInterface
{
    private $client;

    /**
     * GuzzleTwitchRepository constructor.
     *
     * @param Client $client Instance of Guzzle client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function getChannels()
    {            
            $body = $this->client->get('https://api.twitch.tv/kraken/search/channels?limit=20&query=*',
            [
            'verify' => false,   
            'headers' => [
                'Client-ID'=>'tzcuhtg7k9cu4r67vqoeku40alww2g',
            ],
            ])->getBody();
            $responseArray = json_decode($body);
            $channels=$responseArray->channels;
            $views=array();
            $language=array();
            $game=array();
            $age=array();
            $followers=array();
            $names=array();
            $channelsObject= new \stdclass();
            foreach($channels as $key=>$channel )
            {
               $names[$key]=$channel->name;
               $views[$key]=$channel->views;
               $language[$key]=$channel->language;
               $game[$key]=$channel->game;
               $age[$key]=(isset($channel->created_at)? DateTimeHelper::getAge($channel->created_at) : 0);
               $followers[$key]=$channel->followers;

            }
            $channelsObject->names=$names;
            $channelsObject->views=$views;
            $channelsObject->age=$age;
            $channelsObject->language=$language;
            $channelsObject->game=$game;
            $channelsObject->followers=$followers;
            return $channelsObject;
    
    }

    public function getVideo($channelId)
    {
            $body = $this->client->get('https://api.twitch.tv/kraken/channels/'.$channelId.'/videos?sort=views&limit=1',
            [
            'verify' => false,   
            'headers' => [
                'Client-ID'=>'tzcuhtg7k9cu4r67vqoeku40alww2g',
            ],
            ])->getBody();
            $responseArray = json_decode($body);
            $video=$responseArray->videos[0];
            $videosObject= new \stdclass();
            $videosObject->resolutions=$video->resolutions->chunked;
            $videosObject->age=(isset($video->created_at)? DateTimeHelper::getAge($video->created_at) : 0);
            $videosObject->views=$video->views;
            $videosObject->language=$video->language;
            $videosObject->game=$video->game;
            $videosObject->lengths=$video->length;
            return $videosObject;
    
    }

     public function getChannelsVideos()
    {
            $twitchChannels = $this->getChannels();

            if (is_null($twitchChannels)) {
               return null;
            }
            $viewsArray=array();
            $ageArray=array();
            $languageArray=array();
            $gameArray=array();
            $lengthsArray=array();
            $resolutionsArray=array();

            foreach($twitchChannels->names  as $key=>$name)
            {  
                   $twitchVideos = $this->getVideo($name);
                   $resolutionsArray[$key]=$twitchVideos->resolutions ;
                   $ageArray[$key]=$twitchVideos->age;
                   $viewsArray[$key]=$twitchVideos->views;
                   $languageArray[$key]=$twitchVideos->language;
                   $gameArray[$key]=$twitchVideos->game ?: '-';
                   $lengthsArray[$key]=$twitchVideos->lengths;
            }
            $videosObject= new \stdclass();
            $videosObject->resolutions=$resolutionsArray;
            $videosObject->views=$viewsArray;
            $videosObject->age=$ageArray;
            $videosObject->language=$languageArray;
            $videosObject->game=$gameArray;
            $videosObject->lengths=$resolutionsArray;
            return $videosObject;
    
    }
}
