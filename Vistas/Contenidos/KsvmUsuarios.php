<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

	<!-- pageContent -->
	<section class="full-width pageContent">
		<section class="full-width header-well">
			<div class="full-width header-well-icon">
				<i class="zmdi zmdi-account"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					USUARIOS
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
    <div class="mdl-tabs__tab-bar">
	            <a href="#KsvmListaUsuario" class="mdl-tabs__tab is-active">LISTA DE USUARIOS</a> 
	            <a href="#KsvmNuevoUsuario" class="mdl-tabs__tab">NUEVO USUARIO</a>
			</div>
		  
		<!-- Formulario para ingresar un nuevo Usuario -->

		<div class="mdl-tabs__panel" id="KsvmNuevoUsuario">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<!-- <div class="" style="float:right;">
						<a href="<?php echo KsvmServUrl;?>KsvmUsuariosCrud/1/" id="btn-input"
							class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
							class="zmdi zmdi-arrow-left"></i></a>
					</div> -->
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
										<select class="mdl-textfield__input" name="KsvmRrlId">
												<option value="" disabled="" selected="">Seleccione Rol</option>
												<?php require_once "./Controladores/KsvmRolControlador.php";
													$KsvmSelRol = new KsvmRolControlador();
													echo $KsvmSelRol->__KsvmSeleccionarRol();
													?>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="tel" name="KsvmTelf"
												pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmTelf">
											<label class="mdl-textfield__label" for="KsvmTelf">Teléfono</label>
											<span class="mdl-textfield__error"> Teléfono Inválido</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="email" name="KsvmEmail"
												id="KsvmEmail">
											<label class="mdl-textfield__label" for="KsvmEmail">E-mail</label>
											<span class="mdl-textfield__error">E-mail Inválido</span>
										</div>
										<div class="">
                                     <input class="mdl-textfield__input" type="file" name="KsvmImgUsu" id="KsvmImgUsu">
									 <label class="mdl-textfield" for="KsvmImgUsu"><img src="<?php echo KsvmServUrl;?>Vistas/assets/img/avatar-male.png" 
									        height="35px" width="35px">&nbsp;Agregar Foto</label>
                                    </div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmNomUsu"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ]*(\.[0-9]+)?" id="KsvmNomUsu">
											<label class="mdl-textfield__label" for="KsvmNomUsu">Usuario</label>
											<span class="mdl-textfield__error">Usuario Inválido</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="password" name="KsvmContra"
												id="KsvmContra">
											<label class="mdl-textfield__label" for="KsvmContra">Contraseña</label>
											<span class="mdl-textfield__error">Contraseña Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="password" name="KsvmConContra"
												id="KsvmConContra">
											<label class="mdl-textfield__label" for="KsvmConContra">Confirmar
												Contraseña</label>
											<span class="mdl-textfield__error">Contraseña Inválida</span>
										</div>
									</div>
								</div>
								<br>
								<p class="text-center">
									<button type="submit"
										class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
										id="btn-NuevoUsuario">
										<i class="zmdi zmdi-save">&nbsp;Guardar</i>
									</button>
								</p>
								<div class="mdl-tooltip" for="btn-NuevoUsuario">Agregar Usuario</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

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
									<input class="mdl-textfield__input" type="text" id="KsvmBuscarUsu"
										name="KsvmBuscarUsu">
									<label class="mdl-textfield__label"></label>
								</div>
								<div class="mdl-textfield--expandable navBar-options-list">
									<a class="btn btn-sm btn-success mdl-shadow--8dp mdl-tabs__tab">PDF</a>
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
						1, $_SESSION['KsvmBuscarUsu']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniUsu -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
						<button class="close close-edit" type="button" data-dismiss="modal"
							aria-hidden="true" id="KsvmBtnExit">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
					<form method="POST" action="">
						<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
						<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
							<div class="mdl-textfield mdl-js-textfield">
								<label class="mdl-textfield"><img src="data:image/jpg;base64,<?php echo base64_encode($KsvmLlenarForm['UsrImgUsu']);?>"
								    height="230px" width="80%"></label>
							</div>
							<div class="mdl-textfield mdl-js-textfield">
									<div class="mdl-textfield__input"><strong>Empleado : </strong>&nbsp; &nbsp;<?php echo $KsvmEmpleado;?></div>
								</div>
						</div>
							<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--7-col-desktop">
								<div class="mdl-textfield mdl-js-textfield">
									<div class="mdl-textfield__input"><strong>Rol : </strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['RrlNomRol'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Teléfono : </strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['UsrTelfUsu'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Email : </strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['UsrEmailUsu'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Usuario : </strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['UsrNomUsu'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Contraseña : </strong>&nbsp; &nbsp;??????????</div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Estado : </strong>&nbsp; &nbsp;<?php echo $KsvmEstado;?></div>
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
			  window.location.href="localhost:90/SIGIMVAK/KsvmUsuariosCrud/1/";
		  });

		 }):
		</script>
		<?php } }?>
	</div>
	</section>
