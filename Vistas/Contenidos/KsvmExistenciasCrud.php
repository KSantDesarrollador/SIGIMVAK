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
			  
			  require_once 'barcode.php';


		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[2] != "") {
		  $KsvmDataEdit = $KsvmIniExt->__KsvmEditarDetalleExistenciaControlador($KsvmPagina[2]);

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

				barcode('Reportes/Codigos/'.$KsvmLlenarForm['ExtCodBarEx'].'.png', $KsvmLlenarForm['ExtCodBarEx'], 25, 'horizontal', 'codabar', true,2);
			  
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
							<button class="close close-edit" type="button" data-dismiss="modal" id="btnExitExtCrud"
								aria-hidden="true">&times;</button>
							<h5 class="modal-title text-center"></h5>
						</div>
						<div class="modal-body">
							<form action="" method="POST" id="KsvmFormEx">
								<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<div class="img-responsive">
												<img height="183px" width="60%"
													src="data:image/jpg;base64,<?php echo base64_encode($KsvmLlenarForm['MdcFotoMed']);?>" />
											</div>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Bodega :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['BdgDescBod'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Medicamento:</strong>
												&nbsp;
												&nbsp;<?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed'];?>
											</div>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Estado :</strong>
												&nbsp; &nbsp;<?php echo $KsvmEstado;?></div>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--7-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<div class="mdl-textfield__input"><strong>Lote :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExtLoteEx'];?></div>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<div class="mdl-textfield__input"><strong>Stock :</strong>
												&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExbStockEbo'];?>
												&nbsp; &nbsp;<strong class="alerta"
													style="background-color:<?php echo $KsvmLlenarForm['AltColorAle'];?>;"><i
														class="zmdi zmdi-alert-triangle" style="font-size:25px;"></i>
													&nbsp; &nbsp;<?php echo $KsvmLlenarForm['AltDescAle'];?></strong>
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
													&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExtStockSegEx'];?></div>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<div class="mdl-textfield__input"><strong>Código de Localización
														:</strong>
													&nbsp; &nbsp;<?php echo $KsvmLlenarForm['ExtBinLocEx'];?></div>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<div class="mdl-textfield__input"><strong>Código de Barras :</strong>
													&nbsp; &nbsp;<img
														src="<?php echo KsvmServUrl?>Reportes/Codigos/<?php echo $KsvmLlenarForm['ExtCodBarEx']?>.png" />
													<a href="<?php echo KsvmServUrl;?>Reportes/KsvmCodBarPdf.php?Cod=<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['ExtId'])?>"
														class="
												btn btn-xs btn-success" style="float:right;"><i class="zmdi zmdi-print">&nbsp; &nbsp;IMPRIMIR</i></a></div>
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
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" id="KsvmCmpId" style="width:98%;" required>
												<option value="" disabled="" selected="">Seleccione Compra
												</option>
												<?php require_once "./Controladores/KsvmCompraControlador.php";
													$KsvmSelCompra = new KsvmCompraControlador();
													echo $KsvmSelCompra->__KsvmSeleccionarCompra();
													?>
											</select>
										</div>
										<div
											class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="ksvmSelectDin" id="KsvmDocId" name="KsvmDocId"
													style="width:100%;">
													<option value="" disabled="" selected="">Seleccione Medicamento
													</option>
												</select>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmLoteEx"
													pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ-]*(\.[0-9]+)?" id="KsvmDato2">
												<label class="mdl-textfield__label" for="KsvmDato2">Lote</label>
												<span class="mdl-textfield__error">Lote Inválido</span>
												<span id="KsvmError2" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="KsvmBinLocEx"
													pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ-]*(\.[0-9]+)?" id="KsvmDato8">
												<label class="mdl-textfield__label" for="KsvmDato8">Código de
													Localización</label>
												<span class="mdl-textfield__error">BinLoc Inválido</span>
												<span id="KsvmError8" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
												id="KsvmStockEx">
												<input class="mdl-textfield__input" type="text" name="KsvmStockEx"
													pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato4">
												<label class="mdl-textfield__label" for="KsvmDato4">Stock</label>
												<span class="mdl-textfield__error">Stock Inválido</span>
												<span id="KsvmError4" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div> -->
										</div>
										<div
											class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
											<div class="mdl-textfield mdl-js-textfield">
												<input type="text" class="mdl-textfield__input tcal" id="KsvmDato5"
													name="KsvmFchCadEx" placeholder="Fecha de Caducidad"
													style="width:93%;" pattern="[0-9-]{10,10}">
												<span class="mdl-textfield__error">Fecha Inválida</span>
												<span id="KsvmError5" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" min="0" max="10000"
													name="KsvmStockIniEx" pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato6">
												<label class="mdl-textfield__label" for="KsvmDato6">Stock
													Inicial</label>
												<span class="mdl-textfield__error">Stock Inicial Inválido</span>
												<span id="KsvmError6" class="ValForm"><i
														class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
														campo</i></span>
											</div>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" min="1" max="10000"
													name="KsvmStockSegEx" pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato7">
												<label class="mdl-textfield__label" for="KsvmDato7">Stock de
													Seguridad</label>
												<span class="mdl-textfield__error">Stock de Seguridad Inválido</span>
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