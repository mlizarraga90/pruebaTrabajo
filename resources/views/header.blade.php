@section('header')
	<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<title></title>
				<link rel="stylesheet" type="text/css" href="assets/css/vendimia.css">
				<link rel="stylesheet" type="text/css" href="assets/boostrap/css/bootstrap.min.css">
			</head>

@show
@section('menu')
			<body ng-app="vendimia">
				<div class="fullcontainer">
					<div class="nav-bar">
					<label class="fecha" id="fecha"></label>
						<ul>
							<li>
								<a>Inicio</a>
								<ul>
									<li class="separator"><a href="/ventas">Ventas</a></li>
									<li><a href="/addclientes">Clientes</a></li>
									<li><a href="/listArticulos">Articulos</a></li>
									<li><a href="/configuracion">Configuración</a></li>
								</ul>
							</li>
						</ul>

					</div>
				</div>
@show
@section('container')
@show
@section('footer')
			<!--Modal para desplegar todos los mensajes del sistema(alertas de confirmación)-->

			<div class="modal fade" tabindex="-1" role="dialog" id="dlgMensaje" data-backdrop="static" data-keyboard="false">
			  <input type="hidden" name="_token"  id="txttoken" value="{{ csrf_token() }}"></input>
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="dlgMensajeTitle"></h4>
			      </div>
			      <div class="modal-body">
				        <h3 id="dlgMensajebody"></h3>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			        <button type="submit" class="btn btn-primary" data-dismiss="modal"	 >Aceptar</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
				
				<script src="assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
				<script src="assets/js/helpform.js" type="text/javascript"></script>
				<script src="assets/js/angular.min.js" type="text/javascript"></script>
				<script src="assets/boostrap/js/bootstrap.min.js" type="text/javascript"></script>
			</body>
		</html>
@show