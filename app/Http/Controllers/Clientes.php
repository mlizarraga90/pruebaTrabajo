<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Clientes_m;
use Auth;
class Clientes extends Controller{
	
    function getclientes(Request $request){
    	$clientes=Clientes_m::getClientes($_POST);
    	return json_encode($clientes);
    }
    function saveCliente(Request $request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        if(isset($_POST)){
            unset($_POST['_token']);
            unset($_POST['id']);
            $clientes=Clientes_m::saveCliente($_POST);
            return json_encode($clientes);
        }
    }
    function deleteCliente(Request $request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        if(isset($_POST)){
            unset($_POST['_token']);
            $clientes=Clientes_m::deleteCliente($_POST['idcliente']);
            return json_encode($clientes);
        }
    }
    function updateCliente(Request $request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        if(isset($_POST)){
            unset($_POST['_token']);
            $clientes=Clientes_m::updateCliente($_POST);
            return json_encode($clientes);
        }
    }
    function getClave(){
         $clientes=Clientes_m::getClave();
        return json_encode($clientes);
    }

}