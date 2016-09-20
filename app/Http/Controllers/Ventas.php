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
    function addVenta(Request $request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        if(isset($_POST)){
            unset($_POST['_token']);
            $ventas=Ventas_m::addVenta($_POST);
            return json_encode($ventas);
        }
    }
}