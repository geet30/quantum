<?php

namespace App\Traits\Vaults;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Arr;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use Exception;

use function PHPUnit\Framework\returnCallback;

/**
* Vaults Methods model.
* Author: Geetanjali Sharma
* Company: Crebos Nederland B.V.
*/

trait Methods
{
    
     /**
     * Get Vault Listing.
     * Author: Geetanjali Sharma
     * Company: Crebos Nederland B.V.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    Public static function getVaultData($request){
        $limit = $request->limit;
        $myArray =[];
        $myArray = self::getVaultElements($request->verified);
    
        $filteredArray = $myArray;
        
        if(isset($request->verified) && $request->verified==1){
            
            $filteredArray = self::filterArray($myArray, ['verified' => (int)$request->verified]);
        } 
        if(isset($request->copiers_start) && $request->copiers_start!='' && isset($request->copiers_end) && $request->copiers_end!=''){
           
           $filteredArray = self::filterArray($myArray, ['copiers_start' => (int)$request->copiers_start,'copiers_end' => (int)$request->copiers_end]);
        } 
        if(isset($request->social_meter) && $request->social_meter!=''){
            
            $filteredArray = self::filterArray($myArray, ['social_meter' => (int)$request->social_meter]);
        } 
       
        
        $page = $request->page;
        $data = self::paginate($filteredArray,$limit,$page);
        return $data;
       

    }
    /**
     * Get Vault Listing Elements.
     * Author: Geetanjali Sharma
     * Company: Crebos Nederland B.V.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getVaultElements($verified=0){
        $arr_info = [];
        
        for($i=1;$i<50;$i++){
            $period = CarbonPeriod::create(date('Y-m-d', strtotime("-7 Days")), date('Y-m-d'));
            $graph_info =[];
            foreach($period as $date){
                    
                $graph_info[] = [
                    'x' => rand(0, 100),
                    'Y' => $date->format('Y-m-d'),
                ];
            }  

            if($verified != 0){
                $verified =1;
            }
            $arr_info[] = [ 
                'id'=>$i,
                'tvl' =>rand(0, 1000),
                'icon' =>url('images/icon.png'),
                'vault_name'=>'napfton',
                'name'=>'napfton',
                'total_value'=>rand(0, 100),
                'social_meter' =>rand(0, 3),
                'copiers' => rand(0, 12000),
                'verified' =>(int)$verified,
                'roidollar' =>rand(0, 100),
                'roicoin' =>rand(0, 100),
                'dollar_percentage' =>rand(0, 100),
                'coin_percentage' =>rand(0, 100),
                'graph' => $graph_info
            ];  
                  
            
        }
       
        return $arr_info;
    }

     /**
     * Get Vault Detail Graph.
     * Author: Geetanjali Sharma
     * Company: Crebos Nederland B.V.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    Public static function getVaultGraph($request){
        try{         
            $myArray =[];
            $name = 'napfton';
            $intervalDuration= '';
            $durationType='all';
            $valueStart = '2000-01-01';
           
           
            if(isset($request->time_difference) && $request->time_difference !='all' && $request->time_difference 
            !='ytd'){
                $explode = preg_split('#(?<=\d)(?=[a-z])#i', $request->time_difference);
                $intervalDuration =$explode[0];
                $durationType = $explode[1];
            }
            if(isset($request->time_difference) && $request->time_difference =='ytd'){
                $durationType='ytd';
            }
            $myArray = self::getVaultGraphElement($request,$name,$intervalDuration,$durationType,$valueStart);
            $filteredArray = $myArray;
            
            return $filteredArray;
        }catch(Exception $ex){
            dd($ex);
        }
       
    }

     /**
     * Get Vault Detail Graph Elemnents.
     * Author: Geetanjali Sharma
     * Company: Crebos Nederland B.V.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getVaultGraphElement($request, $name, $intervalDuration, $durationType, $valueStart) {
        $id = $request->id;
       
        try{
            $durationTypeString =$duration= '';
            switch($durationType) {
                case 'h':
                    $durationTypeString = 'hours';
                    $duration = 24;
                    break;
                case 'd':
                    $durationTypeString = 'days';
                    $duration = 7;
                    break;
                case 'm':
                    $durationTypeString = 'months';
                    // $duration = 12;
                    break;
                case 'yr':
                    $durationTypeString = 'year';
                    break;
                case 'ytd':
                    $durationTypeString = 'ytd';
                    break;
                case 'all':
                    $durationTypeString = 'all';
                    break;
            }
            $dateRange = false;
            if(isset($request->date_range_start) && $request->date_range_start !='' && isset($request->date_range_end) && $request->date_range_end 
            !=''){
                    $dateRange = true;
                    $period = CarbonPeriod::create($request->date_range_start, $request->date_range_end );
                    
            }
            else if($durationTypeString == 'months') {
               $period = CarbonPeriod::create(date('Y-m-d', strtotime("-$intervalDuration $durationTypeString")), date('Y-m-d'));
            }
            else if($durationTypeString == 'days') {
                $valueStart = date('Y-m-d', strtotime("-7 days"));
                $period = CarbonPeriod::create($valueStart, date('Y-m-d'));
            }
            else if($durationTypeString == 'ytd') {
                $period = CarbonPeriod::create(date('Y') . '-01-01', date('Y-m-d'));
            }
            else if($durationTypeString == 'hours') {
              
                $period = CarbonPeriod::create(Carbon::now()->startOfDay(), Carbon::now()->endOfDay());
            }
            else if($durationTypeString == 'year') {
                $period = CarbonPeriod::create($valueStart, date('Y-m-d'));
            }
            else {
                $period = CarbonPeriod::create(date('Y-m-d', strtotime("-30 days")), date('Y-m-d'));
            }
                  
            $returnData = [
                'id'=>$id,
                'vault_name'=>$name,
                'time_difference' => $intervalDuration . $durationType,
                'icon' =>url('images/icon.png'),
                'graph_data' => [],
            ];

            $newDate = false;
            foreach ($period as $date) {
                if(!$newDate || (is_object($newDate) && $date->timestamp >= $newDate->timestamp)) {
                    switch($durationType) {
                        case 'h':
                            $newDate = $date->addHours($intervalDuration);
                            break;
                        case 'yr':
                            $newDate = $date->addYears($intervalDuration);
                            break;
                        case 'all':
                            $newDate = $date->addYears($intervalDuration);
                            break;
                    }
                     
                    if($dateRange == false && $durationTypeString == 'hours' && $duration==24){
                        for($i=1;$i<$duration;$i++){
                            $returnData['graph_data'][] = [
                                'x' => rand(0, 100),
                                'y' => $date->addHour()->format('H:i:a'),
                                
                            ];
                        }
                    }else{
                        $returnData['graph_data'][] = [
                            'x' => rand(0, 100),
                            'y' => $date->format('Y-m-d'),
                        ];
                    }
                }
            }
          

            return $returnData;
        }
        catch(Exception $ex){
            dd($ex);
        }
    }
    /**
     * Get Vault Detail Assets.
     * Author: Geetanjali Sharma
     * Company: Crebos Nederland B.V.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */ 

