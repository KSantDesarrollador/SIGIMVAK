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
					CRUD-EXISTENCIAS
				</p>
			</div>
		</section>
		<div class="full-width divider-menu-h"></div>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__panel is-active" id="KsvmListaExistencia">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
						<div class="">
							<!-- Formulario de busqueda -->
							<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
									<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarExt">
										<i class="zmdi zmdi-search"></i>
									</label>
									<div class="mdl-textfield__expandable-holder">
										<input class="mdl-textfield__input" type="text" id="KsvmBuscarExt"
											name="KsvmBuscarExt">
										<label class="mdl-textfield__label"></label>
									</div>
									<div class="mdl-textfield--expandable navBar-options-list">
										<a class="btn btn-sm btn-success mdl-shadow--8dp"
											href="<?php echo KsvmServUrl;?>Reportes/KsvmExistenciasPdf.php"
											target="_blank"><i class="zmdi zmdi-file">&nbsp;PDF</i></a>
										<a href="#KsvmNuevaExistencia" id="btn-input"
											class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
												class="zmdi zmdi-plus-circle"></i></a>
									</div>
								</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>

						<!-- Método para mostrar la lista de Existencias -->
						<?php
                    require_once "./Controladores/KsvmExistenciaControlador.php";
					$KsvmIniExt = new KsvmExistenciaControlador();

					if (isset($_POST['KsvmBuscarExt'])) {

						$_SESSION['KsvmBuscarExt'] = $_POST['KsvmBuscarExt'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniExt -> __KsvmPaginador($KsvmPagina[1], 5, $_SESSION['KsvmRolId-SIGIM'], 
						0, $_SESSION['KsvmBuscarExt']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniExt -> __KsvmPaginador($KsvmPagina[1], 5, $_SESSION['KsvmRolId-SIGIM'], 
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
		  $KsvmDataEdit = $KsvmIniExt->__KsvmEditarExistenciaControlador($KsvmPagina[2]);

		  if ($KsvmDataEdit->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataEdit->fetch();         

              $KsvmEstado = "";
				if ($KsvmLlenarForm['ExtEstEx'] == 'C') {
				    $KsvmEstado = "Caducado";
				} elseif ($KsvmLlenarForm['ExtEstEx'] == 'A') {
					$KsvmEstado = "Activo";
				} else {
				    $KsvmEstado = "Agotado";
				}
			  
	    ?>
			<script>
				window.onload = function () {

					$("#KsvmFormEx").trigger("reset");
					$(".modal-title").text("Detalles Existencia");
					$("#KsvmDetallesExistencia").modal({
						show: true
					});
				}
			</script>

			<!-- Formulario de Detalles del Existencia -->

			<div class="modal fade" id="KsvmDetallesExistencia" tabindex="-1" role="dialog"
				aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content ">
						<div class="modal-header">
							<button class="close close-edit" type="button" data-dismiss="modal"
								aria-hidden="true">&times;</button>
							<h5 class="modal-title text-center"></h5>
						</div>
						<div class="modal-body">
							<form action="" method="POST" id="KsvmFormEx">
								<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Bodega :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['BdgDescBod'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Fecha de Caducidad :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExtFchCadEx'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Stock Inicial :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExtStockIniEx'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Stock de Seguridad :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExbStockSegEbo'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Código de Localización :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExtBinLocEx'];?></div>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Medicamento:</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['MdcDescMed'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Lote :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExtLoteEx'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Presentación :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExtPresentEx'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Stock :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExbStockEbo'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Código de Barras :</strong>
												&nbsp; &nbsp;<sgv
													id="Barcode<?php echo $KsvmLlenarForm['ExtCodBarEx'];?>">
													<a href="#" class="btn btn-xs btn-success">IMPRIMIR</a></div>

										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Estado :</strong>
												&nbsp; &nbsp;<?php echo $KsvmEstado;?></div>
										</div>
									</div>
								</div>
								<div class="mdl-tooltip" for="btn-NuevoExistencia">Editar Existencia</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<?php } }?>

			<!-- Formulario para ingresar un nuevo Existencia -->

			<div class="mdl-tabs__panel" id="KsvmNuevaExistencia">
				<div class="mdl-grid">
					<div
						class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
						<div class="" style="float:right;">
							<a href="<?php echo KsvmServUrl;?>KsvmExistenciasCrud/1/" id="btn-input"
								class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
									class="zmdi zmdi-arrow-left"></i></a>
						</div>
						<br><br>
						<div class="full-width panel mdl-shadow--8dp">
							<div class="full-width modal-header-input text-center">
								Nueva Existencia
							</div>
							<div class="full-width panel-content">
								<form data-form="guardar"
									action="<?php echo KsvmServUrl; ?>Ajax/KsvmExistenciasAjax.php" method="POST"
									class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
									id="KsvmFormExistencia">

									<div class="mdl-grid">
										<div
											class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" name="KsvmBdgId">
													<option value="" disabled="" selected="">Seleccione Bodega</option>
													<?php require_once "./Controladores/KsvmBodegaControlador.php";
													$KsvmSelBod = new KsvmBodegaControlador();
													echo $KsvmSelBod->__KsvmSeleccionarBodega();
													?>
												</select>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" id="KsvmDocId" name="KsvmDocId">
													<option value="" disabled="" selected="">Seleccione Medicamento
													</option>
												</select>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmLoteEx"
													id="KsvmDato1">
												<label class="mdl-textfield__label" for="KsvmDato1">Lote</label>
												<span class="mdl-textfield__error">Lote Inválido</span>
												<span id="KsvmError1" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" name="KsvmPresentEx"
													id="KsvmDato2">
													<option value="" selected="">Seleccione Presentación
													</option>
													<option value="Solido oral">Sólido oral</option>
													<option value="Liquido oral">Líquido oral</option>
													<option value="lt">Litros</option>
													<option value="ml">Mililitros</option>
													<option value="ud">Unidades</option>
												</select>
												<span id="KsvmError2" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
												id="KsvmStockEx">
												<input class="mdl-textfield__input" type="text" name="KsvmStockEx"
													pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato3">
												<label class="mdl-textfield__label" for="KsvmStockEx">Stock</label>
												<span class="mdl-textfield__error">Stock Inválido</span>
												<span id="KsvmError3" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
										</div>
										<div
											class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" id="KsvmCmpId" required>
													<option value="" disabled="" selected="">Seleccione Compra
													</option>
													<?php require_once "./Controladores/KsvmCompraControlador.php";
													$KsvmSelCompra = new KsvmCompraControlador();
													echo $KsvmSelCompra->__KsvmSeleccionarCompra();
													?>
												</select>
											</div>
											<div class="mdl-textfield mdl-js-textfield">
												<input type="text" class="mdl-textfield__input tcal" id="KsvmDato4"
													name="KsvmFchCadEx" placeholder="Fecha de Caducidad">
												<span id="KsvmError4" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmStockIniEx"
													pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato5">
												<label class="mdl-textfield__label" for="KsvmDato5">Stock
													Inicial</label>
												<span class="mdl-textfield__error">Stock Inicial Inválido</span>
												<span id="KsvmError5" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmStockSegEx"
													pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato6">
												<label class="mdl-textfield__label" for="KsvmDato6">Stock de
													Seguridad</label>
												<span class="mdl-textfield__error">Stock de Seguridad Inválido</span>
												<span id="KsvmError6" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmBinLocEx"
													id="KsvmDato7">
												<label class="mdl-textfield__label" for="KsvmDato7">Código de
													Localización</label>
												<span class="mdl-textfield__error">BinLoc Inválido</span>
												<span id="KsvmError7" class="ValForm"><i
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
									<div class="mdl-tooltip" for="btnSave">Agregar Existencia</div>
									<div class="RespuestaAjax"></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>