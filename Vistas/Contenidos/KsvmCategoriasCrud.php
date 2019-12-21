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
				CRUD-CATEGORÍAS
			</p>
		</div>
	</section>
	<div class="full-width divider-menu-h"></div>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__panel is-active" id="KsvmListaCategoria">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<!-- Formulario de busqueda -->
					<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
							<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarCat">
								<i class="zmdi zmdi-search"></i>
							</label>
							<div class="mdl-textfield__expandable-holder">
								<input class="mdl-textfield__input" type="text" id="KsvmBuscarCat" name="KsvmBuscarCat">
								<label class="mdl-textfield__label"></label>
							</div>
							<div class="mdl-textfield--expandable navBar-options-list">
								<a class="btn btn-sm btn-success mdl-shadow--8dp"
									href="<?php echo KsvmServUrl;?>Reportes/KsvmCategoriasPdf.php" target="_blank"><i
										class="zmdi zmdi-file">&nbsp;PDF</i></a>
								<a href="#KsvmNuevoCategoria" id="btn-input"
									class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
										class="zmdi zmdi-plus-circle"></i></a>
							</div>
						</div>
						<div class="RespuestaAjax"></div>
					</form>

					<!-- Método para mostrar la lista de Categorias -->
					<?php
                    require_once "./Controladores/KsvmCategoriaControlador.php";
					$KsvmIniCat = new KsvmCategoriaControlador();

					if (isset($_POST['KsvmBuscarCat'])) {

						$_SESSION['KsvmBuscarCat'] = $_POST['KsvmBuscarCat'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniCat -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, $_SESSION['KsvmBuscarCat']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniCat -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
		  $KsvmDataDetail = $KsvmIniCat->__KsvmEditarCategoriaControlador($KsvmPagina[2]);

		  if ($KsvmDataDetail->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataDetail->fetch();
			  
			  $KsvmEstado = "";
				if ($KsvmLlenarForm['CtgEstCat'] == 'A') {
				$KsvmEstado = "Activo";
				}else {
				$KsvmEstado = "Inactivo";
				}
		
	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormCategoria").trigger("reset");
				$(".modal-title").text("Detalles Categoria");
				$("#KsvmDetallesCategoria").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles del Categoria -->

		<div class="modal fade" id="KsvmDetallesCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header ">
						<button class="close close-edit" type="button" data-dismiss="modal" aria-hidden="true"
							id="btnExitCatCrud">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
						<form method="POST" action="">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>Nombre :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['CtgNomCat'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Color :</strong>&nbsp; &nbsp;<button
												class="btn btn-md"
												style="border-color:#000; background-color:<?php echo $KsvmLlenarForm['CtgColorCat'];?>;"></button>
										</div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Estado :</strong>&nbsp;
											&nbsp;<?php echo $KsvmEstado;?></div>
									</div>
								</div>
							</div>
							<br>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php } }?>

		<!-- Formulario para ingresar un nuevo Categoria -->

		<div class="mdl-tabs__panel" id="KsvmNuevoCategoria">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<div class="" style="float:right;">
						<a href="<?php echo KsvmServUrl;?>KsvmCategoriasCrud/1/" id="btn-input"
							class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
								class="zmdi zmdi-arrow-left"></i></a>
					</div>
					<br><br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nueva Categoria
						</div>
						<div class="full-width panel-content">
							<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmCategoriaAjax.php"
								method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormCategoria">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmNomCat"
												pattern="-?[A-Za-záéíóúÁÉÍÓÚñ ]*(\.[0-9]+)?" id="KsvmDato1">
											<label class="mdl-textfield__label" for="KsvmDato1">Nombre</label>
											<span class="mdl-textfield__error">Nombre Inválido</span>
											<span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="color" name="KsvmColorCat"
												id="KsvmDato2">
											<label class="mdl-textfield__label" for="KsvmDato2">Color</label>
											<span class="mdl-textfield__error">Color Inválida</span>
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
								<div class="mdl-tooltip" for="btnSave">Agregar Categoría</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>