    Public static function getVaultAssets($request){
        $asset_info = [];
        for($i=1;$i<6;$i++){
            $asset_info[] = 
                [
                    'id'=>$i,
                    'assets_under_management'=>rand(0,1000),
                    'average_monthly_return' =>'2.56',
                    'denomination_asset'=>'Binance pegged USDT',
                    'management_fee' =>'1',     
                    'amount_of_depositors' =>rand(0,100),
                    'in_profit'=>rand(0,1),
                    'profit_loss'=>rand(0,100),
                    'min_deposit_amount' =>rand(0,100), 
                    'management_fee' =>rand(0,100),   
                    'performance_fee' =>rand(0,100),             
                 
                ];            
            
        }

        $filteredArray = self::filterArray($asset_info, ['id'=>(int)$request->id]);
        return $filteredArray;


    }

    /**
     * Get Vault Detail Transaction.
     * Author: Geetanjali Sharma
     * Company: Crebos Nederland B.V.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    Public static function getVaultTransaction($request){
       
        $transaction_info = [];
        for($i=1;$i<20;$i++){
            $transaction_info[] = 
                [
                    'id'=>$request->id,
                    'transaction_date'=>'3 days ago',
                    'exchange' =>'Buyer234',
                    'trade_type'=>'SELL',
                    'purchase_price' =>rand(0,1000).' USDT/ETH',        
                    'trade_coin' =>rand(0,10000), 
                    'trade_dollar' =>rand(0,1000), 
                    'second_trade_coin' =>rand(0,10000), 
                    'second_trade_dollar' =>rand(0,1000),
                    'txhash' =>'0gdashgdhasgd3487587',  
                    'etherum_icon' =>url('images/etherum.png'),
                    'usst_icon' =>url('images/usst.png'),            
                 
                ];            
            
        }
        $limit = $request->limit;
        // $filteredArray = self::filterArray($transaction_info, ['id'=>(int)$request->id]);
        $filteredArray = $transaction_info;
      
       
        $page = $request->page;
        $data = self::paginate($filteredArray,$limit,$page);
        return $data;



    }

    /**
     * Filter Array
     * Author: Geetanjali Sharma
     * Company: Crebos Nederland B.V.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function filterArray(array $products, array $filter = []): array
    {
        
        try{
            $result = [];
            $keyCount = count($filter);
            foreach ($products as $product) {
                
            
                $match = 0;
                foreach ($filter as $key => $value){
                    if(isset($filter['copiers_start']) && !empty($filter['copiers_start'])){
                        if(($product['copiers'] >= $filter['copiers_start']) && ($product['copiers'] <= $filter['copiers_end']))
                            $match++;
                        
                    }else{
                        if ($product[$key] === $value) $match++;
                    }
                
                    
                }
                    
                    
                
                    
                if ($match === $keyCount) $result[] = $product;
            }
            
            return $result;
        }catch (\Exception $ex) {
            dd($ex);
        }
    }
    /** Paginate Array
     * Author: Geetanjali Sharma
     * Company: Crebos Nederland B.V.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */   
    public static function paginate($items, $per_page = 1, $page = null, $options = [])
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($items);
        $currentPageResults =$collection->slice(($currentPage - 1) *$per_page, $per_page)->values();
        return  new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
       
    }
    
}