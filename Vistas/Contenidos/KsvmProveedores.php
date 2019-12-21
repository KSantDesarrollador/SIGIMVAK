<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<!-- pageContent -->
<section class="full-width pageContent">
	<section class="full-width header-well">
		<div class="full-width header-well-icon">
			<i class="zmdi zmdi-truck"></i>
		</div>
		<div class="full-width header-well-text">
			<p class="text-condensedLight">
				PROVEEDORES
			</p>
		</div>
	</section>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__tab-bar">
			<a href="#KsvmListaProveedor" class="mdl-tabs__tab is-active">LISTA DE PROVEEDORES</a>
			<a href="#KsvmNuevoProveedor" class="mdl-tabs__tab">NUEVO PROVEEDOR</a>
		</div>

		<!-- Formulario para ingresar un nuevo Proveedor -->

		<div class="mdl-tabs__panel" id="KsvmNuevoProveedor">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nuevo Proveedor
						</div>
						<div class="full-width panel-content">
							<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmProveedorAjax.php"
								method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormProveedor">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmIdPais"
												id="KsvmCargaListaPais">
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" id="KsvmCargaListaCanton">
												<option value="" disabled="" selected="">Seleccione Cantón</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmTipProv">
												<option value="" selected="" disabled>Seleccione Tipo de Proveedor
												</option>
												<option value="N">Persona Natural</option>
												<option value="J">Persona Juridica</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmRazSocProv"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmRazSocProv">
											<label class="mdl-textfield__label" for="KsvmRazSocProv">Razón
												Social</label>
											<span class="mdl-textfield__error">Razón Social Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDirProv"
												id="KsvmDirProv">
											<label class="mdl-textfield__label" for="KsvmDirProv">Dirección</label>
											<span class="mdl-textfield__error">Dirección Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmPerContProv"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmPerContProv">
											<label class="mdl-textfield__label" for="KsvmPerContProv">Persona de
												Contacto</label>
											<span class="mdl-textfield__error">Nombre Inválido</span>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" id="KsvmCargaListaProvincia">
												<option value="" disabled="" selected="">Seleccione Provincia</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmIdParroquia"
												id="KsvmCargaListaParroquia">
												<option value="" disabled="" selected="">Seleccione Parroquia</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmIdentProv"
												pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmIdentProv">
											<label class="mdl-textfield__label" for="KsvmIdentProv">Identidad</label>
											<span class="mdl-textfield__error">Identidad Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="telf" name="KsvmTelfProv"
												pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmTelfProv">
											<label class="mdl-textfield__label" for="KsvmTelfProv">Teléfono</label>
											<span class="mdl-textfield__error">Teléfono Inválido</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="email" name="KsvmEmailProv"
												id="KsvmEmailProv">
											<label class="mdl-textfield__label" for="KsvmEmailProv">Email</label>
											<span class="mdl-textfield__error">Email Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmCarContProv"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmCarContProv">
											<label class="mdl-textfield__label" for="KsvmCarContProv">Cargo Persona
												Contacto</label>
											<span class="mdl-textfield__error">Descripción Inválida</span>
										</div>
									</div>
								</div>
								<br>
								<p class="text-center">
									<button type="submit"
										class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
										id="btn-NuevoProveedor">
										<i class="zmdi zmdi-save">&nbsp;Guardar</i>
									</button>
								</p>
								<div class="mdl-tooltip" for="btn-NuevoProveedor">Agregar Proveedor</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mdl-tabs__panel is-active" id="KsvmListaProveedor">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<!-- Formulario de busqueda -->
					<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
							<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarProv">
								<i class="zmdi zmdi-search"></i>
							</label>
							<div class="mdl-textfield__expandable-holder">
								<input class="mdl-textfield__input" type="text" id="KsvmBuscarProv"
									name="KsvmBuscarProv">
								<label class="mdl-textfield__label"></label>
							</div>
							<div class="mdl-textfield--expandable navBar-options-list">
								<a class="btn btn-sm btn-success mdl-shadow--8dp"
									href="<?php echo KsvmServUrl;?>Reportes/KsvmProveedoresPdf.php" target="_blank"><i
										class="zmdi zmdi-file">&nbsp;PDF</i></a>
							</div>
						</div>
						<div class="RespuestaAjax"></div>
					</form>

					<!-- Método para mostrar la lista de Proveedors -->
					<?php
                    require_once "./Controladores/KsvmProveedorControlador.php";
					$KsvmIniProv = new KsvmProveedorControlador();

					if (isset($_POST['KsvmBuscarProv'])) {

						$_SESSION['KsvmBuscarProv'] = $_POST['KsvmBuscarProv'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniProv -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						1, $_SESSION['KsvmBuscarProv']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniProv -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
		  $KsvmDataDetail = $KsvmIniProv->__KsvmEditarProveedorControlador($KsvmPagina[2]);

		  if ($KsvmDataDetail->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataDetail->fetch();

			  if ($KsvmLlenarForm['PrcJerqProc'] == "") {

				$KsvmPais = $KsvmLlenarForm['PrcNomProc'];
				$KsvmProvincia = "Sin Información";
				$KsvmCanton = "Sin Información";
				$KsvmParroquia = "Sin Información";
			  }else{
			  
			  $KsvmParroquia = $KsvmLlenarForm['PrcNomProc'];

			  require_once "./Controladores/KsvmProcedenciaControlador.php";
				$KsvmSelProc = new KsvmProcedenciaControlador();

				$KsvmCbxCan = $KsvmSelProc->__KsvmSeleccionaProcedencia($KsvmLlenarForm['PrcJerqProc']);
				$KsvmCanton = $KsvmCbxCan['PrcNomProc'];		
				
				$KsvmCbxProv = $KsvmSelProc->__KsvmSeleccionaProcedencia($KsvmCbxCan['PrcJerqProc']);
				$KsvmProvincia = $KsvmCbxProv['PrcNomProc'];	

				$KsvmCbxPais = $KsvmSelProc->__KsvmSeleccionaProcedencia($KsvmCbxProv['PrcJerqProc']);
				$KsvmPais = $KsvmCbxPais['PrcNomProc'];
			  }

			  $KsvmEstado = "";
			  if ($KsvmLlenarForm['PvdEstProv'] == 'A') {
				$KsvmEstado = "Activo";
			  }else {
				$KsvmEstado = "Inactivo";
			  }
			  
	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormProveedor").trigger("reset");
				$(".modal-title").text("Detalles Proveedor");
				$("#KsvmDetallesProveedor").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles de la Proveedor -->

		<div class="modal fade" id="KsvmDetallesProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header ">
						<button class="close close-edit" type="button" data-dismiss="modal" aria-hidden="true"
							id="KsvmBtnExit">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
						<form method="POST" action="">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>País :</strong>&nbsp;
											&nbsp;<?php echo $KsvmPais;?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Cantón :</strong>&nbsp;
											&nbsp;<?php echo $KsvmCanton;?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Razon Social :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['PvdRazSocProv'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Teléfono :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['PvdTelfProv'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Dirección :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['PvdDirProv'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Estado :</strong>&nbsp;
											&nbsp;<?php echo $KsvmEstado;?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Provincia :</strong>&nbsp;
											&nbsp;<?php echo $KsvmProvincia;?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Parroquia :</strong>&nbsp;
											&nbsp;<?php echo $KsvmParroquia;?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Identificación :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['PvdIdentProv'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Email :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['PvdEmailProv'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Persona de Contacto :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['PvdPerContProv'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Cargo de Persona de Contacto
												:</strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['PvdCarContProv'];?>
										</div>
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
			$(document).ready(function () {
				$('#KsvmBtnExit').on('click', function () {
					window.location.href = "localhost:90/SIGIMVAK/KsvmProveedoresCrud/1/";
				});

			}):
		</script>
		<?php } }?>
	</div>
</section>