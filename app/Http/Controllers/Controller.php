<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function getErrorMessage($messages){
    	$errors = $messages->all();
    	$message = '';
    	foreach ($errors as $key => $value) {
    		$index = $key + 1;
    		$message = $message .  "{$index}: {$value} <br />";
    	}
    	return rtrim($message,'<br />');
    }
}
