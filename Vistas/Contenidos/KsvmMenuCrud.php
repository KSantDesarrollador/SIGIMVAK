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
				CRUD-MENÚ
			</p>
		</div>
	</section>
	<div class="full-width divider-menu-h"></div>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__panel is-active" id="KsvmListaMenu">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<!-- Formulario de busqueda -->
					<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
							<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarMenu">
								<i class="zmdi zmdi-search"></i>
							</label>
							<div class="mdl-textfield__expandable-holder">
								<input class="mdl-textfield__input" type="text" id="KsvmBuscarMenu"
									name="KsvmBuscarMenu">
								<label class="mdl-textfield__label"></label>
							</div>
							<div class="mdl-textfield--expandable navBar-options-list">
								<a class="btn btn-sm btn-success mdl-shadow--8dp"
									href="<?php echo KsvmServUrl;?>Reportes/KsvmMenuPdf.php" target="_blank"><i
										class="zmdi zmdi-file">&nbsp;PDF</i></a>
								<a href="#KsvmNuevoMenu" id="btn-input"
									class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
										class="zmdi zmdi-plus-circle"></i></a>
							</div>
						</div>
						<div class="RespuestaAjax"></div>
					</form>

					<!-- Método para mostrar la lista de Menus -->
					<?php
                    require_once "./Controladores/KsvmMenuControlador.php";
					$KsvmIniMen = new KsvmMenuControlador();

					if (isset($_POST['KsvmBuscarMenu'])) {

						$_SESSION['KsvmBuscarMenu'] = $_POST['KsvmBuscarMenu'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniMen -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, $_SESSION['KsvmBuscarMenu']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniMen -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
		  $KsvmDataDetail = $KsvmIniMen->__KsvmEditarMenuControlador($KsvmPagina[2]);

		  if ($KsvmDataDetail->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataDetail->fetch();

			  if ($KsvmLlenarForm['MnuUrlMen'] == "0") {
				$KsvmUrl = "Sin Información";
			  }else{
				$KsvmUrl = $KsvmLlenarForm['MnuUrlMen'];
			  }
			
			  $KsvmEstado = "";
			  if ($KsvmLlenarForm['MnuEstMen'] == 'A') {
				$KsvmEstado = "Activo";
			  }else {
				$KsvmEstado = "Inactivo";
			  }
			  
			$KsvmJerq = $KsvmLlenarForm['MnuJerqMen'];
			
		    $KsvmMostrarJerq = new KsvmMenuModelo();
			$KsvmMenu = $KsvmMostrarJerq -> __KsvmMostrarJerarquiaModelo($KsvmJerq);

			if ($KsvmMenu->rowCount() == 1) {
				$KsvmJerarquia = $KsvmMenu->fetch();
				$KsvmNomJerq = $KsvmJerarquia['MnuNomMen'];
			}else {
				$KsvmNomJerq = "Es Menú padre";
			}

	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormMenu").trigger("reset");
				$(".modal-title").text("Detalles Menu");
				$("#KsvmDetallesMenu").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles del Menu -->

		<div class="modal fade" id="KsvmDetallesMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header ">
						<button class="close close-edit" type="button" data-dismiss="modal" aria-hidden="true"
							id="btnExitMenCrud">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
						<form method="POST" action="">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>Jerarquía :</strong>&nbsp;
											&nbsp;<?php echo $KsvmNomJerq;?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Nombre :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['MnuNomMen'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Nivel :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['MnuNivelMen'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Icono :</strong>&nbsp; &nbsp;<i
												style="font-size:25px;"
												class="<?php echo $KsvmLlenarForm['MnuIconMen'];?>"></i></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Url :</strong>&nbsp;
											&nbsp;<?php echo $KsvmUrl;?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Leyenda :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['MnuLeyendMen'];?></div>
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

		<!-- Formulario para ingresar un nuevo Menu -->

		<div class="mdl-tabs__panel" id="KsvmNuevoMenu">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<div class="" style="float:right;">
						<a href="<?php echo KsvmServUrl;?>KsvmMenuCrud/1/" id="btn-input"
							class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
								class="zmdi zmdi-arrow-left"></i></a>
					</div>
					<br><br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nuevo Menu
						</div>
						<div class="full-width panel-content">
							<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmMenuAjax.php"
								method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormMenu">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmNivelMen" id="KsvmDato1">
												<option value="" selected="" disabled>Seleccione Nivel</option>
												<option value="0">Nivel 0</option>
												<option value="1">Nivel 1</option>
											</select>
											<span id="KsvmError1" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmJerqMen">
												<option value="" selected="">Seleccione Jerarquía</option>
												<?php require_once "./Controladores/KsvmMenuControlador.php";
													$KsvmSelUndMed = new KsvmMenuControlador();
													echo $KsvmSelUndMed->__KsvmSeleccionarMenu();
													?>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmNomMen"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato2">
											<label class="mdl-textfield__label" for="KsvmDato2">Nombre</label>
											<span class="mdl-textfield__error">Nombre Inválido</span>
											<span id="KsvmError2" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmIconMen"
												id="KsvmDato3">
											<label class="mdl-textfield__label" for="KsvmDato3">Ícono</label>
											<span class="mdl-textfield__error">Ícono Inválido</span>
											<span id="KsvmError3" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmUrlMen"
												id="KsvmUrlMen">
											<label class="mdl-textfield__label" for="KsvmUrlMen">Url</label>
											<span class="mdl-textfield__error">Url Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmLeyendMen"
												id="KsvmDato4">
											<label class="mdl-textfield__label" for="KsvmDato4">Leyenda</label>
											<span class="mdl-textfield__error">Leyenda Inválida</span>
											<span id="KsvmError4" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
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
								<div class="mdl-tooltip" for="btnSave">Agregar Menu</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>