<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
USE Auth;

class Articulos_m extends Model{
    public static function  getarticulos($where){
        unset($where['_token']);
        $articuloss= DB::select(self::where($where));
        return self::filldata($articuloss);
    }
    public static function savearticulos($datos){
    	return  DB::table('articulos')->insertGetId($datos);
    }
    public static function deletearticulos($id){
    	$status=array('status'=>0);
    	return DB::table('articulos')->where('id',$id)->update($status);
    }
    public static function updatearticulos($data){
    	$idarticulos=$data['id'];
    	unset($data['id']);
    	return DB::table('articulos')->where('id',$idarticulos)->update($data);
    }
    public static function where($where){
    	$vacio=0;
        $consulta="select id,descripcion,modelo,CONCAT('$',FORMAT(precio,2)) as precioformat,FORMAT(precio,2) as precio,existencia,status from articulos having status=1 ";
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