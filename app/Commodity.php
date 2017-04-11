<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CommodityGroup;
use App\PriceBookCommodity;
class Commodity extends Model
{
    const ACTIVE_STATUS =0;
    const INACTIVE_STATUS = 1;

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'commodities';
    //protected $fillable = ['name','code','description','order_template','base_price','cost','cost','allows_sale','min_quantity','max_quantity','number','dvt','company_id','commodity_group_id','status','created_at'];
    protected $appends = ['price_quote'];

    public function getPriceQuoteAttribute()
    {
        return !empty($_GET['book']) ? PriceBookCommodity::getPriceBook($_GET['book'], $this->id) : $this->base_price;
    }

    public static $rules = array(
        //'code'               => 'unique:commodities',
        'name'               => 'required',
        'commodity_group_id' => 'required',
        'image'       => 'mimes:jpeg,jpg,png,gif|max:25000',
    );

    public static $message = [
        'required' => ":attribute không được trống.",
        'unique' => ":attribute đã tồn tại trong hệ thống, bạn phải nhập một :attribute khác.",
        'mimes' => "Định dạng file không hợp lệ (jpeg,jpg,png,gif).",
        'max' => "Dung lượng hình ảnh quá mức cho phép (<=2MB).",
    ];

    public static $attributeNames = [
        'name' => 'Tên hàng hóa',
        'image' => 'Hình ảnh',
        'commodity_group_id' => 'Nhóm hàng',
        'code' => 'Mã hàng hóa',
    ];

    public function getImage(){
        $root = \Request::root();
        if(!empty($this->image)){
            return "{$root}/uploads/commodities/{$this->company_id}/{$this->image}";
        }else{
            return "{$root}/assets/admin/img/no-avatar.png";
        }
    }

    public function category()
    {
        $category = $this->belongsTo('App\CommodityGroup', 'commodity_group_id');
        return $category;
    }

    public static function getProducts($params){
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        $query = Commodity::whereNull('commodities.deleted_at')
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

        return $query->orderBy('commodities.created_at', 'DESC')->paginate(10);
    }

    public function getPriceBook(){
        if(isset($this->base_book_price) && $this->base_book_price != null)
            return $this->base_book_price;
        return $this->base_price;
    }

    public function getOnHand()
    {
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;

        $branchCommodity = \App\BranchCommodity::where(['branch_id'=> $branch_id, 'commodity_id' => $this->id, 'company_id' => $this->company_id])->first();
        return ( $branchCommodity == null ) ? 0 : $branchCommodity->on_hand;
    }

    public function getCategoryNameFromArrCategories($categorienames){
        if(isset($categorienames[$this->commodity_group_id]))
            return $categorienames[$this->commodity_group_id];
        return 'Không có danh mục';
    }

    // public function getBasePriceAttribute($value) {
    //     return number_format($value);
    // }

    // public function getCostAttribute($value) {
    //     return number_format($value);
    // }

    public static function saveProducts($params,$product=null){
        if ($product == null) {
            $product = new self;
        }
        $image = [];
        if(isset($params['_token'])) unset($params['_token']);
        if(isset($params['formType'])) unset($params['formType']);
        if(isset($params['image'])) { $image =  $params['image']; unset($params['image']); }

        if(!isset($params['status'])) $params['status'] = self::ACTIVE_STATUS;
        if(!isset($params['allows_sale'])) $params['allows_sale'] = 0;

        if(empty($params['code'])) $params['code'] = 'autosystem';
        
        foreach ($params as $key => $value) {
            $product->$key = $value;
        }
        $product->last_price = $product->cost;

        \DB::beginTransaction();
        try {
            $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
            $product->save();

            //Process upload image for commodity.
            if(!empty($image)){
                $product->image = $product->uploadImage($image);
                $product->save();
            }

            if($params['code'] == 'autosystem'){
                $product->code = "MHH" . $product->id;
                $product->save();
            }

            $branch_commodity = \App\BranchCommodity::where(['branch_id'=> $branch_id, 'commodity_id' => $product->id, 'company_id' => $product->company_id])->first();
            
            if($branch_commodity == null)
                $branch_commodity = new \App\BranchCommodity;

            $branch_commodity->branch_id = $branch_id;
            $branch_commodity->commodity_id = $product->id;
            $branch_commodity->on_hand = $product->on_hand;
            $branch_commodity->company_id = $product->company_id;
            $branch_commodity->save();

            \DB::commit();
            return $product;
        } catch (\Exception $e) {
            \DB::rollback();
            return false;
        }
    }

