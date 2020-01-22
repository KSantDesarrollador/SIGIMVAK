<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<!-- pageContent -->
<section class="full-width pageContent">
	<section class="full-width header-well">
		<div class="full-width header-well-icon">
			<i class="zmdi zmdi-device-hub"></i>
		</div>
		<div class="full-width header-well-text">
			<p class="text-condensedLight">
				PARÁMETROS
			</p>
		</div>
	</section>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__tab-bar">
			<a href="#KsvmListaParametros" class="mdl-tabs__tab is-active">LISTA DE PARÁMETROS</a>
			<a href="#KsvmNuevoParametro" class="mdl-tabs__tab">NUEVO PARÁMETRO</a>
		</div>

		<!-- Formulario para ingresar un nuevo Parametros -->

		<div class="mdl-tabs__panel" id="KsvmNuevoParametro">
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nuevo Parámetro
						</div>
						<div class="full-width panel-content">
							<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmParametrosAjax.php"
								method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormParametros">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmMdcId" id="KsvmDato1"
												style="width:98%;">
												<option value="" select="">Seleccione Medicamento</option>
												<?php require_once "./Controladores/KsvmMedicamentoControlador.php";
													$KsvmSelExt = new KsvmMedicamentoControlador();
													echo $KsvmSelExt->__KsvmSeleccionarMedicamento();
													?>
											</select>
											<span id="KsvmError1" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmAltId" id="KsvmDato2"
												style="width:98%;">
												<?php require_once "./Controladores/KsvmAlertaControlador.php";
													$KsvmSelAle = new KsvmAlertaControlador();
													echo $KsvmSelAle->__KsvmSeleccionarAlerta();
													?>
											</select>
											<span id="KsvmError2" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="number" 
											    min="1" max="10000" name="KsvmMinPar"
											    pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato3">
											<label class="mdl-textfield__label" for="KsvmDato3">Valor Mínimo</label>
											<span class="mdl-textfield__error">Valor Inválido</span>
											<span id="KsvmError3" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="number" 
											    min="1" max="10000" name="KsvmMaxPar"
											    pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato4">
											<label class="mdl-textfield__label" for="KsvmDato4">Valor Máximo</label>
											<span class="mdl-textfield__error">Valor Inválida</span>
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
								<div class="mdl-tooltip" for="btnSave">Agregar Parametros</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="mdl-tabs__panel is-active" id="KsvmListaParametros">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<!-- Formulario de busqueda -->
					<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
							<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarPar">
								<i class="zmdi zmdi-search"></i>
							</label>
							<div class="mdl-textfield__expandable-holder">
								<input class="mdl-textfield__input" type="text" id="KsvmBuscarPar" name="KsvmBuscarPar">
								<label class="mdl-textfield__label"></label>
							</div>
							<div class="mdl-textfield--expandable navBar-options-list">
								<a class="btn btn-sm btn-success mdl-shadow--8dp"
									href="<?php echo KsvmServUrl;?>Reportes/KsvmParametrosPdf.php" target="_blank"><i
										class="zmdi zmdi-file">&nbsp;PDF</i></a>
							</div>
						</div>
						<div class="RespuestaAjax"></div>
					</form>

					<!-- Método para mostrar la lista de Parametross -->
					<?php
                    require_once "./Controladores/KsvmParametrosControlador.php";
					$KsvmIniPar = new KsvmParametrosControlador();

					if (isset($_POST['KsvmBuscarPar'])) {

						$_SESSION['KsvmBuscarPar'] = $_POST['KsvmBuscarPar'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniPar -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						1, $_SESSION['KsvmBuscarPar']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniPar -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
		  $KsvmDataDetail = $KsvmIniPar->__KsvmEditarParametrosControlador($KsvmPagina[2]);

		  if ($KsvmDataDetail->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataDetail->fetch();
			  
	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormParametros").trigger("reset");
				$(".modal-title").text("Detalles Parametros");
				$("#KsvmDetallesParametros").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles del Parametros -->

		<div class="modal fade" id="KsvmDetallesParametros" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header ">
						<button class="close close-edit" type="button" data-dismiss="modal" aria-hidden="true"
							id="btnExitPar">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
						<form method="POST" action="">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
										<div class="mdl-textfield__input"><strong>Medicamento :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed'] ;?>
										</div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Alerta :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['AltNomAle'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Valor Máximo :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['PmtMinPar'];?></div>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<div class="mdl-textfield__input"><strong>Valor Mínimo :</strong>&nbsp;
											&nbsp;<?php echo $KsvmLlenarForm['PmtMaxPar'];?></div>
									</div>
								</div>
							</div>
							<br>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function () {
				$('#KsvmBtnExit').on('click', function () {
					window.location.href = "localhost:90/SIGIMVAK/KsvmParametrosCrud/1/";
				});

			}):
		</script>
		<?php } }?>
	</div>
</section>