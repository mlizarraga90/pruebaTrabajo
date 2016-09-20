@extends('header')
@section('header')
 	@parent
@stop
@section('container')
	@parent
	<div class="container" ng-controller="clientes">
		<div class="space">&nbsp;</div>
		<div id="divTblClientes" class="ContainerTable">
			<button id="bntAgregarCliente" class="buttons" ng-click="abrirDlgClientes()"><img class="add" src="/assets/images/add.png"/>Nuevo Cliente </button>
			<div>&nbsp;</div>
			<h4 class="titleModule">Clientes</h4>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="dlg" data-backdrop="static" data-keyboard="false">
			<input type="hidden" name="_token"  id="txttoken" value="{{ csrf_token() }}"></input>
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Agregar Cliente</h4>
			      </div>
			      <div class="modal-body">
			       <form id="frmCliente" ng-submit="Guardar()">
				        <div class="row">
				        <input type="hidden" id="txtid" name="txtid" onkeypress="return validarn(event)" ng-model="clientes.id"/>
				        <div class="col-lg-12 col-md-12 col-sm-12">
				        		<label>Clave Cliente</label>
				        		<input type="text" id="txtclaveCliente" name="txtclaveCliente"  class="form-control" readonly="readonly" onkeypress="return validarn(event)" ng-model="clientes.claveCliente"/>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        		<label>Rfc</label>
				        		<input type="text" id="txtrfc" name="txtrfc" placeholder="Rfc" class="form-control" onkeypress="return validarn(event)" ng-model="clientes.rfc"/>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        		<label>Nombre</label>
				        		<input type="text" id="txtnombres" name="txtnombres" placeholder="Nombre" class="form-control" onkeypress="return validarn(event)" ng-model="clientes.nombres"/>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        		<label>Apellido Paterno</label>
				        		<input type="text" id="txtaPaterno" name="txtaPaterno" placeholder="Apellido Paterno" class="form-control" onkeypress="return validarn(event)" ng-model="clientes.apaterno"/>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        		<label>Apellido Materno</label>
				        		<input type="text" id="txtaMaterno" name="rxraMaterno" placeholder="Apellido Materno" class="form-control" onkeypress="return validarn(event)" ng-model="clientes.amaterno"/>
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
				        	<input type="hidden" id="txtidcliente" name="txtid" ng-model="idcliente"/>
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
        idTable:'tblClientes',
        idContainer:'divTblClientes',
        type:'post',
        filters:true,
        paginator:false,
        url:'/getclientes',
        thead:[
          {text:'Clave Cliente',bdName:'claveCliente',name:'claveCliente'},
          {text:'Cliente',bdName:'cliente',name:'cliente'},
          {text:'Rfc Cliente',bdName:'rfc',name:'rfc'},  
          {text:'Eliminar',src:'/assets/images/delete.png',bdName:'id',name:'id',type:'img',click:function(){
          	opendlg=1;
          	$("#txtidcliente").val($(this).attr("id"));
	        $("#dlgEliminar").modal('show');
	      }
      },
        ],
        click:function(){

        	$("#btnGuardar").html('Modificar');
        	opc=1;
        	$("#msgElimi").html('Eliminar Cliente: <b>'+$(this).data('nombres')+'</b>');
        	$("#msj").html('¿Desea eliminar el cliente '+$(this).data('nombres')+' ?');
         	frm.setFrm("frmCliente");//Especificamos el id del formulario a llenar
	        var row = document.getElementById("tblClientes").rows[this.rowIndex]//Obtenemos el index del row
	        frm.filldlgelement(row,tabla.getAttributesrow());
	        if(opendlg==0){
	        	$("#dlg").modal('show');
	        }
	        
        }
    });
    var app=angular.module('vendimia',[]);
    app.controller('clientes',function($scope,$http){
    	$scope.clientes={};
    	getClave();
    	$scope.abrirDlgClientes=function(){
    		getClave();
    		opc=0;
    		$("#txtid").val('0');
    		$("#btnGuardar").html('Guardar');
    		frm.Clrfrm("frmCliente","#ccc");
    		$("#dlg").modal('show');
    	}
    	$scope.Guardar=function(){
    		var url="";
    		if(opc==0)
    			url="/saveCliente";
    		else if(opc==1){
    			url="/updateCliente";
    			$scope.clientes.id=$("#txtid").val();
    			$scope.clientes.nombres=$("#txtnombres").val();
    			$scope.clientes.rfc=$("#txtrfc").val();
    			$scope.clientes.apaterno=$("#txtaPaterno").val();
    			$scope.clientes.amaterno=$("#txtaMaterno").val();
    		}
    		 if(frm.Validate("frmCliente","#c2cad8","red","")==0){
               $http({
				    url: url,
				    method: "POST",
				    data: $scope.clientes,
				    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(data, status, headers, config){
				    if(data>=0){
				    	$("#dlg").modal('hide');
				    	$("#dlgMensajeTitle").html('Clientes');
				    	if(opc==0)
				    		$("#dlgMensajebody").html('Bien Hecho. El cliente ha sido registrado correctamente');
				    	else
				    		$("#dlgMensajebody").html('Bien Hecho. El cliente ha sido modificado correctamente');
				    	$("#dlgMensaje").modal('show');
				    	opendlg=0;
				    	opc=0;
				    }
				    tabla.reload();
				}).error(function(data, status, headers, config) {
				    $("#dlg").modal('hide');
				    $("#dlgMensajeTitle").html('Clientes');
				    $("#dlgMensajebody").html('No se pudo realizar el movimiento');
				    $("#dlgMensaje").modal('show');
				});
            }else{
            		
				$("#dlgMensajeTitle").html('Clientes');
				$("#dlgMensajebody").html('No es posible continuar, debe ingresar los campos color rojo,son obligatorios.');
				$("#dlgMensaje").modal('show');
            }
    	}
    	$scope.Eliminar=function(){
    		opendlg=0;
    		$http({
				    url: "/deleteCliente",
				    method: "POST",
				    data:{'idcliente':$("#txtid").val()},
				    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(data, status, headers, config) {
				     if(data>0){
				     	$("#dlgEliminar").modal('hide');
				    	$("#dlgMensajeTitle").html('Clientes');
				    	$("#dlgMensajebody").html('Se ha eliminado el cliente');
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
    	function getClave(){
    		 $http({
				    url: '/getClave',
				    method: "POST",
				    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(data, status, headers, config) {
					console.log(data[0].clave);
					$scope.clientes.claveCliente=data[0].clave;
				    $("#txtclaveCliente").val(data[0].clave);
				}).error(function(data, status, headers, config) {
				    
				});
    	}
    });
</script>
@stop