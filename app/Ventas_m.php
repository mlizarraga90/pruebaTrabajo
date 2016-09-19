<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
USE Auth;

class Ventas_m extends Model{
    public static function  getventas($where){
        unset($where['_token']);
        $ventas= DB::select(self::where($where));
        return self::filldata($ventas);
    }
    public static function getFolio(){
        $sql="select id,folio from folios where status=1";
        return DB::select($sql);
    }
    public static function where($where){
    	$vacio=0;
        $consulta="select folio,CONCAT_WS(' ',nombres,aPaterno,aMaterno) AS cliente,claveCliente,descripcion,fecha,total,IF(ventas.STATUS=1,'Activa','Deactiva') AS estatus,ventas.STATUS FROM ventas
                    inner join  clientes ON clientes.id=ventas.idCliente
                    inner join articulos ON articulos.id=ventas.idArticulo having status=1";
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