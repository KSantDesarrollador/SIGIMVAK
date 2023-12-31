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
				CRUD-USUARIOS
			</p>
		</div>
	</section>
	<div class="full-width divider-menu-h"></div>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__panel is-active" id="KsvmListaUsuario">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<!-- Formulario de busqueda -->
					<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
							<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarUsu">
								<i class="zmdi zmdi-search"></i>
							</label>
							<div class="mdl-textfield__expandable-holder">
								<input class="mdl-textfield__input" type="text" id="KsvmBuscarUsu" name="KsvmBuscarUsu">
								<label class="mdl-textfield__label"></label>
							</div>
							<div class="mdl-textfield--expandable navBar-options-list">
								<a class="btn btn-sm btn-success mdl-shadow--8dp"
									href="<?php echo KsvmServUrl;?>Reportes/KsvmUsuariosPdf.php" target="_blank"><i
										class="zmdi zmdi-file">&nbsp;PDF</i></a>
								<a href="#KsvmNuevoUsuario" id="btn-input"
									class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
										class="zmdi zmdi-plus-circle"></i></a>
							</div>
						</div>
						<div class="RespuestaAjax"></div>
					</form>

					<!-- Método para mostrar la lista de Usuarios -->
					<?php
                    require_once "./Controladores/KsvmUsuarioControlador.php";
					$KsvmIniUsu = new KsvmUsuarioControlador();

					if (isset($_POST['KsvmBuscarUsu'])) {

						$_SESSION['KsvmBuscarUsu'] = $_POST['KsvmBuscarUsu'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniUsu -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, $_SESSION['KsvmBuscarUsu']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniUsu -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
		  $KsvmDataDetail = $KsvmIniUsu->__KsvmEditarUsuarioControlador($KsvmPagina[2]);

		  if ($KsvmDataDetail->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataDetail->fetch();

			  if ($KsvmLlenarForm['EpoNomEmp'] == "") {
				  $KsvmEmpleado = "Usuario Invitado";
			  } else {
				  $KsvmEmpleado = $KsvmLlenarForm['EpoNomEmp'];
			  }
			   
			
			  $KsvmEstado = "";
			  if ($KsvmLlenarForm['UsrEstUsu'] == 'A') {
				$KsvmEstado = "Activo";
			  }else {
				$KsvmEstado = "Inactivo";
			  }
			  
	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormUsuario").trigger("reset");
				$(".modal-title").text("Detalles Usuario");
				$("#KsvmDetallesUsuario").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles del Usuario -->

		<div class="modal fade" id="KsvmDetallesUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header ">
						<button class="close close-edit" type="button" data-dismiss="modal" aria-hidden="true"
							id="btnExitUsrCrud">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
						<form method="POST" action="">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<label class="mdl-textfield"><img
												src="data:image/jpg;base64,<?php echo base64_encode($KsvmLlenarForm['UsrImgUsu']);?>"
												height="230px" width="60%"></label>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>Empleado : </strong>&nbsp;
											&nbsp;<?php echo $KsvmEmpleado;?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--7-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>Rol : </strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['RrlNomRol'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Teléfono : </strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['UsrTelfUsu'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Email : </strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['UsrEmailUsu'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Usuario : </strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['UsrNomUsu'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Contraseña : </strong>&nbsp;
											&nbsp;??????????</div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Estado : </strong>&nbsp;
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
		<script type="text/javascript">
			$(document).ready(function () {
				$('#KsvmBtnExit').on('click', function () {
					window.location.href = "localhost:90/SIGIMVAK/KsvmUsuariosCrud/1/";
				});

			}):
		</script>
		<?php } }?>

		<!-- Formulario para ingresar un nuevo Usuario -->

		<div class="mdl-tabs__panel" id="KsvmNuevoUsuario">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<div class="" style="float:right;">
						<a href="<?php echo KsvmServUrl;?>KsvmUsuariosCrud/1/" id="btn-input"
							class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
								class="zmdi zmdi-arrow-left"></i></a>
					</div>
					<br><br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nuevo Usuario
						</div>
						<div class="full-width panel-content">
							<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmUsuarioAjax.php"
								method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormUsuario">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmRrlId" id="KsvmDato1"
												style="width:100%;">
												<option value="" selected="">Seleccione Rol</option>
												<?php require_once "./Controladores/KsvmRolControlador.php";
													$KsvmSelRol = new KsvmRolControlador();
													echo $KsvmSelRol->__KsvmSeleccionarRol();
													?>
											</select>
											<span id="KsvmError1" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="tel" name="KsvmTelf"
												pattern="[0-9()]{7,10}" id="KsvmDato2">
											<label class="mdl-textfield__label" for="KsvmDato2">Teléfono</label>
											<span class="mdl-textfield__error"> Teléfono Inválido</span>
											<span id="KsvmError2" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="email" name="KsvmEmail"
												pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
												id="KsvmDato3">
											<label class="mdl-textfield__label" for="KsvmDato3">E-mail</label>
											<span class="mdl-textfield__error">E-mail Inválido</span>
											<span id="KsvmError3" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="">
											<input class="" type="file" name="KsvmImgUsu"
												id="KsvmImgUsu">
											<label class="mdl-textfield" for="KsvmImgUsu"><img
													src="<?php echo KsvmServUrl;?>Vistas/assets/img/avatar-male.png"
													height="35px" width="35px">&nbsp;Agregar Foto</label>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmNomUsu"
												pattern="^([A-Z]+[0-9]{0,3}){5,12}$" id="KsvmDato4">
											<label class="mdl-textfield__label" for="KsvmDato4">Usuario</label>
											<span class="mdl-textfield__error">Usuario Inválido</span>
											<span id="KsvmError4" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="password" name="KsvmContra"
												pattern="[A-Za-z0-9!?-]{8,16}" id="KsvmDato5">
											<label class="mdl-textfield__label" for="KsvmDato5">Contraseña</label>
											<span class="mdl-textfield__error">Contraseña Inválida</span>
											<span id="KsvmError5" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="password" name="KsvmConContra"
												pattern="[A-Za-z0-9!?-]{8,16}" id="KsvmDato6">
											<label class="mdl-textfield__label" for="KsvmDato6">Confirmar
												Contraseña</label>
											<span class="mdl-textfield__error">Contraseña Inválida</span>
											<span id="KsvmError6" class="ValForm"><i
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
								<div class="mdl-tooltip" for="btnSave">Agregar Usuario</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>