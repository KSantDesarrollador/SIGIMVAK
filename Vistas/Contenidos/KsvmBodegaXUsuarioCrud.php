<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<?php
   if ($_SESSION['KsvmRolNom-SIGIM'] != "Administrador") {
      echo $CerrarSesion->__KsvmMatarSesion();
   }
 ?>

<!-- pageContent -->
<section class="full-width pageContent">
	<section class="full-width header-well">
		<div class="full-width header-well-icon">
			<i class="zmdi zmdi-folder-star"></i>
		</div>
		<div class="full-width header-well-text">
			<p class="text-condensedLight">
				CRUD-ASIGNA-BODEGA
			</p>
		</div>
	</section>
	<div class="full-width divider-menu-h"></div>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__panel is-active" id="KsvmListaBodegaXUsuario">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<!-- Formulario de busqueda -->
					<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
							<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarBodxUsu">
								<i class="zmdi zmdi-search"></i>
							</label>
							<div class="mdl-textfield__expandable-holder">
								<input class="mdl-textfield__input" type="text" id="KsvmBuscarBodxUsu"
									name="KsvmBuscarBodxUsu">
								<label class="mdl-textfield__label"></label>
							</div>
							<div class="mdl-textfield--expandable navBar-options-list">
								<a class="btn btn-sm btn-success mdl-shadow--8dp"
									href="<?php echo KsvmServUrl;?>Reportes/KsvmBodegaXUsuarioPdf.php"
									target="_blank"><i class="zmdi zmdi-file">&nbsp;PDF</i></a>
								<a href="#KsvmNuevoBodegaXUsuario" id="btn-input"
									class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
										class="zmdi zmdi-plus-circle"></i></a>
							</div>
						</div>
						<div class="RespuestaAjax"></div>
					</form>

					<!-- Método para mostrar la lista de BodegaXUsuarios -->
					<?php
                    require_once "./Controladores/KsvmBodxUsuControlador.php";
					$KsvmIniBodUsu = new KsvmBodxUsuControlador();

					if (isset($_POST['KsvmBuscarBodxUsu'])) {

						$_SESSION['KsvmBuscarBodxUsu'] = $_POST['KsvmBuscarBodxUsu'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniBodUsu -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, $_SESSION['KsvmBuscarBodxUsu']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniBodUsu -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, "");
				       }
				?>

				</div>
			</div>
		</div>

		<!-- Método para cargar datos en el formulario -->
		<?php 
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[2] != "") {
		  $KsvmDataDetail = $KsvmIniBodUsu->__KsvmEditarBodxUsuControlador($KsvmPagina[2]);

		  if ($KsvmDataDetail->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataDetail->fetch();
			  
	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormBodegaXUsuario").trigger("reset");
				$(".modal-title").text("Detalles Asignación Bodega");
				$("#KsvmDetallesBodegaXUsuario").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles del BodegaXUsuario -->

		<div class="modal fade" id="KsvmDetallesBodegaXUsuario" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header ">
						<button class="close close-edit" type="button" data-dismiss="modal" aria-hidden="true"
							id="btnExitBduCrud">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
						<form method="POST" action="">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>Usuario :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['UsrNomUsu'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Bodega :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['BdgDescBod'];?></div>
									</div>
								</div>
							</div>
							<br>
					</div>
					</form>
				</div>
			</div>
		</div>
		<?php } }?>

		<!-- Formulario para ingresar un nuevo BodegaXUsuario -->

		<div class="mdl-tabs__panel" id="KsvmNuevoBodegaXUsuario">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<div class="" style="float:right;">
						<a href="<?php echo KsvmServUrl;?>KsvmBodegaXUsuarioCrud/1/" id="btn-input"
							class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
								class="zmdi zmdi-arrow-left"></i></a>
					</div>
					<br><br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Asignar Bodega
						</div>
						<div class="full-width panel-content">
							<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmBodegaXUsuarioAjax.php"
								method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormBodegaXUsuario">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmUsrId" id="KsvmDato1">
												<option value="" selected="">Seleccione Usuario</option>
												<?php require_once "./Controladores/KsvmUsuarioControlador.php";
                                                    $KsvmSelUsu = new KsvmUsuarioControlador();
                                                    echo $KsvmSelUsu->__KsvmSeleccionarUsuario();
                                                    ?>
											</select>
											<span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmBdgId" id="KsvmDato2">
												<option value="" selected="">Seleccione Bodega</option>
												<?php require_once "./Controladores/KsvmBodegaControlador.php";
                                                    $KsvmSelBod = new KsvmBodegaControlador();
                                                    echo $KsvmSelBod->__KsvmSeleccionarBodega();
                                                    ?>
											</select>
											<span id="KsvmError2" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
										</div>
									</div>
								</div>
								<br>
								<p class="text-center">
									<button type="submit"
										class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
										id="btnSave">
										<i class="zmdi zmdi-save">&nbsp;Guardar</i>
									</button>
								</p>
								<div class="mdl-tooltip" for="btnSave">Agregar BodegaXUsuario</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>