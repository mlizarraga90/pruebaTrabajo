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
        $sql="select id,folio from folios where status=0";
        return DB::select($sql);
    }
    public static function addVenta($data){
        $articulos=array('idCliente'=>$data['idCliente'],'totalcondescuento'=>$data['totalPago'],'total'=>$data['total'],'folio'=>$data['folio'],'plazo'=>$data['plazo'],'abono'=>$data['importeAbono'],'enganche'=>$data['enganche'],'ahorro'=>$data['importeAhorro'],'precioContado'=>$data['precioContado']);
        $id=DB::table('ventas')->insertGetId($articulos);
        if($id>0){
            $total=count($data['articulos']);
            for($i=0;$i<$total;$i++){
                $detalleArticulo=array('folio'=>$data['folio'],'idProducto'=>$data['articulos'][$i]['id'],'cantidad'=>$data['articulos'][$i]['cantidad']);
                DB::table('detalleventas')->insertGetId($detalleArticulo);
            }
            return $id;
        }
    }
    public static function where($where){
    	$vacio=0;
        $consulta="SELECT ventas.folio,CONCAT_WS(' ',nombres,aPaterno,aMaterno) AS clientes,claveCliente as clave,descripcion,fecha,format(total,2) as total,IF(ventas.STATUS=1,'Activa','Deactiva') AS estatus,ventas.STATUS FROM ventas
                    INNER JOIN  clientes ON clientes.id=ventas.idCliente
                    INNER JOIN detalleventas ON detalleVentas.`folio`=ventas.`folio`
                    INNER JOIN articulos ON articulos.id=detalleVentas.`idProducto` GROUP BY ventas.folio having status=1";

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