<?php

namespace  App\Infrastructure\VimeoBundle\Repository;

use GuzzleHttp\Client;
use App\Infrastructure\Helpers\DateTimeHelper;
use App\Domain\GuzzleDataInterface;


/**
 * Class GuzzleVimeoRepository is a concrete implementation of App\Domain\GuzzleDataInterface based on Guzzle library.
 *
 * @package VimeoBundle\Repository
 */
class GuzzleVimeoRepository implements GuzzleDataInterface
{
    private $client;

    /**
     * GuzzleVimeoRepository constructor.
     *
     * @param Client $client Instance of Guzzle client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function getChannels()
    {
            
            $body = $this->client->get('https://api.vimeo.com/channels?per_page=20&sort=followers',
            [
            'verify' => false,  
            'headers' => [
                'Authorization'=>'Bearer 405116cecd6889d0f510fec7a72e9eb7',
            ],
            ])->getBody();
            $responseArray = json_decode($body);
            $channels=$responseArray->data;
            $age=array();
            $videoCount=array();
            $followers=array();
            $ids=array();
            $channelsObject= new \stdclass();
            foreach($channels as $key=>$channel )
            {
               $ids[$key]=substr($channel->uri, strrpos($channel->uri, '/') + 1);
               $age[$key]=DateTimeHelper::getAge($channel->created_time);
               $videoCount[$key]=$channel->metadata->connections->videos->total;
               $followers[$key]=$channel->metadata->connections->users->total;

            }
            $channelsObject->ids=$ids;
            $channelsObject->age=$age;
            $channelsObject->videoCount=$videoCount;
            $channelsObject->followers=$followers;
            return $channelsObject;
    }

    public function getVideo($channelId)
    {
            $body = $this->client->get('https://api.vimeo.com/channels/'.$channelId.'/videos?per_page=1&sort=plays',
            [
            'verify' => false,    
            'headers' => [
                'Authorization'=>'Bearer 405116cecd6889d0f510fec7a72e9eb7',
            ],
            ])->getBody();
            $responseArray = json_decode($body);
            $video=$responseArray->data[0];
            $videosObject= new \stdclass();
            $videosObject->lengths=$video->duration;
            $videosObject->comments=$video->metadata->connections->comments->total;
            $videosObject->views=$video->stats->plays;
            $videosObject->likes=$video->metadata->connections->likes->total;
            $videosObject->age=DateTimeHelper::getage($video->created_time);
            return $videosObject;
    }


    public function getChannelsVideos()
    {
            $vimeoChannels = $this->getChannels();

            if (is_null($vimeoChannels)) {
               return null;
            }
            $viewsArray=array();
            $likesArray=array();
            $commentsArray=array();
            $lengthsArray=array();
            $ageArray=array();

            foreach($vimeoChannels->ids  as $key=>$id)
            {  
                   $vimeoVideos = $this->getVideo($id);
                   if($vimeoVideos)
                    {  
                           $ageArray[$key]=$vimeoVideos->age ;
                           $viewsArray[$key]=$vimeoVideos->views;
                           $commentsArray[$key]=$vimeoVideos->comments;
                           $likesArray[$key]=$vimeoVideos->likes;
                           $lengthsArray[$key]=$vimeoVideos->lengths;
                    }
            }
            $videosObject= new \stdclass();
            $videosObject->age=$ageArray;
            $videosObject->views=$viewsArray;
            $videosObject->likes=$likesArray;
            $videosObject->comments=$commentsArray;
            $videosObject->lengths=$lengthsArray;
            return $videosObject;
    
    }
}