    public static function importData($arrDatas,$company_id){
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        foreach ($arrDatas as $sheet) {

            \DB::beginTransaction();
            try {
                $product = self::where(['code'=>$sheet['ma_hang'], 'company_id' => $company_id])->first();
                if($product == null){
                    $product = new self;
                }
                
                $product->company_id = $company_id;
                $product->code = isset($sheet['ma_hang']) ?  trim($sheet['ma_hang']) : '';
                $product->name = isset($sheet['ten_hang_hoa']) ? trim($sheet['ten_hang_hoa']) : '';
                $product->base_price = isset($sheet['gia_ban']) ? (int) $sheet['gia_ban'] : 0;
                $product->cost = isset($sheet['gia_von']) ? (int) $sheet['gia_von'] : 0;
                $product->min_quantity = isset($sheet['ton_nho_nhat']) ? (int) $sheet['ton_nho_nhat'] : 0;
                $product->max_quantity = isset($sheet['ton_lon_nhat']) ? (int) $sheet['ton_lon_nhat'] : 0;
                $product->dvt = isset($sheet['dvt']) ? trim($sheet['dvt']) : '';
                $product->status = self::ACTIVE_STATUS;
                $product->deleted_at = null;

                if(isset($sheet['nhom_hang3_cap'])){
                    $arrGroup = explode('>>', $sheet['nhom_hang3_cap']);
                    $grouplevel1 = isset($arrGroup[0]) ? $arrGroup[0] : '';
                    $grouplevel2 = isset($arrGroup[1]) ? $arrGroup[1] : '';
                    $grouplevel3 = isset($arrGroup[2]) ? $arrGroup[2] : '';
                    if(!empty($grouplevel1)){
                        $group1 = CommodityGroup::where(['name' => $grouplevel1])->first();
                        if($group1 == null){
                            $group1 = new CommodityGroup;
                        }
                        $group1->name = $grouplevel1;
                        $group1->parent_id = 0;
                        $group1->status = CommodityGroup::ACTIVE;
                        $group1->company_id = $company_id;
                        $group1->save();
                        $product->commodity_group_id = $group1->id;
                    }
                    if(!empty($grouplevel2)){
                        $group2 = CommodityGroup::where(['name' => $grouplevel2])->first();
                        if($group2 == null){
                            $group2 = new CommodityGroup;
                        }
                        $group2->name = $grouplevel2;
                        $group2->parent_id = $group1->id;
                        $group2->status = CommodityGroup::ACTIVE;
                        $group2->company_id = $company_id;
                        $group2->save();
                        $product->commodity_group_id = $group2->id;
                    }
                    if(!empty($grouplevel3)){
                        $group3 = CommodityGroup::where(['name' => $grouplevel3])->first();
                        if($group3 == null){
                            $group3 = new CommodityGroup;
                        }
                        $group3->name = $grouplevel3;
                        $group3->parent_id = $group2->id;
                        $group3->status = CommodityGroup::ACTIVE;
                        $group3->company_id = $company_id;
                        $group3->save();
                        $product->commodity_group_id = $group3->id;
                    }
                }

                $product->save();

                $branch_commodity = \App\BranchCommodity::where(['branch_id'=> $branch_id, 'commodity_id' => $product->id, 'company_id' => $company_id])->first();
                if($branch_commodity == null)
                    $branch_commodity = new \App\BranchCommodity;

                $branch_commodity->branch_id = (int) $branch_id;
                $branch_commodity->commodity_id = (int) $product->id;
                $branch_commodity->on_hand = isset($sheet['ton_kho']) ? (int) $sheet['ton_kho'] : 0;
                $branch_commodity->company_id = $product->company_id;
                $branch_commodity->save();
                unset($product);
                unset($branch_commodity);
                unset($group1);
                unset($group2);
                unset($group3);
                unset($sheet);
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
            }
        }
        return true;
    }

    public function uploadImage($image){
        $extension = $image->getClientOriginalExtension();
        $path = $image->getRealPath();
        $filename = md5(uniqid()) . '.' . $extension;
        $uploadPath = public_path()."/uploads/commodities/{$this->company_id}";
        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0777, true)) {
                return false;
            }
        }
        $image->move($uploadPath, $filename);
        return $filename;
    }

    /*Get publish products*/
    public static function getPublishProducts() {
        return self::where('status', self::ACTIVE_STATUS)->whereNull('deleted_at')->get();
    }

    /*Get publish product*/
    public static function getPublishProductByID($id) {
        return self::where('status', self::ACTIVE_STATUS)->where('id', $id)
                ->whereNull('deleted_at')->first();
    }

    /*Get publish products by branch*/
    public static function getPublishProductsByBranch($branch_id) {
        $commodities = self::select('commodities.*')->where('status', self::ACTIVE_STATUS)->where('allows_sale',1)
                        ->where('allows_sale','>',0)
                        ->whereNull('commodities.deleted_at')
                        ->rightjoin('branch_commodities', function($join) use ($branch_id)
                        {
                            $join->on('branch_commodities.commodity_id', '=', 'commodities.id')
                            ->where('branch_commodities.branch_id', '=', $branch_id)
                            ->whereNull('branch_commodities.deleted_at');
                        })->get();

        return $commodities;
    }
}
