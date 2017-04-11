<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceBook extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'price_books';
    //use SoftDeletes;
    CONST ACTIVE = 1;
    CONST UNACTIVE = 0;

    public static $rules = array(
        'name'               => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
    );

    public static $message = [
        'required' => ":attribute không được trống.",
        'unique' => ":attribute đã tồn tại trong hệ thống, bạn phải nhập một :attribute khác.",
    ];

    public static $attributeNames = [
        'name' => 'Tên bảng giá',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc'
    ];

    /*
    * This is function get all groups is active
    */
    public static function getAll() {
        return self::where('company_id', \Auth::user()->company_id )->get();
    }

    public static function getForSale() {
        $date = date('Y-m-d H:i:s');
        //die($date);
    	return self::where('company_id', \Auth::user()->company_id)->where('start_date','<=',$date)->where('end_date','>=',$date)->where('status',1)->get();
    }

    public static function savePriceBook($params,$pricebook=null){
        if ($pricebook == null) {
            $pricebook = new self;
        }
        if(isset($params['_token'])) unset($params['_token']);
        if(!isset($params['status'])) $params['status'] = self::ACTIVE_STATUS;

        foreach ($params as $key => $value) {
            $pricebook->$key = $value;
        }
        return $pricebook->save() ? $pricebook : false;
    }

    public static function getProducts($params,$paginate=true){
        $book = $params::get('book');
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        if($book == '' || $book == null){
            $query = \App\Commodity::whereNull('commodities.deleted_at')
                ->select('commodities.*')
                ->leftJoin('commodity_groups', 'commodities.commodity_group_id', '=', 'commodity_groups.id')
                ->leftJoin('branch_commodities', function($join) use ($branch_id){
                    $join->on('commodities.id', '=', 'branch_commodities.commodity_id');
                    $join->where('branch_commodities.branch_id', '=', $branch_id);
                })
                ->where(['commodities.company_id'=> \Auth::user()->company_id]);

                if($params->get('code') != null){
                    $query->where(function ($query) use ($params) {
                        $query->orWhere('commodities.code', 'like', "{$params::get('code')}%")
                              ->orWhere('commodities.name', 'like', "{$params::get('code')}%");
                    });
                }

                if($params->get('commodity_group') != null){
                    $commodity_group_ids = \App\CommodityGroup::getChildIDs($params->get('commodity_group'));
                    $query->whereIn('commodities.commodity_group_id',$commodity_group_ids);
                }

                if($params->get('on_hand') != null){
                    switch ($params->get('on_hand')) {
                        case 1:
                            $query->where('branch_commodities.on_hand','<',\DB::raw('`commodities`.`min_quantity`'));
                            break;
                        case 2:
                            $query->where('branch_commodities.on_hand','>',\DB::raw('`commodities`.`max_quantity`'));
                            break;
                        case 3:
                            $query->where('branch_commodities.on_hand','>', 0 );
                            break;

                        default:
                            break;
                    }
                }

                if($params->get('active_status') != null){
                    if($params->get('active_status') == 1){
                        $query->where('commodities.status',self::INACTIVE_STATUS);
                    }else{
                        $query->where('commodities.status',self::ACTIVE_STATUS);
                    }
                }
            if($paginate)
                return $query->orderBy('commodities.created_at', 'DESC')->paginate(10);
            return $query->orderBy('commodities.created_at', 'DESC')->get();
        }else{
            $query = \App\Commodity::whereNull('commodities.deleted_at')
                ->select('commodities.*','price_book_commodities.base_book_price')
                ->leftJoin('commodity_groups', 'commodities.commodity_group_id', '=', 'commodity_groups.id')
                ->leftJoin('branch_commodities', function($join) use ($branch_id){
                    $join->on('commodities.id', '=', 'branch_commodities.commodity_id');
                    $join->where('branch_commodities.branch_id', '=', $branch_id);
                })
                ->rightJoin('price_book_commodities', 'commodities.id', '=', 'price_book_commodities.commodity_id')
                ->where(['price_book_commodities.price_book_id'=> $params::get('book')])
                ->where(['commodities.company_id'=> \Auth::user()->company_id]);

                if($params->get('code') != null){
                    $query->where(function ($query) use ($params) {
                        $query->orWhere('commodities.code', 'like', "{$params::get('code')}%")
                              ->orWhere('commodities.name', 'like', "{$params::get('code')}%");
                    });
                }

                if($params->get('commodity_group') != null){
                    $commodity_group_ids = \App\CommodityGroup::getChildIDs($params->get('commodity_group'));
                    $query->whereIn('commodities.commodity_group_id',$commodity_group_ids);
                }

                if($params->get('on_hand') != null){
                    switch ($params->get('on_hand')) {
                        case 1:
                            $query->where('branch_commodities.on_hand','<',\DB::raw('`commodities`.`min_quantity`'));
                            break;
                        case 2:
                            $query->where('branch_commodities.on_hand','>',\DB::raw('`commodities`.`max_quantity`'));
                            break;
                        case 3:
                            $query->where('branch_commodities.on_hand','>', 0 );
                            break;

                        default:
                            break;
                    }
                }

                if($params->get('active_status') != null){
                    if($params->get('active_status') == 1){
                        $query->where('commodities.status',self::INACTIVE_STATUS);
                    }else{
                        $query->where('commodities.status',self::ACTIVE_STATUS);
                    }
                }
            if($paginate)
                return $query->orderBy('commodities.created_at', 'DESC')->paginate(10);
            return $query->orderBy('commodities.created_at', 'DESC')->get();
        }
    }
}
