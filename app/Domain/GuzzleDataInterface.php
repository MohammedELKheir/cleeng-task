<?php

namespace App\Domain;

/**
 * Interface GuzzleDataInterface defines the common methods a concrete GuzzleDataInterface class must implement.
 *
 * @package App\Domain
 */
interface GuzzleDataInterface
{
    /**
     * Returns an array with the top 20 channels from a streaming service.
     *
     *
     * @return array of top 20 channels data
     */
    public function getChannels();

        /**
     * Returns an array with the top video from a given channel.
     *
     * @param $channelID The channel id
     *
     *
     * @return array of top video data
     */
    public function getVideo($channelId);

        /**
     * Returns an array with the top 20 videos from a top channels.
     *
     *
     * @return array of top 20 videos data
     */
    public function getChannelsVideos();

}