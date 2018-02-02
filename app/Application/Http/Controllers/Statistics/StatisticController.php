<?php

namespace App\Application\Http\Controllers\Statistics;

use App\Application\Http\Controllers\AbstractController;
use App\Domain\StatisticServiceInterface;


class StatisticController extends AbstractController
{
	 /**
     * @var StatisticServiceInterface
     */
    private $StatisticService;
    /**
     * @param StatisticServiceInterface $ StatisticServiceInterface
     */
    public function __construct(StatisticServiceInterface $StatisticServiceInterface)
    {
        $this->StatisticService = $StatisticServiceInterface;
    }


    public function index()
    {

      $data = $this->StatisticService->getStatistics();

      if($data->count())
      {     
       return response()->json(['status'=>true,'message'=>'Data sent successfully','data'=>$data]);
      }

       return response()->json(['status'=>false,'message'=>'No data found'],404);  
    }


    public function export()
    {

      $data= $this->StatisticService->getStatisticsCSV();

      if(!$data)
        {
         return response()->json(['status'=>false,'message'=>'No data found'],404);  
        }
      return $data;
    }


    public function statisticView()
    {

          $statistics= $this->StatisticService->getStatisticsView();
          $names=array_values(array_unique($statistics->names));
          $valuesT=$statistics->valuesT;
          $valuesY=$statistics->valuesY;
          $valuesV=$statistics->valuesV;

          return view('statistics',compact('valuesV','valuesT','valuesY','names'));
    }

}