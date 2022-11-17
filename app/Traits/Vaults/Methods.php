<?php

namespace App\Traits\Vaults;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Arr;

use function PHPUnit\Framework\returnCallback;

/**
* Vaults Methods model.
* Author: Geetanjali Sharma
*/

trait Methods
{
    public static function paginate($items, $perPage = 1, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    Public static function getVaultData($request){
        $limit = $request->limit;
             
        $myArray = array(
            array(
                'tvl' =>'tvl',
                'name'=>'first',
                'total_value'=>'4',
                'social_meter' =>1,
                'copiers' =>1,
                'verified' =>1,
                'roidollar' =>'23',
                'roicoin' =>'24',
                'dollar_percentage' =>'10',
                'coin_percentage' =>'10',
                'graph' =>array (
                    array(
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ),
                ),
            ),
            array(
                'tvl' =>'tvl',
                'name'=>'second',
                'total_value'=>'4',
                'social_meter' =>2,
                'copiers' => 1,
                'verified' =>0,
                'roidollar' =>'23',
                'roicoin' =>'24',
                'dollar_percentage' =>'10',
                'coin_percentage' =>'10',
                'graph' =>array (
                    array(
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ),
                ),
            ),
            array(
                'tvl' =>'tvl',
                'name'=>'third',
                'total_value'=>'4',
                'social_meter' =>3,
                'copiers' => 1,
                'verified' =>1,              
                'roidollar' =>'23',
                'roicoin' =>'24',
                'dollar_percentage' =>'10',
                'coin_percentage' =>'10',
                'graph' =>array (
                    array(
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ),
                ),
            ), 
            array(
                'tvl' =>'tvl',
                'name'=>'fourth',
                'total_value'=>'4',
                'social_meter' =>4,
                'copiers' => 0,
                'verified' =>1,             
                'roidollar' =>'23',
                'roicoin' =>'24',
                'dollar_percentage' =>'10',
                'coin_percentage' =>'10',
                'graph' =>array (
                    array(
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ),
                    array(
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ),
                ),
            )
        );
               
        $filteredArray = self::filterArray($myArray, ['verified' => (int)$request->verified, 'copiers' => (int)$request->copiers,'social_meter'=>(int)$request->social_meter]);
      
        $data = self::paginate($filteredArray,$limit);
        return $data;
       

    }
    public static function filterArray(array $products, array $filter = []): array
    {
        
        $result = [];
        $keyCount = count($filter);
        foreach ($products as $product) {
           
            $match = 0;
            foreach ($filter as $key => $value)
                
                if ($product[$key] === $value) $match++;
            
                
            if ($match === $keyCount) $result[] = $product;
        }
        
        return $result;
    }
    
  
}