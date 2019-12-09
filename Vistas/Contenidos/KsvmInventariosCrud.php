<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->
<?php
  require_once "./Archivos/KsvmMostrarRegistrosInventario.php";
  $KsvmIniInv = new KsvmMostrarRegistrosInventario();
?>

<!-- pageContent -->
<section class="full-width pageContent">
	<section class="full-width header-well">
		<div class="full-width header-well-icon">
			<i class="zmdi zmdi-folder-star"></i>
		</div>
		<div class="full-width header-well-text">
			<p class="text-condensedLight">
				CRUD-INVENTARIOS
			</p>
		</div>
	</section>
	<!-- <div class="full-width divider-menu-h"></div> -->
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__panel" id="KsvmNuevoInventario">
			<div class="mdl-grid">
				<!-- Formulario para ingresar un nuevo Inventario -->
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<div class="" style="float:right;">
							<a href="<?php echo KsvmServUrl;?>KsvmInventariosCrud/1/" id="btn-input"
								class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VER LISTA &nbsp;<i
									class="zmdi zmdi-arrow-left"></i></a>
						</div>
						<br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nuevo Inventario
						</div>
						<div class="full-width panel-content">
							<form action="<?php echo KsvmServUrl; ?>Ajax/KsvmInventarioAjax.php" method="POST"
								class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormCompra" data-form="guardar">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
										<div>
											<button type="button" id="btnIniciar"
												class="btn btn-success btn-IniInv">&nbsp;<i
													class="zmdi zmdi-power"></i>&nbsp;</button>
										</div>
										&nbsp;
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
											hidden>
											<input class="mdl-textfield__input" type="text" id="KsvmDuracionInv"
												name="KsvmDuracionInv" value="">
											<!-- <label class="mdl-textfield__label" for="KsvmDuracionInv">Duración</label> -->
											<!-- <span class="mdl-textfield__error">Duración Inválida</span> -->
										</div>
									</div>
									&nbsp;
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
										<p class="mdl-textfield mdl-js-textfield tittles" style="font-size:20px;"
											id="leyenda">
											Para Comenzar con el Inventario presione el botón</p>
									</div>
									&nbsp;
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmBdgId" id="KsvmBdgExt"
												required>
												<option value="" disabled="" selected="">Seleccione Bodega
												</option>
												<!-- <option><div><input class="mdl-textfield__input" type="text" id="KsvmBuscarInv"
											     name="KsvmBuscarInv"></div></option> -->
												<?php require_once "./Controladores/KsvmBodegaControlador.php";
													$KsvmSelBodega = new KsvmBodegaControlador();
													echo $KsvmSelBodega->__KsvmSeleccionarBodega();
													?>
											</select>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									</div>
									<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop"
										id="GridData">
										<p class="text-center">
											<button type="submit" style="width:49%; float:left;"
												class="mdl-button mdl-js-button mdl-js-ripple-effect btn-info mdl-shadow--4dp"
												id="btnContinuar">
												<i class="zmdi zmdi-flash" style="font-size:15px;">&nbsp;
													&nbsp;Confirmar Pedido</i>
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
							<form action="<?php echo KsvmServUrl; ?>Ajax/KsvmAgregarRegistrosInventarioAjax.php"
								method="POST" class="RegistrosAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormInventario">
								<div class="mdl-grid" id="GridRowsInv">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmExtId" id="KsvmExtId"
												required>
												<option value="" disabled="" selected="">Seleccione Existencia
												</option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="number" max="1000" min="1"
												name="KsvmContFisInv" pattern="-?[0-9+()- ]*(\.[0-9]+)?" id="KsvmContFisInv"
												required>
											<label class="mdl-textfield__label" for="KsvmContFisInv">Conteo
												Físico</label>
											<!-- <span class="mdl-textfield__error">Conteo Inválido</span> -->
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="KsvmStockInv">
											<input class="mdl-textfield__input" type="text" name="KsvmStockInv"
												pattern="-?[0-9]*(\[0-9]+)?" required>
											<label class="mdl-textfield__label" for="KsvmStockInv">Stock de
												Sistema</label>
											<!-- <span class="mdl-textfield__error">Stock Inválido</span> -->
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="KsvmObservInv">
											<input class="mdl-textfield__input" type="text" name="KsvmObservInv" >
											<label class="mdl-textfield__label" for="KsvmStockInv">Observación</label>
											<!-- <span class="mdl-textfield__error">Stock Inválido</span> -->
										</div>
										<br>
										<p class="text-center">
											<button type="submit" style="width:49%; float:left;"
												class="mdl-button mdl-js-button mdl-js-ripple-effect btn-success mdl-shadow--4dp"
												id="btnAgregar">
												<i class="zmdi zmdi-plus" style="font-size:20px;"></i>&nbsp;Agregar
											</button>

											<button type="reset" style="width:49%; float:right;"
												class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
												id="btnGuardar" onClick="muestra_oculta('GridData')">
												<i class="zmdi zmdi-power" style="font-size:20px;"></i>&nbsp;
												&nbsp;Terminar
											</button>
										</p>
										<div class="mdl-tooltip" for="btnAgregar">Agregar</div>
										<div class="mdl-tooltip" for="btnGuardar">Guardar</div>
									</div>
									<div class="Respuesta"></div>
								</div>
						</div>
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

		<div class="mdl-tabs__panel is-active" id="KsvmListaInventarios">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<div class="">
						<!-- Formulario de busqueda -->
						<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
								<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarInv">
									<i class="zmdi zmdi-search"></i>
								</label>
								<div class="mdl-textfield__expandable-holder">
									<input class="mdl-textfield__input" type="text" id="KsvmBuscarInv"
										name="KsvmBuscarInv">
									<label class="mdl-textfield__label"></label>
								</div>
								<div class="mdl-textfield--expandable navBar-options-list">
									<a class="btn btn-sm btn-success mdl-shadow--8dp mdl-tabs__tab">PDF</a>&nbsp;
									<a href="#KsvmNuevoInventario" id="btn-input" 
										class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
											class="zmdi zmdi-plus-circle"></i></a>
								</div>
							</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>

					<!-- Método para mostrar la lista de Inventarios -->
					<?php
                    require_once "./Controladores/KsvmInventarioControlador.php";
					$KsvmIniInv = new KsvmInventarioControlador();

					if (isset($_POST['KsvmBuscarInv'])) {

						$_SESSION['KsvmBuscarInv'] = $_POST['KsvmBuscarInv'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniInv -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, $_SESSION['KsvmBuscarInv']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniInv -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
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
		  $KsvmDataEdit = $KsvmIniInv->__KsvmEditarDetalleInventarioControlador($KsvmPagina[2]);

			  $KsvmQuery = $KsvmDataEdit->fetchAll();
			  
	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormOcp").trigger("reset");
				$(".modal-title").text("Detalles Inventario");
				$("#KsvmDetallesInventario").modal({
					show: true
				});
			}
		</script>

		<!-- Formulario de Detalles del Inventario -->

		<div class="modal fade" id="KsvmDetallesInventario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header">
						<button class="close close-edit" type="button" id="btnExitInv" data-dismiss="modal"
							aria-hidden="true">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body">
						<form action="" method="POST" id="KsvmFormOcp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-textfield"><strong>Num.Inventario :</strong></div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-textfield"><strong>Medicamento:</strong></div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-textfield"><strong>Fch.Cad :</strong></div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
									<div class="mdl-textfield"><strong>Stock :</strong></div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-textfield"><strong>Cont.Físico :</strong></div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-textfield"><strong>Diferencia :</strong></div>
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
											<?php echo $KsvmLlenarForm['IvtCodInv'];?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
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
											<?php echo $KsvmLlenarForm['ExtFchCadEx'];?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
									<div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
										<div class="mdl-textfield__input">
											<?php echo $KsvmLlenarForm['DivStockInv'];?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
										<div class="mdl-textfield__input">
											<?php echo $KsvmLlenarForm['DivContFisInv'];?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
									<div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
										<div class="mdl-textfield__input">
											<?php echo $KsvmLlenarForm['DivDifInv'];?></div>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
									<a class="btn btn-sm btn-primary"
										href="<?php echo KsvmServUrl;?>KsvmDetallesInventarioEditar/<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['DivId']);?>/0/"><i
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

<script>

</script>