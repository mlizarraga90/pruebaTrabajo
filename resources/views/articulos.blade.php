@extends('header')
@section('header')
 	@parent
@stop
@section('container')
	@parent
<div class="container" ng-controller="articulos">
		<div class="space">&nbsp;</div>
		<div id="divtblArticulos" class="ContainerTable">
			<button id="bntAgregarCliente" class="buttons" ng-click="abrirDlgArticulos()"><img class="add" src="/assets/images/add.png"/>Nuevo Articulo </button>
			<div>&nbsp;</div>
			<h4 class="titleModule">Articulos</h4>
		</div>
			<div class="modal fade" tabindex="-1" role="dialog" id="dlgArticulos" data-backdrop="static" data-keyboard="false">
			<input type="hidden" name="_token"  id="txttoken" value="{{ csrf_token() }}"></input>
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Agregar Articulos</h4>
			      </div>
			      <div class="modal-body">
			       <form id="frmArticulos" ng-submit="Guardar()">
				        <div class="row">
				        <input type="hidden" id="txtid" name="txtid" onkeypress="return validarn(event)" ng-model="articulos.id"/>
				        <div class="col-lg-12 col-md-12 col-sm-12">
				        		<label>Descripción</label>
				        		<input type="text" id="txtdescripcion" name="txtdescripcion"  placeholder="Descripción" class="form-control"  onkeypress="return validarn(event)" ng-model="articulos.descripcion"/>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        		<label>Modelo</label>
				        		<input type="text" id="txtmodelo" name="txtmodelo" placeholder="Modelo" class="form-control" onkeypress="return validarn(event)" ng-model="articulos.modelo"/>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        		<label>Precio</label>
				        		<input type="text" id="txtprecio" name="txtprecio" placeholder="Precio" class="form-control" onkeypress="return float(event)" ng-model="articulos.precio"/>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        		<label>Existencia</label>
				        		<input type="text" id="txtexistencia" name="txtexistencia" placeholder="Existencia" class="form-control" onkeypress="return validarn(event)" ng-model="articulos.existencia"/>
				        	</div>
				        </div>
				    </form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			        <button type="submit" class="btn btn-primary" ng-click="Guardar()" id="btnGuardar">Guardar</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<div class="modal fade" tabindex="-1" role="dialog" id="dlgEliminar" data-backdrop="static" data-keyboard="false">
			  <input type="hidden" name="_token"  id="txttoken" value="{{ csrf_token() }}"></input>
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="msgElimi">Eliminar Cliente </h4>
			      </div>
			      <div class="modal-body">
			       <form id="frmEliminar" >
				        <div class="row">
				        	<input type="hidden" id="txtidarticulo" name="txtid" ng-model="idcliente"/>
				        	<h3 id="msj"></h3>
				        </div>
				    </form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			        <button type="submit" class="btn btn-warning dropdown-toggle" ng-click="Eliminar()">Eliminar</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
</div>
	
@stop
@section('footer')
	@parent

<script>
	var frm=new valudateForm()
		tabla= new DataTable()
		opendlg=0
		opc=0;/*Nos sirve para saver si se va a guardar o modificar 0=guardar,1=modificar*/
    tabla.CerateDataTable({
        idTable:'tblArticulos',
        idContainer:'divtblArticulos',
        type:'post',
        filters:true,
        paginator:false,
        url:'/getarticulos',
        thead:[
          {text:'Descripción',bdName:'descripcion',name:'descripcion'},
          {text:'Modelo',bdName:'modelo',name:'modelo'},
          {text:'Precio',bdName:'precioformat',name:'precioformat'},
          {text:'Existencia',bdName:'existencia',name:'existencia'},  
          {text:'Eliminar',src:'/assets/images/delete.png',bdName:'id',name:'id',type:'img',click:function(){
          	opendlg=1;
          	$("#txtidarticulo").val($(this).attr("id"));
	        $("#dlgEliminar").modal('show');
	      }
      },
        ],
        click:function(){
        	$("#btnGuardar").html('Modificar');
        	opc=1;
        	$("#msgElimi").html('Eliminar Articulo: <b>'+$(this).data('descripcion')+'</b>');
        	$("#msj").html('¿Desea eliminar el articulo '+$(this).data('descripcion')+' ?');
         	frm.setFrm("frmArticulos");//Especificamos el id del formulario a llenar
	        var row = document.getElementById("tblArticulos").rows[this.rowIndex]//Obtenemos el index del row
	        frm.filldlgelement(row,tabla.getAttributesrow());
	        if(opendlg==0){
	        	$("#dlgArticulos").modal('show');
	        }
        }
	        
    });
    var app=angular.module('vendimia',[]);
    app.controller('articulos',function($scope,$http){
    	$scope.articulos={};
    	$scope.abrirDlgArticulos=function(){
    		opc=0;
    		$("#txtid").val('0');
    		$("#btnGuardar").html('Guardar');
    		frm.Clrfrm("frmArticulos","#ccc");
    		$("#dlgArticulos").modal('show');
    	}
    	$scope.Guardar=function(){
    		var url="";
    		if(opc==0)
    			url="/savearticulos";
    		else if(opc==1){
    			url="/updatearticulos";
    			$scope.articulos.id=$("#txtid").val();
    			$scope.articulos.descripcion=$("#txtdescripcion").val();
    			$scope.articulos.modelo=$("#txtmodelo").val();
    			$scope.articulos.precio=$("#txtprecio").val();
    			$scope.articulos.existencia=$("#txtexistencia").val();
    		}
    		 if(frm.Validate("frmArticulos","#c2cad8","red","")==0){
               $http({
				    url: url,
				    method: "POST",
				    data: $scope.articulos,
				    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(data, status, headers, config){
				    if(data>=0){
				    	$("#dlgArticulos").modal('hide');
				    	$("#dlgMensajeTitle").html('Articulos');
				    	if(opc==0)
				    		$("#dlgMensajebody").html('Bien Hecho. El articulo ha sido registrado correctamente');
				    	else
				    		$("#dlgMensajebody").html('Bien Hecho. El articulo ha sido modificado correctamente');
				    	$("#dlgMensaje").modal('show');
				    	opendlg=0;
				    	opc=0;
				    }
				    tabla.reload();
				}).error(function(data, status, headers, config) {
				    $("#dlgArticulos").modal('hide');
				    $("#dlgMensajeTitle").html('Articulos');
				    $("#dlgMensajebody").html('No se pudo realizar el movimiento');
				    $("#dlgMensaje").modal('show');
				});
            }else{
            		
				$("#dlgMensajeTitle").html('Articulos');
				$("#dlgMensajebody").html('No es posible continuar, debe ingresar los campos color rojo,son obligatorios.');
				$("#dlgMensaje").modal('show');
            }
    	}
    	$scope.Eliminar=function(){
    		opendlg=0;
    		$http({
				    url: "/deletearticulos",
				    method: "POST",
				    data:{'idarticulo':$("#txtidarticulo").val()},
				    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(data, status, headers, config) {
				     if(data>0){
				     	$("#dlgEliminar").modal('hide');
				    	$("#dlgMensajeTitle").html('Clientes');
				    	$("#dlgMensajebody").html('Se ha eliminado el articulo');
				    	$("#dlgMensaje").modal('show');
				    	opendlg=0;
				    	tabla.reload();
				    }
				    
				}).error(function(data, status, headers, config) {
				     $("#dlgEliminar").modal('hide');
				    $("#dlgMensajeTitle").html('Clientes');
				    $("#dlgMensajebody").html('No se pudo realizar el movimiento');
				    $("#dlgMensaje").modal('show');
				});
    	}
    });
</script>
@stop