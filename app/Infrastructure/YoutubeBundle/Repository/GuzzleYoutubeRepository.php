<?php

namespace  App\Infrastructure\YoutubeBundle\Repository;

use GuzzleHttp\Client;
use App\Infrastructure\Helpers\DateTimeHelper;
use App\Domain\GuzzleDataInterface;


/**
 * Class GuzzleYoutubeRepository is a concrete implementation of App\Domain\GuzzleDataInterface based on Guzzle library.
 *
 * @package YoutubeBundle\Repository
 */
class GuzzleYoutubeRepository implements GuzzleDataInterface
{
    private $client;

    /**
     * GuzzleYoutubeRepository constructor.
     *
     * @param Client $client Instance of Guzzle client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }



    public function getChannels()
    {
            
            $body = $this->client->get('https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=25&order=viewCount&type=channel&key=AIzaSyBO_yK9EDCgnfhU1Exq5_aL4AaCA72rilI',['verify' => false])->getBody();
            $responseArray = json_decode($body);
            $channels=array();
            foreach($responseArray->items as $key=>$channel)
                {
                   $bodyChannel = $this->client->get('https://www.googleapis.com/youtube/v3/channels?part=snippet%2CcontentDetails%2Cstatistics&id='.$channel->id->channelId.'&fields=items&key=AIzaSyBO_yK9EDCgnfhU1Exq5_aL4AaCA72rilI',['verify' => false])->getBody();
                   $bodyChannelDecoded=json_decode($bodyChannel);
                   $channels[$key] =$bodyChannelDecoded->items[0]; 
                 }  
            $channels=$channels;
            $views=array();
            $age=array();
            $videoCount=array();
            $followers=array();
            $ids=array();
            $channelsObject= new \stdclass();
            foreach($channels as $key=>$channel )
            {
               $ids[$key]=$channel->id;
               $views[$key]=$channel->statistics->viewCount;
               $age[$key]=(isset($channel->snippet->publishedAt)? DateTimeHelper::getAge($channel->snippet->publishedAt) : 0);
               $videoCount[$key]=$channel->statistics->videoCount;
               $followers[$key]=$channel->statistics->subscriberCount;

            }
            $channelsObject->ids=$ids;
            $channelsObject->views=$views;
            $channelsObject->age=$age;
            $channelsObject->videoCount=$videoCount;
            $channelsObject->followers=$followers;
            return $channelsObject;
    }


    public function getVideo($channelId)
    {
            $body = $this->client->get('https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='.$channelId
                .'&maxResults=1&order=viewCount&type=video&key=AIzaSyBO_yK9EDCgnfhU1Exq5_aL4AaCA72rilI',['verify' => false])->getBody();
            $responseArray = json_decode($body);
            if(!isset($responseArray->items[0])) return null;
            $bodyVideo = $this->client->get('https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id='.$responseArray->items[0]->id->videoId.'&fields=items(ageGating%2CcontentDetails%2Cid%2Csnippet%2Cstatistics)&key=AIzaSyBO_yK9EDCgnfhU1Exq5_aL4AaCA72rilI',['verify' => false])->getBody();
            $bodyVideoDecoded=json_decode($bodyVideo);
            $responseArray->items =$bodyVideoDecoded->items[0];
            $video=$responseArray->items;
            $videosObject= new \stdclass();
            $videosObject->resolutions=$video->contentDetails->definition;
            $videosObject->age=(isset($video->snippet->publishedAt)? DateTimeHelper::getAge($video->snippet->publishedAt) : 0);
            $videosObject->comments=(isset($video->statistics->commentCount)?$video->statistics->commentCount : 0);
            $videosObject->views=$video->statistics->viewCount;
            $videosObject->likes=$video->statistics->likeCount;
            $videosObject->dislikes=$video->statistics->dislikeCount;
            $videosObject->lengths=DateTimeHelper::convertISO8601DurationToSeconds($video->contentDetails->duration);
            return $videosObject;
    }

    public function getChannelsVideos()
    {
            $youtubeChannels = $this->getChannels();

            if (is_null($youtubeChannels)) {
               return null;
            }
            $viewsArray=array();
            $likesArray=array();
            $commentsArray=array();
            $lengthsArray=array();
            $resolutionsArray=array();
            $dislikesArray=array();
            $ageArray=array();

            foreach($youtubeChannels->ids  as $key=>$id)
            {  
                   $youtubeVideos = $this->getVideo($id);
                   if($youtubeVideos)
                    {  
                           $resolutionsArray[$key]=$youtubeVideos->resolutions ;
                           $viewsArray[$key]=$youtubeVideos->views;
                           $commentsArray[$key]=$youtubeVideos->comments;
                           $likesArray[$key]=$youtubeVideos->likes;
                           $dislikesArray[$key]=$youtubeVideos->dislikes;
                           $lengthsArray[$key]=$youtubeVideos->lengths;
                           $ageArray[$key]=$youtubeVideos->age;

                    }
            }
            $videosObject= new \stdclass();
            $videosObject->age=$ageArray;
            $videosObject->resolutions=$resolutionsArray;
            $videosObject->views=$viewsArray;
            $videosObject->dislikes=$dislikesArray;
            $videosObject->likes=$likesArray;
            $videosObject->comments=$commentsArray;
            $videosObject->lengths=$lengthsArray;
            return $videosObject;
    
    }
}
