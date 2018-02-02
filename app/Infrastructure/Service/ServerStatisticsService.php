<?php

namespace App\Infrastructure\Service;
use App\Domain\ServerStatisticServiceInterface;
use App\Infrastructure\YoutubeBundle\service\YoutubeStatisticsService;
use App\Infrastructure\TwitchBundle\service\TwitchStatisticsService;
use App\Infrastructure\VimeoBundle\service\VimeoStatisticsService;

class ServerStatisticsService implements ServerStatisticServiceInterface
{

    private $YoutubeStatisticsService;
    private $TwitchStatisticsService;
    private $VimeoStatisticsService;

    public function __construct(
        YoutubeStatisticsService $YoutubeStatisticsService,
        TwitchStatisticsService $TwitchStatisticsService,
        VimeoStatisticsService $VimeoStatisticsService

    ) {
        $this->YoutubeStatisticsService = $YoutubeStatisticsService;
        $this->TwitchStatisticsService = $TwitchStatisticsService;
        $this->VimeoStatisticsService = $VimeoStatisticsService;
    }

    public function serverStatisticsGenerator()
    {
       $this->YoutubeStatisticsService->save();
       $this->TwitchStatisticsService->save();
       $this->VimeoStatisticsService->save();
    }
}
