<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ManagerController extends Controller
{
    public function __construct(){
        $user = Auth::user();        
        
    	$companyBranches = \App\Branch::whereNull('branches.deleted_at')->where(['branches.company_id'=> $user->company_id, 'branches.status'=>\App\Branch::ACTIVE])->get()->keyBy('id')->toArray();
        session(['company_branches' => $companyBranches]);
        if(is_null(session('current_branch'))){
			if(!empty($companyBranches)){
                if($user->role_id == 3){
                    session(['current_branch' => $user->branch_id]);
                }else{
                    $companyBranch = reset($companyBranches);
                    session(['current_branch' => $companyBranch['id']]);
                }
			}else{
			    session(['current_branch' => 0]);
			}
    	}
    }
}
