<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<!-- pageContent -->
<section class="full-width pageContent">
	<section class="full-width header-well">
		<div class="full-width header-well-icon">
			<i class="zmdi zmdi-book"></i>
		</div>
		<div class="full-width header-well-text">
			<p class="text-condensedLight">
				MEDICAMENTOS
			</p>
		</div>
	</section>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__tab-bar">
			<a href="#KsvmListaMedicamentos" class="mdl-tabs__tab is-active">LISTA DE MEDICAMENTOS</a>
			<a href="#KsvmNuevoMedicamento" class="mdl-tabs__tab">NUEVO</a>
		</div>

		<!-- Formulario para ingresar un nuevo Medicamento -->

		<div class="mdl-tabs__panel" id="KsvmNuevoMedicamento">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nuevo Medicamento
						</div>
						<div class="full-width panel-content">
							<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmMedicamentoAjax.php"
								method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormMed">
								<div class="mdl-grid">
									<input type="HIDDEN" name="dest-exists-action" value="overwrite" />
									<div class="mdl-textfield mdl-js-textfield">
										<select class="ksvmSelectDin" name="KsvmCtgId" id="KsvmDato1"
											style="width:98%;">
											<option value="" selected="">Seleccione Categoría</option>
											<?php require_once "./Controladores/KsvmCategoriaControlador.php";
											   $KsvmSelCat = new KsvmCategoriaControlador();
											   echo $KsvmSelCat->__KsvmSeleccionarCategoria();
										     ?>
										</select>
										<span id="KsvmError1" class="ValForm"><i
												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
												campo</i></span>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmCodMed"
											    pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ-]*(\.[0-9]+)?" id="KsvmDato2">
											<label class="mdl-textfield__label" for="KsvmDato2">Código</label>
											<span class="mdl-textfield__error">Código Inválido</span>
											<span id="KsvmError2" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmPresenMed"
												pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato3">
											<label class="mdl-textfield__label" for="KsvmDato3">Presentación</label>
											<span class="mdl-textfield__error">Presentación Inválida</span>
											<span id="KsvmError3" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmNivPrescMed" id=""
												style="width:100%;">
												<option value="" selected="">Seleccione Nivel de
													Prescripción</option>
												<option value="E">E</option>
												<option value="H">H</option>
												<option value="HE">HE</option>
												<option value="E(p)">E(p)</option>
												<option value="H(p)">H(p)</option>
												<option value="HE(p)">HE(p)</option>
												<option value="(p)">(p)</option>
											</select>
											<span id="KsvmError4" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmViaAdmMed" id="KsvmDato5"
												style="width:100%;">
												<option value="" selected="">Seleccione Vía de
													Administración</option>
												<option value="P">P</option>
												<option value="O">O</option>
												<option value="T">T</option>
												<option value="N">N</option>
												<option value="R">R</option>
												<option value="I">I</option>
												<option value="Oc">Oc</option>
												<option value="O/V">O/V</option>
												<option value="IT">IT</option>
												<option value="P/MI">P/MI</option>
												<option value="P/IV">P/IV</option>
												<option value="P(MI)">P(MI)</option>
												<option value="P(IV)">P(IV)</option>
												<option value="SC">SC</option>
											</select>
											<span id="KsvmError5" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>

									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDescMed"
												pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato6">
											<label class="mdl-textfield__label" for="KsvmDato6">Descripción</label>
											<span class="mdl-textfield__error">Descripción Inválida</span>
											<span id="KsvmError6" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmConcenMed"
											    pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="">
											<label class="mdl-textfield__label" for="KsvmDato7">Concentración</label>
											<span class="mdl-textfield__error">Concentración Inválida</span>
											<span id="KsvmError7" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmNivAtencMed" id="KsvmDato8"
												style="width:100%;">
												<option value="" selected="">Selecione Nivel de Atención
												</option>
												<option value="I">Nivel 1</option>
												<option value="II">Nivel 2</option>
												<option value="III">Nivel 3</option>
												<option value="I-II">Nivel 1-2</option>
												<option value="I-III">Nivel 1-3</option>
												<option value="II-III">Nivel 2-3</option>
												<option value="I-II-III">Nivel 1-2-3</option>
											</select>
											<span id="KsvmError8" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="">
											<label class="mdl-textfield" for="KsvmFotoMed"><img
													src="<?php echo KsvmServUrl;?>Vistas/assets/img/frasco.png"
													height="35px" width="35px">&nbsp;Agregar Imagen</label>
											<input class="" type="file" name="KsvmFotoMed"
												id="KsvmFotoMed">
										</div>
									</div>
								</div>
								<br>
								<p class="text-center">
									<button type="submit" name="Enviar"
										class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
										id="btnSave">
										<i class="zmdi zmdi-save">&nbsp;Guardar</i>
									</button>
								</p>
								<div class="mdl-tooltip" for="btnSave">Nuevo Medicamento</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mdl-tabs__panel is-active" id="KsvmListaMedicamentos">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop ">
					<div class="">
						<!-- Formulario de busqueda -->
						<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable" style="margin-left: 20px;">
								<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarMed">
									<i class="zmdi zmdi-search"></i>
								</label>
								<div class="mdl-textfield__expandable-holder">
									<input class="mdl-textfield__input" type="text" id="KsvmBuscarMed"
										name="KsvmBuscarMed">
									<label class="mdl-textfield__label"></label>
								</div>
								<div class="mdl-textfield--expandable navBar-options-list" style="margin-right: 45px;">
									<a class="btn btn-sm btn-success mdl-shadow--8dp"
										href="<?php echo KsvmServUrl;?>Reportes/KsvmMedicamentosPdf.php"
										target="_blank"><i class="zmdi zmdi-file">&nbsp;PDF</i></a>
								</div>
							</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>

					<!-- Método para mostrar la lista de Medicamentos -->
					<?php
					require_once "./Controladores/KsvmMedicamentoControlador.php";
					$KsvmIniMed = new KsvmMedicamentoControlador();

					if (isset($_POST['KsvmBuscarMed'])) {

					$_SESSION['KsvmBuscarMed'] = $_POST['KsvmBuscarMed'];
					$KsvmPagina = explode("/", $_GET['Vistas']);
					echo $KsvmIniMed -> __KsvmPaginador($KsvmPagina[1], 100, $_SESSION['KsvmRolId-SIGIM'], 
					1, $_SESSION['KsvmBuscarMed']);
					}else{

					$KsvmPagina = explode("/", $_GET['Vistas']);
					echo $KsvmIniMed -> __KsvmPaginador($KsvmPagina[1], 100, $_SESSION['KsvmRolId-SIGIM'], 
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
			  $KsvmDataEdit = $KsvmIniMed->__KsvmEditarMedicamentoControlador($KsvmPagina[2]);
	
			  if ($KsvmDataEdit->rowCount() == 1) {
				  $KsvmLlenarForm = $KsvmDataEdit->fetch();
				
				  $KsvmViaAdmin = $KsvmLlenarForm['MdcViaAdmMed'];
	
				  switch ($KsvmViaAdmin) {
					case 'P':
					$KsvmViaAdmin = "P";
					break;
					case 'O':
					$KsvmViaAdmin = "O";
					break;
					case 'T':
					$KsvmViaAdmin = "T";
					break;
					case 'N':
					$KsvmViaAdmin = "N";
					break;
					case 'R':
					$KsvmViaAdmin = "R";
					break;
					case 'I':
					$KsvmViaAdmin = "I";
					break;
					case 'Oc':
					$KsvmViaAdmin = "Oc";
					break;
					case 'O/v':
					$KsvmViaAdmin = "O/v";
					break;
					case 'IT':
					$KsvmViaAdmin = "IT";
					break;
					case 'P/MI':
					$KsvmViaAdmin = "P/MI";
					break;
					case 'P/IV':
					$KsvmViaAdmin = "P/IV";
					break;
					case 'P(IM)':
					$KsvmViaAdmin = "P(IM)";
					break;
					case 'P(IV)':
					$KsvmViaAdmin = "P(IV)";
					break;
					case 'SC':
					$KsvmViaAdmin = "SC";
					break;
						  
					default;
					break;
				  }
				  
	
				  $KsvmNivPresc = $KsvmLlenarForm['MdcNivPrescMed'];
				  switch ($KsvmNivPresc) {
					case 'E':
					$KsvmNivPresc = "E";
					break;
					case 'H':
					$KsvmNivPresc = "H";
					break;
					case 'HE':
					$KsvmNivPresc = "HE";
					break;
					case 'E(p)':
					$KsvmNivPresc = "E(p)";
					break;
					case 'H(p)':
					$KsvmNivPresc = "H(p)";
					break;
					case 'HE(p)':
					$KsvmNivPresc = "HE(p)";
					break;
					case '(p)':
					$KsvmNivPresc = "(p)";
					break;
	
					default:
					break;
					}
					
	
				  $KsvmEstado = "";
					if ($KsvmLlenarForm['MdcEstMed'] == 'A') {
						$KsvmEstado = "Activo";
					} else {
						$KsvmEstado = "Inactivo";
					}
				  
			?>
		<script>
			window.onload = function () {

				$("#KsvmFormMed").trigger("reset");
				$(".modal-title").text("Detalles Medicamento");
				$("#KsvmDetallesMedicamento").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles del Medicamento -->

		<div class="modal fade" id="KsvmDetallesMedicamento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header">
						<button class="close close-edit" type="button" data-dismiss="modal" aria-hidden="true"
							id="btnExitMed">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body">
						<form action="'.KsvmServUrl.'Ajax/KsvmMedicamentoAjax.php" method="POST" class="FormularioAjax"
							data-form="eliminar" enctype="multipart/form-data">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<div class="img-responsive">
											<img height="255px" width="80%"
												src="data:image/jpg;base64,<?php echo base64_encode($KsvmLlenarForm['MdcFotoMed']);?>" />
										</div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Categoría :</strong>
											&nbsp; &nbsp;<?php echo $KsvmLlenarForm['CtgNomCat'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Color :</strong>
											&nbsp; &nbsp;<button class="btn btn-md"
												style="width:50%; border-color:#000; background-color:<?php echo $KsvmLlenarForm['CtgColorCat'];?>;"></button>
										</div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--7-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>Código :</strong>
											&nbsp; &nbsp;<?php echo $KsvmLlenarForm['MdcCodMed'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Descripción :</strong>
											&nbsp; &nbsp;<?php echo $KsvmLlenarForm['MdcDescMed'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Presentación :</strong>
											&nbsp; &nbsp;<?php echo $KsvmLlenarForm['MdcPresenMed'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Concentración :</strong>
											&nbsp; &nbsp;<?php echo $KsvmLlenarForm['MdcConcenMed'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Nivel de Prescripción :</strong>
											&nbsp; &nbsp;<?php echo $KsvmNivPresc;?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>Nivel de Atención :</strong>
											&nbsp; &nbsp;<?php echo $KsvmLlenarForm['MdcNivAtencMed'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Via de Administración :</strong>
											&nbsp; &nbsp;<?php echo $KsvmViaAdmin;?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input type="hidden" name="KsvmCodDelete"
											value="<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['MdcId']);?>">
										<nav style="float:right;">
											<a class="btn btn-xs btn-primary"
												href="<?php echo KsvmServUrl;?>KsvmMedicamentosEditar/<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['MdcId']);?>/1/"><i
													class="zmdi zmdi-edit">&nbsp;EDITAR</i></a>
											<button type="submit" class="btn btn-xs btn-danger"><i
													class="zmdi zmdi-delete">&nbsp;ELIMINAR</i></button>
										</nav>
									</div>
								</div>
							</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php } }?>
	</div>
</section>