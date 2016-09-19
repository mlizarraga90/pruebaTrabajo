@extends('header')
@section('header')
 	@parent
 	<style>
 		#tblVentaArticulos{position: relative;height:250px;border-bottom:1px solid grey;width:100%;}
 		#divtblArticulos,#divTblClientes{width: 100%;}

 	</style>
@stop
@section('container')
	@parent
	<div class="container" ng-controller="ventas">
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
				        		<input type="text" id="txtCliente" name="txtCliente" class="form-control"  placeholder="Cliente" />
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
				        		<input type="text" id="txtArticulo"  class="form-control" name="txtArticulo" placeholder="Articulo" />
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
				        	<div class="col-lg-12  col-md-12  col-sm-12 dicinfoventa" >
				        		<label class="infoVenta">Enganche: $</label><label id="lblEnganche" class="infoCanti">00.00</label>
				        	</div>
				        	<div class="col-lg-12  col-md-12  col-sm-12 dicinfoventa" >
				        		<label class="infoVenta">Bonificacion Enganche: $</label><label id="lblBonificacion" class="infoCanti">00.00</label>
				        	</div>
				        	<div class="col-lg-12  col-md-12  col-sm-12 dicinfoventa" >
				        		<label class="infoVenta">Total: $</label><label id="lblTotal" class="infoCanti">00.00</label>
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
		tabla= new DataTable()
		tableCliente=new DataTable()
		tablaArticulos=new DataTable()
		opendlg=0
		opc=0;/*Nos sirve para saver si se va a guardar o modificar 0=guardar,1=modificar*/
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
		        $("#tblVentaArticulos tbody").append('<tr data-precio="'+$(this).data("precio")+'" data-idarticulo="'+$(this).data("id")+'"><td>'+$(this).data("descripcion")+'</td><td>'+$(this).data("modelo")+'</td><td><input id="'+$(this).data("id")+'"type="text" data-existencia="'+$(this).data('existencia')+'"class="inputarticulo" name="'+$(this).data('precio')+'" onkeypress="return validarn(event)" /></td><td>'+$(this).data("precio")+'</td><td>$0.00</td><td><img class="elimnar" src="/assets/images/delete.png"/></td></tr>');
		        $("#"+$(this).data("id")).focus();
		        $("#tblVentaArticulos tr").delegate('.elimnar','click',function(){
			    	$(this).closest('tr').remove();
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
	          {text:'Cliente',bdName:'cliente',name:'cliente'},  
	          {text:'Total',bdName:'total',name:'total'},  
	          {text:'Fecha',bdName:'fecha',name:'fecha'},  
	          {text:'Estatus',bdName:'estatus',name:'estatus'},  
	          {text:'Eliminar',src:'/assets/images/delete.png',bdName:'id',name:'id',type:'img',click:function(){
	          	opendlg=1;
	          	$("#txtidcliente").val($(this).attr("id"));
		        $("#dlgEliminar").modal('show');
		      }
	      },
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
		$("#tblVentaArticulos  ").delegate('input','keyup',function(index){
			$(this).val(validateDecimal(this.value));
			var row = document.getElementById("tblClientes").rows[$(this).closest('tr')[0].rowIndex];
			var precio=$(this).attr('name');
			if($(this).val()!=""){
				if(parseInt($(this).val())>parseInt($(this).data('existencia'))){//Si la cantidad en el input es mapyr a la existencia
					
					$("#dlgMensajebody").html('El artículo seleccionado no cuenta con existencia, favor de verificar');
					$("#dlgMensaje").modal('show');
					$("#dlgMensajeTitle").html('Ventas');
				    $(this).val($(this).data('existencia'));
				}else{
					var importe=0;
					importe=( parseInt($(this).val())*parseFloat(precio) );
				 	$('#tblVentaArticulos tr:nth-child('+$(this).closest('tr')[0].rowIndex+') td:nth-child(5)').html('$'+importe);
				}
				
			}else{
				 $('#tblVentaArticulos tr:nth-child('+$(this).closest('tr')[0].rowIndex+') td:nth-child(5)').html('$0.00');
			}
		});
    var app=angular.module('vendimia',[]);
    app.controller('ventas',function($scope,$http){
    	$scope.ventas={};
    	getFolio();
    	$scope.abrirDlgVentas=function(){
    		$("#dlgVentas").modal('show');
    	}
    	$scope.BuscarCliente=function(){
    		$("#dlgMensajeTitle").html('Clientes');
    		$("#divTblClientes").show();
    		$("#divtblArticulos").hide();
    		$("#dlgCliente").modal('show');
    		
    	}
    	$scope.BuscarArticulo=function(){
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

    });
</script>
@stop