<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
USE Auth;

class Clientes_m extends Model{
    public static function  getclientes($where){
        unset($where['_token']);
        $clientes= DB::select(self::where($where));
        return self::filldata($clientes);
    }
    public static function saveCliente($datos){
    	return  DB::table('clientes')->insertGetId($datos);
    }
    public static function deleteCliente($id){
    	$status=array('status'=>0);
    	return DB::table('clientes')->where('id',$id)->update($status);
    }
    public static function updateCliente($data){
    	$idcliente=$data['id'];
    	unset($data['id']);
    	return DB::table('clientes')->where('id',$idcliente)->update($data);
    }
    public static function getClave(){
    	$sql="select id,clave from claveClientes where status=0 limit 1";
    	return DB::select($sql);
    }
    public static function where($where){
    	$vacio=0;
        $consulta="select id,rfc,concat_ws(' ',nombres,aPaterno,aMaterno) as cliente,nombres,aPaterno,aMaterno,status,claveCliente  FROM clientes  having status=1 ";
        $indice=0;
        $vacio="";

        foreach($where as $key=>$value):
            if($value!=""){
                $vacio=$value;
                 if($indice>0)
                    $consulta.=' and '.$key.' like '."'".'%'.$value.'%'."'  ";
                else
                    $consulta.=' and  '.$key.' like '."'".'%'.$value.'%'."'  ";
            }else{
                $vacio=$value;
            }
            ++$indice;
        endforeach;
        
        return $consulta;
    }
    public static function filldata($result){
        $indice=0;
        $datos=array();
        foreach($result as $key):
            foreach($key as $r=>$x):
                $datos[$indice][$r]=$x;
            endforeach;
                ++$indice;
        endforeach;
        return $datos;
    }
}