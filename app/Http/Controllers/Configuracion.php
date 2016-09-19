<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Configuracion_m;
use Auth;
class Configuracion extends Controller{
	
    function getConfig(Request $request){
    	$configuracion=Configuracion_m::getConfig();
    	return json_encode($configuracion);
    }
    function saveConfiguracion(Request $request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        unset($_POST['_token']);
        if(isset($_POST)){
            $configuracion=Configuracion_m::saveConfiguracion($_POST);
            return json_encode($configuracion);
        }
        
    }
    function updateConfiguracion(Request $request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        unset($_POST['_token']);
        if(isset($_POST)){
            $configuracion=Configuracion_m::updateConfiguracion($_POST);
            return json_encode($configuracion);
        }
    }

}