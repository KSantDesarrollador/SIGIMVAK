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
					CRUD-EMPLEADOS
				</p>
			</div>
		</section>
		<div class="full-width divider-menu-h"></div>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__panel is-active" id="KsvmListaEmpleado">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
						<div class="">
							<!-- Formulario de busqueda -->
							<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
									<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarEmp">
										<i class="zmdi zmdi-search"></i>
									</label>
									<div class="mdl-textfield__expandable-holder">
										<input class="mdl-textfield__input" type="text" id="KsvmBuscarEmp"
											name="KsvmBuscarEmp">
										<label class="mdl-textfield__label"></label>
									</div>
									<div class="mdl-textfield--expandable navBar-options-list">
										<a class="btn btn-sm btn-success mdl-shadow--8dp"
											href="<?php echo KsvmServUrl;?>Reportes/KsvmEmpleadosPdf.php"
											target="_blank"><i class="zmdi zmdi-file">&nbsp;PDF</i></a>
										<a href="#KsvmNuevoEmpleado" id="btn-input"
											class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
												class="zmdi zmdi-plus-circle"></i></a>
									</div>
								</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>

						<!-- Método para mostrar la lista de Empleados -->
						<?php
                    require_once "./Controladores/KsvmEmpleadoControlador.php";
					$KsvmIniEmp = new KsvmEmpleadoControlador();

					if (isset($_POST['KsvmBuscarEmp'])) {

						$_SESSION['KsvmBuscarEmp'] = $_POST['KsvmBuscarEmp'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniEmp -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, $_SESSION['KsvmBuscarEmp']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniEmp -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
		  $KsvmDataEdit = $KsvmIniEmp->__KsvmEditarEmpleadoControlador($KsvmPagina[2]);

		  if ($KsvmDataEdit->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataEdit->fetch();

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
			
			  if ($KsvmLlenarForm['EpoTipIdentEmp'] == "C") {
				  $KsvmTipo = "Cedula";
			  }else {
				 $KsvmTipo = "Pasaporte";
			  }

			  if ($KsvmLlenarForm['EpoEstCivEmp'] == "S") {
				  $KsvmCivil = "Soltero/a";
			  } elseif($KsvmLlenarForm['EpoEstCivEmp'] == "U") {
				  $KsvmCivil = "Union libre";
			  } elseif ($KsvmLlenarForm['EpoEstCivEmp'] == "C") {
				  $KsvmCivil = "Casado/a";
			  } elseif ($KsvmLlenarForm['EpoEstCivEmp'] == "D") {
				  $KsvmCivil = "Divorciado/a";  
			  } else {
				  $KsvmCivil = "Viudo/a";
			  }

			  if ($KsvmLlenarForm['EpoSexoEmp'] == "H") {
				  $KsvmSexo = "Hombre";
			  } else {
				  $KsvmSexo = "Mujer";
			  }

			  if ($KsvmLlenarForm['EpoGeneroEmp'] == "M") {
				$KsvmGenero = "Masculino";
			} elseif ($KsvmLlenarForm['EpoGeneroEmp'] == "F") {
				$KsvmGenero = "Femenino";
			}else{
				$KsvmGenero = "Indeterminado";
			}
			  
			  
	    ?>
			<script>
				window.onload = function () {

					$("#KsvmFormEmp").trigger("reset");
					$(".modal-title").text("Detalles Empleado");
					$("#KsvmDetallesEmpleado").modal({
						show: true
					});
				}
			</script>

			<!-- Formulario de Detalles del Empleado -->

			<div class="modal fade" id="KsvmDetallesEmpleado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content ">
						<div class="modal-header">
							<button class="close close-edit" type="button" data-dismiss="modal" aria-hidden="true"
								id="btnExitEmpCrud">&times;</button>
							<h5 class="modal-title text-center"></h5>
						</div>
						<div class="modal-body">
							<form action="" method="POST" id="KsvmFormEmp">
								<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--3-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<div class="img-responsive">
												<img height="143px" width="55%"
													src="data:image/jpg;base64,<?php echo base64_encode($KsvmLlenarForm['EpoFotoEmp']);?>" />
											</div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Primer Apellido :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['EpoPriApeEmp'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Segundo Apellido :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['EpoSegApeEmp'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Primer Nombre :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['EpoPriNomEmp'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Segundo Nombre :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['EpoSegNomEmp'];?></div>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Tipo Identificación :</strong>
												&nbsp; &nbsp;<?php echo $KsvmTipo;?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Identificación :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['EpoIdentEmp'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Cargo :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['CrgNomCar'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Estado Civil :</strong>
												&nbsp; &nbsp;<?php echo $KsvmCivil;?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Sexo :</strong>
												&nbsp; &nbsp;<?php echo $KsvmSexo;?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Género</strong>
												&nbsp; &nbsp;<?php echo $KsvmGenero;?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input">Edad :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['EpoFchNacEmp'];?></div>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>País :</strong>
												<?php echo $KsvmPais;?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Cantón :</strong>
												&nbsp; &nbsp;<?php echo $KsvmCanton;?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Provincia :</strong>
												&nbsp; &nbsp;<?php echo $KsvmProvincia;?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Parroquia :</strong>
												&nbsp; &nbsp;<?php echo $KsvmParroquia;?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Dirección :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['EpoDirEmp'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Teléfono :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['EpoTelfEmp'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Email :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['EpoEmailEmp'];?></div>
										</div>
									</div>
								</div>
								<div class="mdl-tooltip" for="btn-NuevoEmpleado">Editar empleado</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<?php } }?>

			<!-- Formulario para ingresar un nuevo Empleado -->

			<div class="mdl-tabs__panel" id="KsvmNuevoEmpleado">
				<div class="mdl-grid">
					<div
						class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
						<div class="" style="float:right;">
							<a href="<?php echo KsvmServUrl;?>KsvmEmpleadosCrud/1/" id="btn-input"
								class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
									class="zmdi zmdi-arrow-left"></i></a>
						</div>
						<br><br>
						<div class="full-width panel mdl-shadow--8dp">
							<div class="full-width modal-header-input text-center">
								Nuevo Empleado
							</div>
							<div class="full-width panel-content">
								<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmEmpleadoAjax.php"
									method="POST" class="FormularioAjax" autocomplete="off"
									enctype="multipart/form-data" id="KsvmFormEmpleado">

									<div class="mdl-grid">
										<div
											class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" name="KsvmIdPais"
													id="KsvmCargaListaPais" style="width:100%;" required>
												</select>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" id="KsvmCargaListaCanton"
												style="width:100%;">
													<option value="" disabled="" selected="">Seleccione Cantón</option>
												</select>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" name="KsvmTipoIdent"
													id="KsvmDato1" style="width:100%;">
													<option value="" selected="">Seleccione Tipo de Identificación
													</option>
													<option value="C">Cédula</option>
													<option value="P">Pasaporte</option>
												</select>
												<span id="KsvmError1" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmIdent"
													pattern="[0-9]{10,13}" id="KsvmDato2">
												<label class="mdl-textfield__label"
													for="KsvmDato2">Identificación</label>
												<span class="mdl-textfield__error">Número Inválido</span>
												<span id="KsvmError2" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmPrimApel"
													pattern="-?[A-Za-záéíóúÁÉÍÓÚñ ]*(\.[0-9]+)?" id="KsvmDato3">
												<label class="mdl-textfield__label" for="KsvmDato3">Primer
													Apellido</label>
												<span class="mdl-textfield__error">Apellido
													Inválido</span>
												<span id="KsvmError3" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmSegApel"
													pattern="-?[A-Za-záéíóúÁÉÍÓÚñ ]*(\.[0-9]+)?" id="KsvmDato4">
												<label class="mdl-textfield__label" for="KsvmDato4">Segundo
													Apellido</label>
												<span class="mdl-textfield__error">Apellido Inválido</span>
												<span id="KsvmError4" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmPrimNom"
													pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato5">
												<label class="mdl-textfield__label" for="KsvmDato5">Primer
													Nombre</label>
												<span class="mdl-textfield__error">Nombre Inválido</span>
												<span id="KsvmError5" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmSegNom"
													pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato6">
												<label class="mdl-textfield__label" for="KsvmDato6">Segundo
													Nombre</label>
												<span class="mdl-textfield__error">Nombre Inválido</span>
												<span id="KsvmError6" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<input type="text" class="mdl-textfield__input tcal" id="KsvmDato7"
													name="KsvmFchNac" placeholder="Fecha de nacimiento"
													pattern="[0-9-]{10,10}" style="width:93%;">
												<label class="mdl-textfield__label" for="KsvmDato7"></label>
												<span class="mdl-textfield__error">Fecha Inválida</span>
												<span id="KsvmError7" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="">
												<input class="mdl-textfield__input" type="file" name="KsvmFotoEmp"
													id="KsvmFotoEmp">
												<label class="mdl-textfield" for="KsvmFotoEmp"><img
														src="<?php echo KsvmServUrl;?>Vistas/assets/img/avatar-male.png"
														height="35px" width="35px">&nbsp;Agregar Foto</label>
											</div>
										</div>
										<div
											class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" style="width:100%;" id="KsvmCargaListaProvincia">
													<option value="" disabled="" selected="">Seleccione Provincia
													</option>
												</select>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" style="width:100%;" name="KsvmIdParroquia"
													id="KsvmCargaListaParroquia">
													<option value="" disabled="" selected="">Seleccione Parroquia
													</option>
												</select>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" style="width:100%;" name="KsvmRol" id="KsvmDato8">
													<option value="" selected="">Seleccione Rol</option>
													<?php require_once "./Controladores/KsvmRolControlador.php";
													$KsvmSelRol = new KsvmRolControlador();
													echo $KsvmSelRol->__KsvmSeleccionarRol();
													?>
												</select>
												<span id="KsvmError8" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" style="width:100%;" name="KsvmCargo" id="KsvmDato9">
													<option value="" selected="">Seleccione Cargo</option>
													<?php require_once "./Controladores/KsvmCargoControlador.php";
													$KsvmSelCar = new KsvmCargoControlador();
													echo $KsvmSelCar->__KsvmSeleccionarCargo();
													?>
												</select>
												<span id="KsvmError9" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmDirc"
												     pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ- ]*(\.[0-9]+)?" id="KsvmDato10">
												<label class="mdl-textfield__label" for="KsvmDato10">Dirección</label>
												<span class="mdl-textfield__error">Dirección Inválida</span>
												<span id="KsvmError10" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="tel" name="KsvmTelf"
													pattern="[0-9()]{7,10}" id="KsvmDato11">
												<label class="mdl-textfield__label" for="KsvmDato11">Teléfono</label>
												<span class="mdl-textfield__error">Número de teléfono Inválido</span>
												<span id="KsvmError11" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="email" name="KsvmEmail"
													pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
													id="KsvmDato12">
												<label class="mdl-textfield__label" for="KsvmDato12">E-mail</label>
												<span class="mdl-textfield__error">E-mail Inválido</span>
												<span id="KsvmError12" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" style="width:100%;" name="KsvmEstCiv" id="KsvmDato13">
													<option value="" selected="">Seleccione Estado Civil
													</option>
													<option value="S">Soltero/a</option>
													<option value="U">Union Libre</option>
													<option value="C">Casado/a</option>
													<option value="D">Divorciado/a</option>
													<option value="V">Viudo/a</option>
												</select>
												<span id="KsvmError13" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" style="width:100%;" name="KsvmSexo" id="KsvmDato14">
													<option value="" selected="">Seleccione Sexo</option>
													<option value="H">Hombre</option>
													<option value="M">Mujer</option>
												</select>
												<span id="KsvmError14" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" style="width:100%;" name="KsvmGenero" id="KsvmDato15">
													<option value="" selected="">Seleccione Género</option>
													<option value="M">Masculino</option>
													<option value="F">Femenino</option>
													<option value="I">Indeterminado</option>
												</select>
												<span id="KsvmError15" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
										</div>
									</div>
									<p class="text-center">
										<button type="submit"
											class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
											id="btnSave">
											<i class="zmdi zmdi-save">&nbsp;Guardar</i>
										</button>
									</p>
									<div class="mdl-tooltip" for="btnSave">Agregar empleado</div>
									<div class="RespuestaAjax"></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>