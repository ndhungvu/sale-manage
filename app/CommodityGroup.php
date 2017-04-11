<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommodityGroup extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'commodity_groups';
    protected $dates = ['deleted_at'];
    //use SoftDeletes;
    CONST ACTIVE = 1;
    CONST UNACTIVE = 0;

    public function parent()
    {
        return $this->belongsTo('App\CommodityGroup', 'parent_id');
    }

    public function childs()
    {
        return $this-> hasMany('App\CommodityGroup', 'parent_id');
    }

    /*
    * This is function get all is active
    */
    public static function getAll() {
    	return CommodityGroup::whereNull('deleted_at')->get();
    }

    public static function getCommodityGroupByID($id) {
        return CommodityGroup::where('id', $id)->whereNull('deleted_at')->first();
    }

    public static function getChildIDs($commodity_group_id){
        $ids = [(int) $commodity_group_id];
        $datas = self::select('id')->where(['company_id' => \Auth::user()->company_id, 'parent_id' => $commodity_group_id])->get()->toArray();
        if(!empty($datas)){
            foreach ($datas as $key => $data) {
                array_push($ids,$data['id']);
                $data2s = self::select('id')->where(['company_id' => \Auth::user()->company_id, 'parent_id' => $data['id']])->get()->toArray();
                if(!empty($data2s)){
                    foreach ($data2s as $key => $data2) {
                        array_push($ids,$data2['id']);
                    }
                }
            }
        }
        return $ids;
    }

    public static function getCategoryByCompany($companyId,$list=false){
    	$dataLevelOne = $dataLevelTwo = $common = [];
    	$datas = self::where(['company_id' => $companyId])->orderBy('name', 'desc')->get()->toArray();
    	if($datas != null){
    		foreach ($datas as $data) {
    			if($data['parent_id'] == 0){
    				$data['level'] = 1;
    				$data['showName'] = $data['name'];
    				$dataLevelOne[$data['id']] = $data;
                    $common[$data['id']] = $data['name'];
    			}
    		}

    		foreach ($datas as $data) {
    			if(isset($dataLevelOne[$data['parent_id']])){
    				$data['level'] = 2;
    				$data['showName'] = $dataLevelOne[$data['parent_id']]['name'] . ' > ' . $data['name'];
    				$dataLevelOne[$data['parent_id']]['childs'][$data['id']] = $data;
    				$dataLevelTwo[$data['id']] = $data['parent_id'];
                    $common[$data['id']] = $data['showName'];
    			}
    		}

    		foreach ($datas as $data) {
    			if(isset($dataLevelTwo[$data['parent_id']])){
    				$data['level'] = 3;
    				$data['showName'] = $dataLevelOne[$dataLevelTwo[$data['parent_id']]]['name'] . ' > ' . $dataLevelOne[$dataLevelTwo[$data['parent_id']]]['childs'][$data['parent_id']]['name'] . ' > ' . $data['name'];
    				$dataLevelOne[$dataLevelTwo[$data['parent_id']]]['childs'][$data['parent_id']]['childs'][$data['id']] = $data;
                    $common[$data['id']] = $data['showName'];
    			}
    		}
    	}
        if($list==true) return $common;
    	return $dataLevelOne;
    }
}
