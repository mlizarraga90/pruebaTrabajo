<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Articulos_m;
use Auth;
class Articulos extends Controller{
	
    function getarticulos(Request $request){
    	$articuloss=Articulos_m::getarticulos($_POST);
    	return json_encode($articuloss);
    }
    function savearticulos(Request $request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        if(isset($_POST)){
            unset($_POST['_token']);
            unset($_POST['id']);
            $articuloss=Articulos_m::savearticulos($_POST);
            return json_encode($articuloss);
        }
    }
    function deletearticulos(Request $request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        if(isset($_POST)){
            unset($_POST['_token']);
            $articuloss=Articulos_m::deletearticulos($_POST['idarticulo']);
            return json_encode($articuloss);
        }
    }
    function updatearticulos(Request $request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        if(isset($_POST)){
            unset($_POST['_token']);
            $articuloss=Articulos_m::updatearticulos($_POST);
            return json_encode($articuloss);
        }
    }

}