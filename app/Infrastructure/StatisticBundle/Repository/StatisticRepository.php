<?php

namespace App\Infrastructure\StatisticBundle\Repository;

use App\Infrastructure\Exception\DataNotFoundException;
use App\Domain\StatisticInterface;
use App\Domain\Model\statistic;
use Excel;
use \Exception;


/**
 * Class StatisticRepository is a concrete implementation of StatisticInterface.
 *
 * @package App\Infrastructure\StatisticBundle\Repository
 */
class StatisticRepository implements StatisticInterface
{

    /**
     * @var statistic
     */
    protected $statistic;
    /**
     * @param statistic $statistic
     */
    public function __construct(statistic $statistic)
    {
        $this->statistic = $statistic;
    }

    /**
     * @inheritdoc
     */


    public function getStatistics()
    {

        return $this->statistic->all();

    }

    public function getStatisticsView()
    {
        $statisticsData=$this->statistic->where('statistic','Average')->get();
        if(!$statisticsData->count()) throw new DataNotFoundException();
        $resultObject=new \stdclass();
        foreach($statisticsData as $key=>$data )
         {
                switch ($data->service) {
                          case "Youtube":
                              $resultObject->valuesY[$data->name.'_'.$data->type]=$data->value;
                              break;
                          case "Twitch":
                              $resultObject->valuesT[$data->name.'_'.$data->type]=$data->value;
                              break;
                          case "Vimeo":
                              $resultObject->valuesV[$data->name.'_'.$data->type]=$data->value;
                              break;
                  }
                $resultObject->names[$key]=$data->name.'_'.$data->type;
         }
         return $resultObject;
      
    }


     public function getStatisticsCSV()
    {

        $statistics=$this->statistic->orderBy('service')->get();

        if(!$statistics->count())
           {
            return null;
           } 
        return Excel::create('statistics', function($excel) use($statistics) {
                    $excel->sheet('Sheet 1', function($sheet) use($statistics) {
                        $sheet->fromArray($statistics);
                    });
               })->export('csv');

    }
       


     public function create($data)
    {
        foreach($data as $statistic)
             {
                $this->statistic->updateOrCreate(['service'=>$statistic['service'],'name'=>$statistic['name'],'type'=>$statistic['type']],$statistic);
             }
        return  true ;
    }
}
