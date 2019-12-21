<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<?php
   if ($_SESSION['KsvmRolNom-SIGIM'] != "Administrador") {
      echo $CerrarSesion->__KsvmMatarSesion();
   }
 ?>

<body>
	<!-- pageContent -->
	<section class="full-width pageContent">
		<section class="full-width header-well">
			<div class="full-width header-well-icon">
				<i class="zmdi zmdi-folder-star"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					CRUD-PRIVILEGIOS
				</p>
			</div>
		</section>
		<div class="full-width divider-menu-h"></div>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__panel is-active" id="KsvmListaMenuxRol">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
						<div class="">
							<!-- Formulario de busqueda -->
							<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
									<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarMxRol">
										<i class="zmdi zmdi-search"></i>
									</label>
									<div class="mdl-textfield__expandable-holder">
										<input class="mdl-textfield__input" type="text" id="KsvmBuscarMxRol"
											name="KsvmBuscarMxRol">
										<label class="mdl-textfield__label"></label>
									</div>
									<div class="mdl-textfield--expandable navBar-options-list">
										<a class="btn btn-sm btn-success mdl-shadow--8dp"
											href="<?php echo KsvmServUrl;?>Reportes/KsvmMenuXRolPdf.php"
											target="_blank"><i class="zmdi zmdi-file">&nbsp;PDF</i></a>
										<a href="#KsvmNuevoMenuxRol" id="btn-input"
											class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
												class="zmdi zmdi-plus-circle"></i></a>
									</div>
								</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>

						<!-- Método para mostrar la lista de MenuxRols -->
						<?php
                    require_once "./Controladores/KsvmMenuxRolControlador.php";
					$KsvmIniMxRol = new KsvmMenuxRolControlador();

					if (isset($_POST['KsvmBuscarMxRol'])) {

						$_SESSION['KsvmBuscarMxRol'] = $_POST['KsvmBuscarMxRol'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniMxRol -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, $_SESSION['KsvmBuscarMxRol']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniMxRol -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
		  $KsvmDataEdit = $KsvmIniMxRol->__KsvmEditarMenuxRolControlador($KsvmPagina[2]);

		  if ($KsvmDataEdit->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataEdit->fetch();
			  
	    ?>
			<script>
				window.onload = function () {

					$("#KsvmFormMxRol").trigger("reset");
					$(".modal-title").text("Detalles Privilegio");
					$("#KsvmDetallesMenuxRol").modal({
						show: true
					});
				}
			</script>

			<!-- Formulario de Detalles del MenuxRol -->

			<div class="modal fade" id="KsvmDetallesMenuxRol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content ">
						<div class="modal-header">
							<button class="close close-edit" type="button" data-dismiss="modal"
								aria-hidden="true">&times;</button>
							<h5 class="modal-title text-center"></h5>
						</div>
						<div class="modal-body">
							<form action="" method="POST">
								<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Rol :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['RrlNomRol'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Menú Asignado :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['MnuNomMen'];?></div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<?php } }?>

			<!-- Formulario para ingresar un nuevo MenuxRol -->

			<div class="mdl-tabs__panel" id="KsvmNuevoMenuxRol">
				<div class="mdl-grid">
					<div
						class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
						<div class="" style="float:right;">
							<a href="<?php echo KsvmServUrl;?>KsvmMenuXRolCrud/1/" id="btn-input"
								class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
									class="zmdi zmdi-arrow-left"></i></a>
						</div>
						<br><br>
						<div class="full-width panel mdl-shadow--8dp">
							<div class="full-width modal-header-input text-center">
								Nuevo Privilegio
							</div>
							<div class="full-width panel-content">
								<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmMenuXRolAjax.php"
									method="POST" class="FormularioAjax" autocomplete="off"
									enctype="multipart/form-data" id="KsvmFormMenuxRol">

									<div class="mdl-grid">
										<div
											class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" name="KsvmRrlId">
													<option value="" disabled="" selected="">Seleccione Rol</option>
													<?php require_once "./Controladores/KsvmRolControlador.php";
													$KsvmSelRol = new KsvmRolControlador();
													echo $KsvmSelRol->__KsvmSeleccionarRol();
													?>
												</select>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" name="KsvmMnuId">
													<option value="" disabled="" selected="">Seleccione Menú</option>
													<?php require_once "./Controladores/KsvmMenuControlador.php";
													$KsvmSelMed = new KsvmMenuControlador();
													echo $KsvmSelMed->__KsvmSeleccionarMenu();
													?>
												</select>
											</div>
										</div>
									</div>
									<p class="text-center">
										<button type="submit"
											class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
											id="btn-NuevoMenuxRol">
											<i class="zmdi zmdi-save">&nbsp;Guardar</i>
										</button>
									</p>
									<div class="mdl-tooltip" for="btn-NuevoMenuxRol">Agregar MenuxRol</div>
									<div class="RespuestaAjax"></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>