<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->
<?php
  require_once "./Archivos/KsvmMostrarRegistrosEgreso.php";
  $KsvmIniEgr = new KsvmMostrarRegistrosEgreso();
?>

<!-- pageContent -->
<section class="full-width pageContent">
	<section class="full-width header-well">
		<div class="full-width header-well-icon">
			<i class="zmdi zmdi-arrow-left"></i>
		</div>
		<div class="full-width header-well-text">
			<p class="text-condensedLight">
				EGRESOS
			</p>
		</div>
	</section>
	<!-- <div class="full-width divider-menu-h"></div> -->
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__tab-bar">
			<a href="#KsvmListaEgresos" class="mdl-tabs__tab is-active">LISTA DE EGRESOS</a>
			<a href="#KsvmNuevaTransaccion" class="mdl-tabs__tab">NUEVO EGRESO</a>
		</div>
		<div class="mdl-tabs__panel" id="KsvmNuevaTransaccion">
			<div class="mdl-grid">
				<!-- Formulario para ingresar un nuevo Inventario -->
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nuevo Egreso
						</div>
						<div class="full-width panel-content">
							<form action="<?php echo KsvmServUrl; ?>Ajax/KsvmTransaccionAjax.php" method="POST"
								class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormCompra" data-form="guardar">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" id="KsvmBdgId" name="KsvmOrigenTran"
												style="width:100%;" required>
												<option value="" selected="">Bodega</option>
												<?php require_once "./Controladores/KsvmBodegaControlador.php";
													$KsvmSelBod = new KsvmBodegaControlador();
													echo $KsvmSelBod->__KsvmSeleccionarBodegaExt();
													?>
											</select>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" id="KsvmBdgReq" name="KsvmDestinoTran"
												style="width:100%;" required>
												<option value="" selected="">Bodega Solicitante</option>
												<?php require_once "./Controladores/KsvmBodegaControlador.php";
													$KsvmSelBod = new KsvmBodegaControlador();
													echo $KsvmSelBod->__KsvmSeleccionarBodegaEgresos();
													?>
											</select>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmRqcId" id="KsvmRqcId"
												style="width:100%;" required>
												<option value="" disabled="" selected="">Pedido</option>
											</select>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
											hidden>
											<input class="mdl-textfield__input" type="text" name="KsvmTipoTran"
												id="KsvmTipoTran" value="Egreso">
											<label class="mdl-textfield__label" for="KsvmTipoTran">Tipo de
												transacción</label>
										</div>
									</div>
									<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop"
										id="GridData">
										<p class="text-center">
											<button type="submit" style="width:49%; float:left;"
												class="mdl-button mdl-js-button mdl-js-ripple-effect btn-info mdl-shadow--4dp"
												id="btnContinuar">
												<i class="zmdi zmdi-flash" style="font-size:15px;">&nbsp;
													&nbsp;Confirmar Egreso</i>
											</button>

											<button type="reset" style="width:49%; float:right;"
												class="mdl-button mdl-js-button mdl-js-ripple-effect btn-danger mdl-shadow--4dp"
												id="btnCancelar">
												<i class="zmdi zmdi-close" style="font-size:15px;">&nbsp;
													&nbsp;Cancelar</i>
											</button>
										</p>
										<div class="mdl-tooltip" for="btnContinuar">Confirmar</div>
										<div class="mdl-tooltip" for="btnCancelar">Cancelar</div>
									</div>
								</div>
								<div class="RespuestaAjax"></div>
							</form>
							<div class="full-width divider-menu-h"></div>
							<form action="<?php echo KsvmServUrl; ?>Ajax/KsvmAgregarRegistrosTransaccionAjax.php"
								method="POST" class="RegistrosAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormTransaccion">
								<div class="mdl-grid" id="GridRows">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield" id="KsvmBodEg" hidden>
											<input class="mdl-textfield__input" type="text" name="KsvmBdgId">
											<label class="mdl-textfield__label" for="KsvmTipoTran">Bodega</label>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
											hidden>
											<input class="mdl-textfield__input" type="text" name="KsvmTipoTran"
												id="KsvmTipoTran" value="Egreso">
											<label class="mdl-textfield__label" for="KsvmTipoTran">Tipo de
												transacción</label>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" name="KsvmExtId" id="KsvmExtId"
												style="width:100%;" required>
												<option value="" disabled="" selected=""> Medicamento</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmObservTran"
												id="KsvmObservTran">
											<label class="mdl-textfield__label" for="KsvmObservTran">Observación</label>
											<span class="mdl-textfield__error">Observación Inválida</span>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
											id="KsvmCantTran">
											<input class="mdl-textfield__input" type="number" max="1000" min="1"
												name="KsvmCantTran" pattern="-?[0-9+()- ]*(\.[0-9]+)?" id="KsvmDato3">
											<label class="mdl-textfield__label" for="KsvmDato3">Cantidad</label>
											<span class="mdl-textfield__error">Cantidad Inválida</span>
											<span id="KsvmError3" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
										</div>
										<br>
										<p class="text-center">
											<button type="submit" style="width:49%; float:left;"
												class="mdl-button mdl-js-button mdl-js-ripple-effect btn-success mdl-shadow--4dp"
												id="btnSave">
												<i class="zmdi zmdi-plus" style="font-size:20px;"></i>&nbsp;Agregar
											</button>

											<button type="reset" style="width:49%; float:right;"
												class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
												id="btnGuardar" onClick="muestra_oculta('GridData')">
												<i class="zmdi zmdi-download" style="font-size:20px;"></i>&nbsp;
												&nbsp;Guardar
											</button>
										</p>
										<div class="mdl-tooltip" for="btnSave">Agregar</div>
										<div class="mdl-tooltip" for="btnGuardar">Guardar</div>
									</div>
								</div>
								<div class="Respuesta"></div>
							</form>

							<div class="full-width divider-menu-h"></div>
							<div class="">
								<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop"
									id="ListaData">

								</div>
								<div class="Resultado"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mdl-tabs__panel is-active" id="KsvmListaEgresos">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<div class="">
						<!-- Formulario de busqueda -->
						<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
								<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarTran">
									<i class="zmdi zmdi-search"></i>
								</label>
								<div class="mdl-textfield__expandable-holder">
									<input class="mdl-textfield__input" type="text" id="KsvmBuscarTran"
										name="KsvmBuscarTran">
									<label class="mdl-textfield__label"></label>
								</div>
								<div class="mdl-textfield--expandable navBar-options-list">
									<a class="btn btn-sm btn-success mdl-shadow--8dp"
										href="<?php echo KsvmServUrl;?>Reportes/KsvmEgresosPdf.php" target="_blank"><i
											class="zmdi zmdi-file">&nbsp;PDF</i></a>
								</div>
							</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>

					<!-- Método para mostrar la lista de Transaccions -->
					<?php
                    require_once "./Controladores/KsvmTransaccionControlador.php";
					$KsvmIniTran = new KsvmTransaccionControlador();

					if (isset($_POST['KsvmBuscarTran'])) {

						$_SESSION['KsvmBuscarTran'] = $_POST['KsvmBuscarTran'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniTran -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						2, $_SESSION['KsvmBuscarTran'], "", "");
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniTran -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						2, "", "", "");
				       }
				?>

				</div>
			</div>
		</div>

		<!-- Método para cargar datos en el formulario -->
		<?php 
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[2] != "") {
		  $KsvmDataEdit = $KsvmIniTran->__KsvmEditarDetalleTransaccionControlador($KsvmPagina[2]);

			  $KsvmQuery = $KsvmDataEdit->fetchAll();
			  
	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormOcp").trigger("reset");
				$(".modal-title").text("Detalles Egreso");
				$("#KsvmDetallesTransaccion").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles del Transaccion -->

		<div class="modal fade" id="KsvmDetallesTransaccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header">
						<button class="close close-edit" type="button" id="btnExitEgr" data-dismiss="modal"
							aria-hidden="true">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body">
						<form action="" method="POST" id="KsvmFormOcp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-textfield"><strong>Num.Egreso :</strong></div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--3-col-desktop">
									<div class="mdl-textfield"><strong>Medicamento:</strong></div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-textfield"><strong>Cantidad :</strong></div>
								</div>>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
									<div class="mdl-textfield"><strong>Observación :</strong></div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
									<div class="mdl-textfield"><strong>Acción :</strong></div>
								</div>
								<?php foreach ($KsvmQuery as $KsvmLlenarForm) {?>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-data-table__cell--non-numeric">
										<div class="mdl-textfield__input">
											<?php echo $KsvmLlenarForm['TsnNumTran'];?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--3-col-desktop">
									<div class="mdl-data-table__cell--non-numeric">
										<div class="mdl-textfield__input">
											<?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed'];?>
										</div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
										<div class="mdl-textfield__input">
											<?php echo $KsvmLlenarForm['DtsCantTran'];?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
									<div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
										<div class="mdl-textfield__input">
											<?php echo $KsvmLlenarForm['DtsObservTran'];?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
									<a class="btn btn-sm btn-primary"
										href="<?php echo KsvmServUrl;?>KsvmDetallesTransaccionEditar/<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['DtsId']);?>/2/"><i
											class="zmdi zmdi-edit"></i></a>
								</div>
								<?php }?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php }?>
	</div>
</section>