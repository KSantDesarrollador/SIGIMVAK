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
				CRUD-PROVEEDORES
			</p>
		</div>
	</section>
	<div class="full-width divider-menu-h"></div>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
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
								<a href="#KsvmNuevoProveedor" id="btn-input"
									class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
										class="zmdi zmdi-plus-circle"></i></a>
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
						0, $_SESSION['KsvmBuscarProv']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniProv -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
							id="btnExitProvCrud">&times;</button>
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

		<!-- Formulario para ingresar un nuevo Proveedor -->

		<div class="mdl-tabs__panel" id="KsvmNuevoProveedor">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<div class="" style="float:right;">
						<a href="<?php echo KsvmServUrl;?>KsvmProveedoresCrud/1/" id="btn-input"
							class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
								class="zmdi zmdi-arrow-left"></i></a>
					</div>
					<br><br>
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
											<select class="ksvmSelectDin" name="KsvmIdPais" style="width:100%;"
												id="KsvmCargaListaPais" required>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" id="KsvmCargaListaCanton" style="width:100%;">
												<option value="" disabled="" selected="">Seleccione Cantón</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmTipProv" id="KsvmDato1"
												style="width:100%;">
												<option value="" selected="">Seleccione Tipo de Proveedor
												</option>
												<option value="N">Persona Natural</option>
												<option value="J">Persona Juridica</option>
											</select>
											<span id="KsvmError1" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmRazSocProv"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ. ]*(\.[0-9]+)?" id="KsvmDato2">
											<label class="mdl-textfield__label" for="KsvmDato2">Razón
												Social</label>
											<span class="mdl-textfield__error">Razón Social Inválida</span>
											<span id="KsvmError2" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDirProv"
												pattern="-?[A-Za-z0-9-áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato3">
											<label class="mdl-textfield__label" for="KsvmDato3">Dirección</label>
											<span class="mdl-textfield__error">Dirección Inválida</span>
											<span id="KsvmError3" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmPerContProv"
												pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato4">
											<label class="mdl-textfield__label" for="KsvmDato4">Persona de
												Contacto</label>
											<span class="mdl-textfield__error">Nombre Inválido</span>
											<span id="KsvmError4" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" id="KsvmCargaListaProvincia"
												style="width:100%;">
												<option value="" disabled="" selected="">Seleccione Provincia</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmIdParroquia" style="width:100%;"
												id="KsvmCargaListaParroquia">
												<option value="" disabled="" selected="">Seleccione Parroquia</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmIdentProv"
												pattern="[0-9]{10,13}" id="ident" onkeyup="IdValido()">
											<label class="mdl-textfield__label" for="ident">Identidad</label>
											<span id="KsvmErrorIdent" class=""></span>
											<span id="KsvmError5" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="telf" name="KsvmTelfProv"
												pattern="[0-9()]{7,10}" id="KsvmDato6">
											<label class="mdl-textfield__label" for="KsvmDato6">Teléfono</label>
											<span class="mdl-textfield__error">Teléfono Inválido</span>
											<span id="KsvmError6" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="email" name="KsvmEmailProv"
												pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
												id="KsvmDato7">
											<label class="mdl-textfield__label" for="KsvmDato7">Email</label>
											<span class="mdl-textfield__error">Email Inválida</span>
											<span id="KsvmError7" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmCarContProv"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato8">
											<label class="mdl-textfield__label" for="KsvmDato8">Cargo Persona
												Contacto</label>
											<span class="mdl-textfield__error">Descripción Inválida</span>
											<span id="KsvmError8" class="ValForm"><i
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
								<div class="mdl-tooltip" for="btnSave">Agregar Proveedor</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>