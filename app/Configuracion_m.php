<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
USE Auth;

class Configuracion_m extends Model{
    public static function  getConfig(){
        $sql="select id,FORMAT(tazaFinanciamiento,2) as tazaFinanciamiento,FORMAT(enganche,2) as enganche,plazoMaximo from configuracion";
        return DB::select($sql);
    }
    public static function saveConfiguracion($data){
        return  DB::table('configuracion')->insertGetId($data);
    }
    public static function updateConfiguracion($data){
        $id=$data['id'];
        unset($data['id']);
        return DB::table('configuracion')->where('id',$id)->update($data);
    }

}