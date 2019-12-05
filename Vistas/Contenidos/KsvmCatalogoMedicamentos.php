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
					<!-- <div class="" style="float:right;">
							<a href="<?php echo KsvmServUrl;?>KsvmMedicamentosCrud/1/" id="btn-input"
								class="btn btn-sm btn-info mdl-shadow--8dp">VOLVER &nbsp;<i
									class="zmdi zmdi-arrow-left"></i></a>
						</div>
						<br><br> -->
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
										<select class="mdl-textfield__input" name="KsvmCtgId">
											<option value="" selected="" disabled="">Seleccione Categoría</option>
											<?php require_once "./Controladores/KsvmCategoriaControlador.php";
											   $KsvmSelCat = new KsvmCategoriaControlador();
											   echo $KsvmSelCat->__KsvmSeleccionarCategoria();
										     ?>
										</select>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmCodMed"
												id="KsvmCodMed">
											<label class="mdl-textfield__label" for="KsvmCodMed">Código</label>
											<span class="mdl-textfield__error">Código Inválido</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmPresenMed"
												pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmPresenMed">
											<label class="mdl-textfield__label" for="KsvmPresenMed">Presentación</label>
											<span class="mdl-textfield__error">Presentación Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmNivPrescMed">
												<option value="" selected="" disabled="">Seleccione Nivel de
													Prescripción</option>
												<option value="E">E</option>
												<option value="H">H</option>
												<option value="HE">HE</option>
												<option value="E(p)">E(p)</option>
												<option value="H(p)">H(p)</option>
												<option value="HE(p)">HE(p)</option>
												<option value="(p)">(p)</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmViaAdmMed">
												<option value="" selected="" disabled="">Seleccione Vía de
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
										</div>

									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDescMed"
												pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDescMed">
											<label class="mdl-textfield__label" for="KsvmDescMed">Descripción</label>
											<span class="mdl-textfield__error">Descripción Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmConcenMed"
												id="KsvmConcenMed">
											<label class="mdl-textfield__label"
												for="KsvmConcenMed">Concentración</label>
											<span class="mdl-textfield__error">Concentración Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmNivAtencMed">
												<option value="" selected="" disabled="">Selecione Nivel de Atención
												</option>
												<option value="I">Nivel 1</option>
												<option value="II">Nivel 2</option>
												<option value="III">Nivel 3</option>
												<option value="I-II">Nivel 1-2</option>
												<option value="I-III">Nivel 1-3</option>
												<option value="II-III">Nivel 2-3</option>
												<option value="I-II-III">Nivel 1-2-3</option>
											</select>
										</div>
										<div class="">
											<input class="mdl-textfield__input" type="file" name="KsvmFotoMed"
												id="KsvmFotoMed">
											<label class="mdl-textfield" for="KsvmFotoMed"><img height="35px"
													width="35px">&nbsp;Agregar Imagen</label>
										</div>
									</div>
								</div>
								<br>
								<p class="text-center">
									<button type="submit" name="Enviar"
										class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
										id="btn-NuevoMedicamento">
										<i class="zmdi zmdi-save">&nbsp;Guardar</i>
									</button>
								</p>
								<div class="mdl-tooltip" for="btn-NuevoMedicamento">Nuevo Medicamento</div>
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
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
								<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarMed">
									<i class="zmdi zmdi-search"></i>
								</label>
								<div class="mdl-textfield__expandable-holder">
									<input class="mdl-textfield__input" type="text" id="KsvmBuscarMed"
										name="KsvmBuscarMed">
									<label class="mdl-textfield__label"></label>
								</div>
								<div class="mdl-textfield--expandable navBar-options-list">
									<a class="btn btn-sm btn-success mdl-shadow--8dp mdl-tabs__tab">PDF</a>&nbsp;
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
					echo $KsvmIniMed -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
					1, $_SESSION['KsvmBuscarMed']);
					}else{

					$KsvmPagina = explode("/", $_GET['Vistas']);
					echo $KsvmIniMed -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
					$KsvmViaAdmin = "";
					break;
					case 'O':
					$KsvmViaAdmin = "";
					break;
					case 'T':
					$KsvmViaAdmin = "";
					break;
					case 'N':
					$KsvmViaAdmin = "";
					break;
					case 'R':
					$KsvmViaAdmin = "";
					break;
					case 'I':
					$KsvmViaAdmin = "";
					break;
					case 'Oc':
					$KsvmViaAdmin = "";
					break;
					case 'O/v':
					$KsvmViaAdmin = "";
					break;
					case 'IT':
					$KsvmViaAdmin = "";
					break;
					case 'P/MI':
					$KsvmViaAdmin = "";
					break;
					case 'P/IV':
					$KsvmViaAdmin = "";
					break;
					case 'P(IM)':
					$KsvmViaAdmin = "";
					break;
					case 'P(IV)':
					$KsvmViaAdmin = "";
					break;
					case 'SC':
					$KsvmViaAdmin = "";
					break;
						  
					default;
					break;
				  }
				  
	
				  $KsvmNivPresc = $KsvmLlenarForm['MdcNivPrescMed'];
				  switch ($KsvmNivPresc) {
					case 'E':
					$KsvmNivPresc = "";
					break;
					case 'H':
					$KsvmNivPresc = "";
					break;
					case 'HE':
					$KsvmNivPresc = "";
					break;
					case 'E(p)':
					$KsvmNivPresc = "";
					break;
					case 'H(p)':
					$KsvmNivPresc = "";
					break;
					case 'HE(p)':
					$KsvmNivPresc = "";
					break;
					case '(p)':
					$KsvmNivPresc = "";
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
	
				<div class="modal fade" id="KsvmDetallesMedicamento" tabindex="-1" role="dialog"
					aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content ">
							<div class="modal-header">
								<button class="close close-edit" type="button" data-dismiss="modal"
									aria-hidden="true">&times;</button>
								<h5 class="modal-title text-center"></h5>
							</div>
							<div class="modal-body">
							<form action="'.KsvmServUrl.'Ajax/KsvmMedicamentoAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
									<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
									<div class="mdl-grid">
										<div
											class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
											<div class="mdl-textfield mdl-js-textfield">
												<div class="img-responsive">
													<img height="255px" width="90%"
														src="data:image/png;base64,<?php echo base64_encode($KsvmLlenarForm['MdcFotoMed']);?>" />
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
											 <input type="hidden" name="KsvmCodDelete" value="<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['MdcId']);?>">   
											   	<nav style="float:right;">
											    <a class="btn btn-xs btn-primary" href="<?php echo KsvmServUrl;?>KsvmMedicamentosEditar/<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['MdcId']);?>/1/"><i class="zmdi zmdi-edit">&nbsp;EDITAR</i></a>
												<button type="submit" class="btn btn-xs btn-danger"><i class="zmdi zmdi-delete">&nbsp;ELIMINAR</i></button>
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