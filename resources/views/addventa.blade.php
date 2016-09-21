@extends('header')
@section('header')
 	@parent
 	<style>
 		#tblVentaArticulos{position: relative;height:250px;border-bottom:1px solid grey;width:100%;}
 		#divtblArticulos,#divTblClientes{width: 100%;overflow: auto;}
 		.fade.in {opacity: 1;overflow: auto!important;}
 		#btnGenerarVenta,#divPlazos{display: none;}

 	</style>
@stop
@section('container')
	@parent
	<div class="container" ng-controller="ventas">
	<div class="space">&nbsp;</div>
		<div id="divTblVentas" class="ContainerTable">
			<button id="bntAgregarCliente" class="buttons" ng-click="abrirDlgVentas()"><img class="add" src="/assets/images/add.png"/>Nuevo Venta </button>
			<div>&nbsp;</div>
			<h4 class="titleModule">Ventas Activas</h4>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="dlgVentas" data-backdrop="static" data-keyboard="false">
			<input type="hidden" name="_token"  id="txttoken" value="{{ csrf_token() }}"></input>
			<div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Registro de Ventas</h4>
			      </div>
			      <div class="modal-body">
			       <form id="frmCliente" ng-submit="Guardar()">
				        <div class="row">
				        	<div class="col-lg-3 col-lg-push-9 col-md-3 col-md-push-9 col-sm-4 col-sm-push-8">
				        		<label class="folio">Folio:</label><label class="folio"  id="folio" >------</label>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">&nbsp;</div>
				        	<input type="hidden" id="txtid" name="txtid" onkeypress="return validarn(event)" ng-model="clientes.id"/>
				        	<div class="col-lg-3 col-md-3 col-sm-3">
				        		<button type="button" class="btn btn-primary" ng-click="BuscarCliente()" >Buscar Cliente</button>
				        	</div>
				        	<div class="col-lg-5 col-md-5 col-sm-6">
				        		<input type="text" id="txtCliente" name="txtCliente" class="form-control"  placeholder="Cliente"  readonly="readonly"/>
				        		<input type="hidden" id="txtidCliente" name="txtidCliente"  class="form-control" ng-model="Ventas.idCliente"/>
				        	</div>
				        	<div class="col-lg-4 col-md-4 col-sm-3">
				        		<label id="lblRfc"></label>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">&nbsp;</div>
				        	<!--Articulos-->
				        	<div class="col-lg-3 col-md-3 col-sm-3">
				        		<button type="button" class="btn btn-primary" ng-click="BuscarArticulo()" >Buscar Articulo</button>
				        	</div>
				        	<div class="col-lg-5 col-md-5 col-sm-9">
				        		<input type="text" id="txtArticulo"  class="form-control" name="txtArticulo" placeholder="Articulo"readonly="readonly" />
				        		<input type="hidden" id="txtidArticulo"  class="form-control" name="txtidArticulo" ng-model="Ventas.idArticulo"/>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">&nbsp;</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        		<table id="tblVentaArticulos" class="table">
				        			<thead>
				        				<tr>
				        					<th>Descripción Articulo</th>
				        					<th>Modelo</th>
				        					<th>Cantidad</th>
				        					<th>Precio</th>
				        					<th>Importe</th>
				        					<th>Eliminar</th>
				        				</tr>
				        			</thead>
				        			<tbody></tbody>
				        		</table>
				        	</div>
				        	<div class="col-lg-12 col-md-12 col-sm-12" id="divPlazos">
				        		<h3>ABONOS MENSUALES</h3>
				        		<table id="tblPlazos" class="table">
				        			<tbody></tbody>
				        		</table>
				        		<input type="hidden" id="txtPlazo" ng-model="Ventas.plazo"/>
				        		<input type="hidden" id="txtimporteAbono" ng-model="Ventas.importeAbono"/>
				        		<input type="hidden" id="txtimporteAhorro" ng-model="Ventas.importeAhorro"/>
				        		<input type="hidden" id="txttotalPagar" ng-model="Ventas.totalPagar"/>
				        		<input type="hidden" id="txtprecioContado" ng-model="Ventas.precioContado"/>
				        	</div>
				        	<div class="col-lg-12  col-md-12  col-sm-12 dicinfoventa" >
				        		<label class="infoVenta">Enganche: $</label><label id="lblEnganche" class="infoCanti" ng-model="Ventas.enganche">00.00</label>
				        	</div>
				        	<div class="col-lg-12  col-md-12  col-sm-12 dicinfoventa" >
				        		<label class="infoVenta">Bonificacion Enganche: $</label><label id="lblBonificacion" class="infoCanti" ng-model="Ventas.bonificacion">00.00</label>
				        	</div>
				        	<div class="col-lg-12  col-md-12  col-sm-12 dicinfoventa" >
				        		<label class="infoVenta">Total: $</label><label id="lblTotal" class="infoCanti" ng-model="Ventas.total">00.00</label>
				        	</div>
				        </div>
				    </form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="cancelar()">Cancelar</button>
			        <button type="submit" class="btn btn-primary" ng-click="Siguiente()" id="btnGuardar">Siguiente</button>
			        <button type="submit" class="btn btn-primary" ng-click="guardarVenta()" id="btnGenerarVenta">Guardar</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!--Modal Clientes-->
		<div class="modal fade" tabindex="-1" role="dialog" id="dlgCliente" data-backdrop="static" data-keyboard="false">
			  <input type="hidden" name="_token"  id="txttoken" value="{{ csrf_token() }}"></input>
			<div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="dlgMensajeTitle"></h4>
			      </div>
			      <div class="modal-body">
				        <div class="row">
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        		<div id="divTblClientes" class="ContainerTable">
									<div>&nbsp;</div>
									<h4 class="titleModule">Clientes</h4>
								</div>
								<div id="divtblArticulos" class="ContainerTable">
									<div>&nbsp;</div>
									<h4 class="titleModule">Articulos</h4>
								</div>
				        	</div>
				        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
		f = new Date()
		fecha="";
		tabla= new DataTable()
		tableCliente=new DataTable()
		tablaArticulos=new DataTable()
		opendlg=0
		opc=0
		Articulos=[]
		configuracion={
			tazaFinanciamiento:'',
			enganche:'',
			plazoMaximo:''
		};/*Nos sirve para saver si se va a guardar o modificar 0=guardar,1=modificar*/
		fecha=f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
		$("#fecha").html(fecha);
		tableCliente.CerateDataTable({
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
			],click:function(){
				$("#txtidCliente").val($(this).data('id'));
				$("#txtCliente").val($(this).data('cliente'));
				$("#lblRfc").html('RFC: '+$(this).data('rfc'));
				$("#dlgCliente").modal('hide');
			}
		});
		tablaArticulos.CerateDataTable({
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
	        ],
	        click:function(){
	        	$("#txtArticulo").val($(this).data("descripcion"));
		        $("#txtidArticulo").val($(this).data("id"));
		        $("#tblVentaArticulos tbody").append('<tr data-precio="'+$(this).data("precio")+'" data-idarticulo="'+$(this).data("id")+'"><td>'+$(this).data("descripcion")+'</td><td>'+$(this).data("modelo")+'</td><td><input id="'+$(this).data("id")+'"type="text" data-existencia="'+$(this).data('existencia')+'"class="inputarticulo" name="'+$(this).data('precio')+'" onkeypress="return float(event)" /></td><td>$0.00</td><td>$0.00</td><td><img class="elimnar" src="/assets/images/delete.png"/></td></tr>');
		        $("#"+$(this).data("id")).focus();
		        $("#tblVentaArticulos tr").delegate('.elimnar','click',function(){
			    	$(this).closest('tr').remove();
			    	CalcularDetalleVenta(0,0,0,0,0,0)
			    })
		        $("#dlgCliente").modal('hide');
	        }
   		});
	    tabla.CerateDataTable({
	        idTable:'tblVentas',
	        idContainer:'divTblVentas',
	        type:'post',
	        filters:true,
	        paginator:false,
	        url:'/getventas',
	        thead:[
	          {text:'Folio Venta',bdName:'folio',name:'folio'},
	          {text:'Clave Cliente',bdName:'clave',name:'clave'},
	          {text:'Cliente',bdName:'clientes',name:'clientes'},  
	          {text:'Total',bdName:'total',name:'total'},  
	          {text:'Fecha',bdName:'fecha',name:'fecha'},  
	          {text:'Estatus',bdName:'estatus',name:'estatus'},  
	        ],
	        click:function(){
	        }
	    });
	    $(".float").keyup(function(event) {
			$(this).val(validateDecimal(this.value));
		});
		function validateDecimal(value){
		        var RE = /^\d*\.?\d*$/;
		        if(RE.test(value)){
		           return value;
		        }else {
		        	var a=''
		        	return a;
		        }
		}
		$("#tblVentaArticulos").delegate('input','keyup',function(inde){
			var importe=0
				precio=0
				enganche=0
				bonificacion=0
				total=0
				tasafinaplazo=0;
				
				if($(this).val!="" && $(this).val()>0){
					CalcularDetalleVenta(importe,precio,enganche,bonificacion,total,tasafinaplazo);
				}else{
					if($('#tblVentaArticulos >tbody >tr').length==0){
						$("#lblEnganche").html('0.00');
						$("#lblBonificacion").html('0.00');
						$("#lblTotal").html('0.00');
					}else {
						
						CalcularDetalleVenta(importe,precio,enganche,bonificacion,total,tasafinaplazo);
					}
					
				}

			
			
		});
		function BloquearInputs(opc){//opc=1=bloqueas,opc=0=desbloqeas
			$("#tblVentaArticulos").find('input').each(function(){
				if(opc==1)
					$(this).attr('readonly','readonly');
				else
					$(this).removeAttr('readonly');
			});
		}
		function CalcularDetalleVenta(importe,precio,enganche,bonificacion,total,tazaFinanciamiento){
			$("#tblVentaArticulos").find('input').each(function(index,i){
				var preciotabla=0
					importetabla=0;
				index+=1;

				if($(this).val()!=""){
					if(parseInt($(this).val())>parseInt($(this).data('existencia'))){//Si la cantidad en el input es mapyr a la existencia
						$("#dlgMensajebody").html('El artículo seleccionado no cuenta con existencia, favor de verificar');
						$("#dlgMensaje").modal('show');
						$("#dlgMensajeTitle").html('Ventas');
						$('#tblVentaArticulos tr:nth-child('+index+') td:nth-child(4)').html('$0.00');
					 	$('#tblVentaArticulos tr:nth-child('+index+') td:nth-child(5)').html('$0.00');
					    $(this).val('0');
					}else {
						tasafinaplazo=(1+(configuracion.tazaFinanciamiento*configuracion.plazoMaximo)/100).toFixed(2);
						precio=parseFloat($(this).attr('name'))*parseFloat(tasafinaplazo);
						preciotabla=parseFloat($(this).attr('name'))*parseFloat(tasafinaplazo);
						importe=( parseInt($(this).val())*precio)
						importetabla=( parseInt($(this).val())*preciotabla);
						enganche+=(parseFloat(configuracion.enganche)/100)*importe
						bonificacion+=enganche*( ( parseFloat(configuracion.tazaFinanciamiento)*parseFloat(configuracion.plazoMaximo) )/100 )
						total+=importe-enganche-bonificacion;
						$("#lblEnganche").html(enganche.toFixed(2));
						$("#lblBonificacion").html(bonificacion.toFixed(2) );
						$("#lblTotal").html(total.toFixed(2) );
						$('#tblVentaArticulos tr:nth-child('+index+') td:nth-child(4)').html('$'+preciotabla.toFixed(2));
					 	$('#tblVentaArticulos tr:nth-child('+index+') td:nth-child(5)').html('$'+importetabla.toFixed(2));
					}
				}
			});
		}
    var app=angular.module('vendimia',[]);
    app.controller('ventas',function($scope,$http){
    	$scope.Ventas={};
    	getFolio();
    	getConfig();
    	$scope.cancelar=function(){
    		$(".filters").val('');
    	}
    	$scope.abrirDlgVentas=function(){
    		getFolio();
    		BloquearInputs(2);
    		$(".filters").val('');
    		$("#dlgVentas").modal('show');
    		$("#btnGuardar").show();
    		$("#btnGenerarVenta,#divPlazos").hide();
    		$("#tblVentaArticulos tbody tr,#tblPlazos tbody tr").remove();
    		$("#txtCliente,#txtArticulo").val('');
    		$("#lblRfc").html('');

    	}
    	$scope.BuscarCliente=function(){
    		$(".filters").val('');
    		$("#dlgMensajeTitle").html('Clientes');
    		$("#divTblClientes").show();
    		$("#divtblArticulos").hide();
    		$("#dlgCliente").modal('show');
    		
    	}
    	$scope.BuscarArticulo=function(){
    		$(".filters").val('');
    		$("#txtArticulo").val('');
    		$("#dlgMensajeTitle").html('Articulos');
    		$("#divTblClientes").hide();
    		$("#divtblArticulos").show();
    		$("#dlgCliente").modal('show');
    		
    	}
    	function getFolio(){
    		 $http({
				    url: '/getFolio',
				    method: "POST",
				    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(data, status, headers, config) {
					if(frm.isEmptyJSON(data)==true){
						$("#folio").html('00001');
					}else{
						$("#folio").html(data[0].folio);
					}
				}).error(function(data, status, headers, config) {
				});
    	}
    	$scope.Siguiente=function(){
    		if($("#txtCliente").val()!="" && checkinputtablevacio()==0 ){//Si selecciono un cliete y si todos los inputs de la tabla articulos tienen datos.
    			$("#btnGuardar").hide();
    			$("#divPlazos,#btnGenerarVenta").show();
    			CretaePlazos();
    			BloquearInputs(1);
    		}else{
    			 $("#dlgMensajeTitle").html('Clientes');
				 $("#dlgMensajebody").html('Los datos ingresados no son correctos, favor de verificar');
				 $("#dlgMensaje").modal('show');
    		}
    	}
    	$scope.guardarVenta=function(){
    		if(checkRadio()==1){
    			$scope.Ventas.idCliente=$("#txtidCliente").val();
    			$scope.Ventas.idArticulo=$("#txtidArticulo").val();
    			$scope.Ventas.enganche=$("#lblEnganche").html();
    			$scope.Ventas.bonificacion=$("#lblBonificacion").html();
    			$scope.Ventas.total=$("#lblTotal").html();
    			$scope.Ventas.plazo=$("#txtPlazo").val();
    			$scope.Ventas.importeAbono=$("#txtimporteAbono").val();
    			$scope.Ventas.importeAhorro=$("#txtimporteAhorro").val();
    			$scope.Ventas.totalPago=$("#txttotalPagar").val();
    			$scope.Ventas.precioContado=$("#txtprecioContado").val();
    			$scope.Ventas.articulos=Articulos;
    			$scope.Ventas.folio=$("#folio").html();

    			$http({
				    url:'/addVenta',
				    method: "POST",
				    data: $scope.Ventas,
				    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(data, status, headers, config){
				    if(data>=0){
				    	$("#dlgVentas").modal('hide');
			    		$("#btnGuardar").show();
			    		$("#btnGenerarVenta,#divPlazos").hide();
			    		$("#tblVentaArticulos tbody tr,#tblPlazos tbody tr").remove();
			    		$("#txtCliente,#txtArticulo").val('');
			    		$("#lblRfc").html('');
			    		$("#dlgMensajeTitle").html('Ventas');
						$("#dlgMensajebody").html('Bien Hecho, Tu venta ha sido registrada correctamente');
						$("#dlgMensaje").modal('show');

				    	
				    }
				    tabla.reload();
				}).error(function(data, status, headers, config) {
				    $("#dlg").modal('hide');
				    $("#dlgMensajeTitle").html('Ventas');
				    $("#dlgMensajebody").html('No se pudo realizar el movimiento');
				    $("#dlgMensaje").modal('show');
				});
    		}else{
    			 $("#dlgMensajeTitle").html('Ventas');
				 $("#dlgMensajebody").html('Debe seleccionar un plazo para realizar el pago de su compra');
				 $("#dlgMensaje").modal('show');
    		}
    	}
    	function checkRadio(){
    		exito=0;
    		$("#tblPlazos").find('input').each(function(index,i){
    			
    			if($(this).attr('type')=="radio")
    				if($(this).prop('checked')==true){
    					exito=1;
    					var row = document.getElementById("tblPlazos").rows[index];
		    			$("#txtPlazo").val(row.getAttribute('data-plazo'));
		    			$("#txtimporteAbono").val(row.getAttribute('data-abono'));
		    			$("#txtimporteAhorro").val(row.getAttribute('data-ahorro'));
		    			$("#txttotalPagar").val(row.getAttribute('data-totalpagar'));
		    			$("#txtprecioContado").val(row.getAttribute('data-contado'));
		    			Articulos=[];
						Articulos.length = 0;
						Articulos.splice(0,Articulos.length-1);
		    			getArticulosSave();
    				}
    		});
    		return exito;
    	}
    	function getArticulosSave(){
    		row=$('#tblVentaArticulos >tbody >tr').length;
    		if(row>0){
    			$("#tblVentaArticulos").find('input').each(function(){
    				if($(this).attr('type')=="text")
	    				if($(this).val()!=""){
	    					console.log($(this).attr('id'));
	    					Articulos.push({'id':$(this).attr('id'),'cantidad':$(this).val()});
	    				}
	    		});
    		}
    	}
    	function CretaePlazos(){
    		var precioContado=0
    			totalPagar=0
    			importeAbono=0
    			importeAhorra=0;
    		for(var i=3;i<=12;i+=3){
    			precioContado=parseFloat($("#lblTotal").html())/(1+(parseFloat(configuracion.tazaFinanciamiento)*parseInt(configuracion.plazoMaximo) )/100 );
    			totalPagar=precioContado*(1+(parseFloat(configuracion.tazaFinanciamiento)*i)/100 );
    			
    			importeAbono=totalPagar/i;
    			importeAhorra=parseFloat($("#lblTotal").html())-totalPagar;
    			$("#tblPlazos tbody").append('<tr data-contado="'+precioContado.toFixed(2)+'"data-plazo="'+i+'"data-abono="'+importeAbono.toFixed(2)+'" data-totalpagar="'+totalPagar.toFixed(2)+'" data-ahorro="'+importeAhorra.toFixed(2)+'"><td>'+i+' ABONOS DE </td><td>$'+importeAbono.toFixed(2)+'</td><td>TOTAL A PAGAR $'+totalPagar.toFixed(2)+'</td><td>SE AHORRA $'+importeAhorra.toFixed(2)+'</td><td><input type="radio" name="rdbplazo" /></td></tr>');
    		}

    	}
    	function checkinputtablevacio(){
    		var exito=0;
    		row=$('#tblVentaArticulos >tbody >tr').length;
    		if(row>0){
    			$("#tblVentaArticulos").find('input').each(function(){
    				if($(this).attr('type')=="text")
	    				if($(this).val()=="")
	    					exito=1
	    				else if($(this).val()<=0)
	    					exito=1
	    		});
    		}else{
    			exito=1;
    		}
    		return exito;
    	}
    	function getConfig(){
			$http({
				url: '/getConfig',
				method: "POST",
				headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(data, status, headers, config) {
				if(frm.isEmptyJSON(data)==false){
					configuracion.tazaFinanciamiento=data[0].tazaFinanciamiento;
					configuracion.enganche=data[0].enganche;
					configuracion.plazoMaximo=data[0].plazoMaximo;
				}
			}).error(function(data, status, headers, config) {
				    
			});
		}

    });
</script>
@stop