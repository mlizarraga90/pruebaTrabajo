@extends('header')
@section('header')
 	@parent
 	<style>
 		#btnGuadarConfig{float:right;}
 	</style>
@stop
@section('container')
	@parent

<div class="container" ng-controller="configuracion">
		<div class="ContainerTable">
			<h3 class="titleModule">Configuracion General</h3>
			<form ng-submit="Guadar()" id="frmConfiguracion">
			<input type="hidden" id="txtid" name="txtid" ng-model="configuracion.id"/>
				<div class="col-lg-8 col-lg-push-2 col-md-10 col-md-push-2  col-sm-8 col-sm-push-2">
					<label>Taza Financiamiento</label>
					<input type="text" class="form-control" id="txttaza" name="taza" placeholder="Taza Financiamiento" onkeypress="return float(event)" ng-model="configuracion.tazaFinanciamiento"/>
				</div>
				<div class="col-lg-8 col-lg-push-2 col-md-10 col-md-push-2  col-sm-8 col-sm-push-2">
					<label>% Enganche</label>
					<input type="text" class="form-control" id="txtenganche" name="txtenganche" placeholder="% Enganche" onkeypress="return float(event)" ng-model="configuracion.enganche"/>
				</div>
				<div class="col-lg-8 col-lg-push-2 col-md-10 col-md-push-2  col-sm-8 col-sm-push-2">
					<label>Plazo Máximo</label>
					<input type="text" class="form-control" id="txtplazo" name="txtplazo" placeholder="Plazo Máximo" onkeypress="return float(event)" ng-model="configuracion.plazoMaximo"/>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">&nbsp;</div>
				<div class="col-lg-8 col-lg-push-2 col-md-10 col-md-push-2  col-sm-10 col-sm-push-2">
					<button type="button" id="btnCancelar" ng-click="cancelar()" class="btn btn-primary">Cancelar</button>
				 	<button type="button" id="btnGuadarConfig" ng-click="Guardar()" class="btn btn-primary">Guadar</button>
				</div>
			</form>
		</div>

</div>
@stop
@section('footer')
	@parent
<script>
	var frm=new valudateForm();
	var app=angular.module('vendimia',[]);
	app.controller('configuracion',function($scope,$http){
		$scope.configuracion={};
		getConfig();
		$scope.Guardar=function(){
			var url="";
			if($scope.configuracion.id!="")
				url='/updateConfiguracion';
			else
				 url='/saveConfiguracion';

			if(frm.Validate("frmConfiguracion","#c2cad8","red","")==0){
               $http({
				    url:url,
				    method: "POST",
				    data: $scope.configuracion,
				    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(data, status, headers, config){
				    if(data>=0){
				    	$("#dlgMensajeTitle").html('Articulos');
				    	$("#dlgMensajebody").html('Bien Hecho. La configuración ha sido registrada');
				    	$("#dlgMensaje").modal('show');
				    	opendlg=0;
				    	opc=0;
				    	getConfig();
				    }
				}).error(function(data, status, headers, config) {
				    $("#dlgArticulos").modal('hide');
				    $("#dlgMensajeTitle").html('Articulos');
				    $("#dlgMensajebody").html('No se pudo realizar el movimiento');
				    $("#dlgMensaje").modal('show');
				});
            }else{
            		
				$("#dlgMensajeTitle").html('Configuracion');
				$("#dlgMensajebody").html('No es posible continuar, debe ingresar los campos color rojo,son obligatorios.');
				$("#dlgMensaje").modal('show');
            }
		}
		function getConfig(){
			$http({
				url: '/getConfig',
				method: "POST",
				headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(data, status, headers, config) {
				if(frm.isEmptyJSON(data)==false){
					$scope.configuracion.id=data[0].id;
					$scope.configuracion.tazaFinanciamiento=data[0].tazaFinanciamiento;
					$scope.configuracion.enganche=data[0].enganche;
					$scope.configuracion.plazoMaximo=data[0].plazoMaximo;
				}
			}).error(function(data, status, headers, config) {
				    
			});
		}

	});

	
</script>
@stop