<?php

namespace App\Domain\Factory;
use App\Domain\Model\statistic;
/**
 * Class StatisticFactory encapsulates all the business logic need to create a Statistic.
 *
 * @package CoreDomain
 */
class StatisticFactory
{

    public static function createStatisticsFromArrayObjects($objectArray)
    {
        $result = [];
        foreach($objectArray as $object) {
           $result[] = StatisticFactory::createStatistic($object->name,$object->value, $object->statistic, $object->type, $object->service);
        }
        return $result;
    }

    /**
     * Creates a new Model\Statistic instance given a set of values.
     *
     * @param $id
     * @param $text
     * @param $created_at
     * @return Tweet
     */
    public static function createStatistic($name, $value, $statistic, $type, $service)
    {
        return new statistic($name,$value, $statistic, $type, $service);
    }
}