<?php

namespace App\Traits\Vaults;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Arr;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

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
        if(isset($request->copiersStart) && $request->copiersStart!='' && isset($request->copiersEnd) && $request->copiersEnd!=''){
           
           $filteredArray = self::filterArray($myArray, ['copiersStart' => (int)$request->copiersStart,'copiersEnd' => (int)$request->copiersEnd]);
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
                // 'copiersStart' =>rand(0, 12000),
                // 'copiersEnd' => rand(0,12000),
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
                   
        $myArray = array(
            [
                'id'=>1,
                'vault_name'=>'napfton',
                'time_difference' =>'7D',
                'icon' =>url('images/icon.png'),              
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2021-01-02'
                    ],
                    [
                        "x"=>90,
                        "y"=>'2021-01-03'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2021-01-04'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2021-01-05'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2021-01-06'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2021-01-07'
                    ],
                ],
            ],
            [
                'id'=>1,
                'vault_name'=>'napfton',
                'time_difference' =>'1M',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                ],
            ],
            [
                'id'=>1,
                'vault_name'=>'napfton',
                'time_difference' =>'3M',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                ],
            ], 
            [
                'id'=>1,
                'vault_name'=>'napfton',
                'time_difference' =>'6M',
                'icon' =>url('images/icon.png'),
                'graph' => [
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                ],
            ],
           
            [
                'id'=>1,
                'vault_name'=>'napfton',
                'time_difference' =>'1yr',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                ],
            ],
            [
                'id'=>1,
                'vault_name'=>'napfton',
                'time_difference' =>'ytd',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2022-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-02-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2022-03-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2022-04-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2022-05-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2022-06-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2022-07-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-08-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2022-09-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2022-10-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2022-11-01'
                    ],
                    
                ]
            ],
            [
                'id'=>1,
                'vault_name'=>'napfton',
                'time_difference' =>'all',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2019-06-06'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2020-01-06'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2021-01-06'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2022-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-06-01'
                    ],
                   
                    
                ],
            ],
            //second record
            [
                'id'=>2,
                'vault_name'=>'napfton',
                'time_difference' =>'7D',
                'icon' =>url('images/icon.png'),              
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2021-01-02'
                    ],
                    [
                        "x"=>90,
                        "y"=>'2021-01-03'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2021-01-04'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2021-01-05'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2021-01-06'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2021-01-07'
                    ],
                ]
            ],
            [
                'id'=>2,
                'vault_name'=>'napfton',
                'time_difference' =>'1M',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                ]
            ],
            [
                'id'=>2,
                'vault_name'=>'napfton',
                'time_difference' =>'3M',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                ],
            ], 
            [
                'id'=>2,
                'vault_name'=>'napfton',
                'time_difference' =>'6M',
                'icon' =>url('images/icon.png'),
                'graph' => [
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                ],
            ],         
            [
                'id'=>2,
                'vault_name'=>'napfton',
                'time_difference' =>'1yr',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                ],
            ],
            [
                'id'=>2,
                'vault_name'=>'napfton',
                'time_difference' =>'ytd',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2022-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-02-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2022-03-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2022-04-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2022-05-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2022-06-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2022-07-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-08-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2022-09-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2022-10-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2022-11-01'
                    ],
                    
                ]
            ],
            [
                'id'=>2,
                'vault_name'=>'napfton',
                'time_difference' =>'all',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2019-06-06'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2020-01-06'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2021-01-06'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2022-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-06-01'
                    ],
                   
                    
                ],
            ],
            //third record
            [
                'id'=>3,
                'vault_name'=>'napfton',
                'time_difference' =>'7D',
                'icon' =>url('images/icon.png'),              
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2021-01-02'
                    ],
                    [
                        "x"=>90,
                        "y"=>'2021-01-03'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2021-01-04'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2021-01-05'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2021-01-06'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2021-01-07'
                    ],
                ]
            ],
            [
                'id'=>3,
                'vault_name'=>'napfton',
                'time_difference' =>'1M',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                ]
            ],
            [
                'id'=>3,
                'vault_name'=>'napfton',
                'time_difference' =>'3M',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                ],
            ], 
            [
                'id'=>3,
                'vault_name'=>'napfton',
                'time_difference' =>'6M',
                'icon' =>url('images/icon.png'),
                'graph' => [
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                ],
            ],         
            [
                'id'=>3,
                'vault_name'=>'napfton',
                'time_difference' =>'1yr',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                ],
            ],
            [
                'id'=>3,
                'vault_name'=>'napfton',
                'time_difference' =>'ytd',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2022-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-02-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2022-03-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2022-04-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2022-05-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2022-06-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2022-07-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-08-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2022-09-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2022-10-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2022-11-01'
                    ],
                    
                ]
            ],
            [
                'id'=>3,
                'vault_name'=>'napfton',
                'time_difference' =>'all',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2019-06-06'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2020-01-06'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2021-01-06'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2022-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-06-01'
                    ],
                   
                    
                ],
            ],
            //Fourth Record
            [
                'id'=>4,
                'vault_name'=>'napfton',
                'time_difference' =>'7D',
                'icon' =>url('images/icon.png'),              
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2021-01-02'
                    ],
                    [
                        "x"=>90,
                        "y"=>'2021-01-03'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2021-01-04'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2021-01-05'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2021-01-06'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2021-01-07'
                    ],
                ]
            ],
            [
                'id'=>4,
                'vault_name'=>'napfton',
                'time_difference' =>'1M',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                ]
            ],
            [
                'id'=>4,
                'vault_name'=>'napfton',
                'time_difference' =>'3M',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                ],
            ], 
            [
                'id'=>4,
                'vault_name'=>'napfton',
                'time_difference' =>'6M',
                'icon' =>url('images/icon.png'),
                'graph' => [
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                ],
            ],         
            [
                'id'=>4,
                'vault_name'=>'napfton',
                'time_difference' =>'1yr',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2015-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2016-01-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2017-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2018-01-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2021-01-01'
                    ],
                ],
            ],
            [
                'id'=>4,
                'vault_name'=>'napfton',
                'time_difference' =>'ytd',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2022-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-02-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2022-03-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2022-04-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2022-05-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2022-06-01'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2022-07-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-08-01'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2022-09-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2022-10-01'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2022-11-01'
                    ],
                    
                ]
            ],
            [
                'id'=>4,
                'vault_name'=>'napfton',
                'time_difference' =>'all',
                'icon' =>url('images/icon.png'),
                'graph' =>[
                    [
                        "x"=>10,
                        "y"=>'2019-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2019-06-06'
                    ],
                    [
                        "x"=>30,
                        "y"=>'2020-01-01'
                    ],
                    [
                        "x"=>40,
                        "y"=>'2020-01-06'
                    ],
                    [
                        "x"=>50,
                        "y"=>'2021-01-01'
                    ],
                    [
                        "x"=>60,
                        "y"=>'2021-01-06'
                    ],
                    [
                        "x"=>70,
                        "y"=>'2022-01-01'
                    ],
                    [
                        "x"=>20,
                        "y"=>'2022-06-01'
                    ],
                   
                    
                ],
            ],
        );
               
        $filteredArray = self::filterArray($myArray, ['id'=>(int)$request->id,'time_difference' => $request->time_difference]);
        return $filteredArray;
       
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
                    'purchase_price' =>rand(0,1000),        
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
                    if(isset($filter['copiersStart']) && !empty($filter['copiersStart'])){
                        if(($product['copiers'] >= $filter['copiersStart']) && ($product['copiers'] <= $filter['copiersEnd']))
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