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
					CRUD-BODEGAS
				</p>
			</div>
		</section>
		<div class="full-width divider-menu-h"></div>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__panel is-active" id="KsvmListaBodega">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                         <!-- Formulario de busqueda -->
						<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
								<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarBod">
									<i class="zmdi zmdi-search"></i>
								</label>
								<div class="mdl-textfield__expandable-holder">
									<input class="mdl-textfield__input" type="text" id="KsvmBuscarBod"
										name="KsvmBuscarBod">
									<label class="mdl-textfield__label"></label>
								</div>
								<div class="mdl-textfield--expandable navBar-options-list">
									<a class="btn btn-sm btn-success mdl-shadow--8dp mdl-tabs__tab">PDF</a>
									<a href="#KsvmNuevoBodega" id="btn-input" 
										class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
											class="zmdi zmdi-plus-circle"></i></a>
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
						0, $_SESSION['KsvmBuscarBod']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniBod -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
						<button class="close close-edit" type="button" data-dismiss="modal"
							aria-hidden="true" id="KsvmBtnExit">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
					<form method="POST" action="">
						<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
						<div class="mdl-grid">
							<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
								<div class="mdl-textfield mdl-js-textfield">
									<div class="mdl-textfield__input"><strong>Und.Médica :</strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['UmdNomUdm'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Código :</strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['BdgCodBod'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Descripción :</strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['BdgDescBod'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Teléfono :</strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['BdgTelfBod'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Dirección :</strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['BdgDirBod'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Estado :</strong>&nbsp; &nbsp;<?php echo $KsvmEstado;?></div>
								</div>
							</div>
						</div>
						<br>
					</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript"> 
		 $(document).ready(function(){
          $('#KsvmBtnExit').on('click', function () {
			  window.location.href="localhost:90/SIGIMVAK/KsvmBodegasCrud/1/";
		  });

		 }):
		</script>
		<?php } }?>
		  
		<!-- Formulario para ingresar un nuevo Bodega -->

		<div class="mdl-tabs__panel" id="KsvmNuevoBodega">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<div class="" style="float:right;">
						<a href="<?php echo KsvmServUrl;?>KsvmBodegasCrud/1/" id="btn-input"
							class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
							class="zmdi zmdi-arrow-left"></i></a>
					</div>
					<br><br>
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
											<select class="mdl-textfield__input" name="KsvmUmdId">
												<option value="" disabled="" selected="">Seleccione Und.Médica</option>
												<?php require_once "./Controladores/KsvmUnidadMedicaControlador.php";
													$KsvmSelUndMed = new KsvmUnidadMedicaControlador();
													echo $KsvmSelUndMed->__KsvmSeleccionarUndMedica();
													?>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDescBod"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDescBod">
											<label class="mdl-textfield__label" for="KsvmDescBod">Descripción</label>
											<span class="mdl-textfield__error">Descripción Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="telf" name="KsvmTelfBod"
											    pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmTelfBod">
											<label class="mdl-textfield__label" for="KsvmTelfBod">Teléfono</label>
											<span class="mdl-textfield__error">Teléfono Inválido</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDirBod"
												id="KsvmDirBod">
											<label class="mdl-textfield__label" for="KsvmDirBod">Dirección</label>
											<span class="mdl-textfield__error">Dirección Inválida</span>
										</div>
									</div>
								</div>
								<br>
								<p class="text-center">
									<button type="submit"
										class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
										id="btn-NuevoBodega">
										<i class="zmdi zmdi-save">&nbsp;Guardar</i>
									</button>
								</p>
								<div class="mdl-tooltip" for="btn-NuevoBodega">Agregar Bodega</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
