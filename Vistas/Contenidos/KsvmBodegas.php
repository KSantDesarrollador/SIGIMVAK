<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<!-- pageContent -->
<section class="full-width pageContent">
	<section class="full-width header-well">
		<div class="full-width header-well-icon">
			<i class="zmdi zmdi-store"></i>
		</div>
		<div class="full-width header-well-text">
			<p class="text-condensedLight">
				BODEGAS
			</p>
		</div>
	</section>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__tab-bar">
			<a href="#KsvmListaBodegas" class="mdl-tabs__tab is-active">LISTA DE BODEGAS</a>
			<a href="#KsvmNuevaBodega" class="mdl-tabs__tab">NUEVA BODEGA</a>
		</div>

		<!-- Formulario para ingresar un nuevo Bodega -->

		<div class="mdl-tabs__panel" id="KsvmNuevaBodega">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nueva Bodega
						</div>
						<div class="full-width panel-content">
							<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmBodegaAjax.php"
								method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormBodega">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmUmdId" id="KsvmDato1" style="width:98%;">
												<option value="" selected="">Seleccione Und.Médica</option>
												<?php require_once "./Controladores/KsvmUnidadMedicaControlador.php";
													$KsvmSelUndMed = new KsvmUnidadMedicaControlador();
													echo $KsvmSelUndMed->__KsvmSeleccionarUndMedica();
													?>
											</select>
											<span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDescBod"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato2">
											<label class="mdl-textfield__label" for="KsvmDato2">Descripción</label>
											<span class="mdl-textfield__error">Descripción Inválida</span>
											<span id="KsvmError2" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="telf" name="KsvmTelfBod"
												pattern="[0-9()]{7,10}" id="KsvmDato3">
											<label class="mdl-textfield__label" for="KsvmDato3">Teléfono</label>
											<span class="mdl-textfield__error">Teléfono Inválido</span>
											<span id="KsvmError3" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDirBod"
											    pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ-]*(\.[0-9]+)?" id="KsvmDato4">
											<label class="mdl-textfield__label" for="KsvmDato4">Dirección</label>
											<span class="mdl-textfield__error">Dirección Inválida</span>
											<span id="KsvmError4" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
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
								<div class="mdl-tooltip" for="btnSave">Agregar Bodega</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mdl-tabs__panel is-active" id="KsvmListaBodegas">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<!-- Formulario de busqueda -->
					<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
							<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarBod">
								<i class="zmdi zmdi-search"></i>
							</label>
							<div class="mdl-textfield__expandable-holder">
								<input class="mdl-textfield__input" type="text" id="KsvmBuscarBod" name="KsvmBuscarBod">
								<label class="mdl-textfield__label"></label>
							</div>
							<div class="mdl-textfield--expandable navBar-options-list">
								<a class="btn btn-sm btn-success mdl-shadow--8dp"
									href="<?php echo KsvmServUrl;?>Reportes/KsvmBodegasPdf.php" target="_blank"><i
										class="zmdi zmdi-file">&nbsp;PDF</i></a>
							</div>
						</div>
						<div class="RespuestaAjax"></div>
					</form>

					<!-- Método para mostrar la lista de Bodegas -->
					<?php
                    require_once "./Controladores/KsvmBodegaControlador.php";
					$KsvmIniBod = new KsvmBodegaControlador();

					if (isset($_POST['KsvmBuscarBod'])) {

						$_SESSION['KsvmBuscarBod'] = $_POST['KsvmBuscarBod'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniBod -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						1, $_SESSION['KsvmBuscarBod']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniBod -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						1, "");
				       }
				?>

				</div>
			</div>
		</div>

		<!-- Método para cargar datos en el formulario -->
		<?php 
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[2] != "") {
		  $KsvmDataDetail = $KsvmIniBod->__KsvmEditarBodegaControlador($KsvmPagina[2]);

		  if ($KsvmDataDetail->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataDetail->fetch();
			
			  $KsvmEstado = "";
			  if ($KsvmLlenarForm['BdgEstBod'] == 'A') {
				$KsvmEstado = "Activo";
			  }else {
				$KsvmEstado = "Inactivo";
			  }
			  
	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormBodega").trigger("reset");
				$(".modal-title").text("Detalles Bodega");
				$("#KsvmDetallesBodega").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles de la Bodega -->

		<div class="modal fade" id="KsvmDetallesBodega" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header ">
						<button class="close close-edit" type="button" data-dismiss="modal" aria-hidden="true"
							id="btnExitBod">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
						<form method="POST" action="">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>Und.Médica :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['UmdNomUdm'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Código :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['BdgCodBod'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Descripción :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['BdgDescBod'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Teléfono :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['BdgTelfBod'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Dirección :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['BdgDirBod'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Estado :</strong>&nbsp;
											&nbsp;<?php echo $KsvmEstado;?></div>
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
	</div>
</section>