<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ventas_m;
use Auth;
class Ventas extends Controller{
	
    function getventas(Request $request){
    	$articuloss=Ventas_m::getventas($_POST);
    	return json_encode($articuloss);
    }
    function getFolio(Request $request){
        $articuloss=Ventas_m::getFolio($_POST);
        return json_encode($articuloss);
    }

}