 <!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

 <!-- pageContent -->
 <section class="full-width pageContent">
 	<section class="full-width header-well">
 		<div class="full-width header-well-icon">
 			<i class="zmdi zmdi-folder-star"></i>
 		</div>
 		<div class="full-width header-well-text">
 			<p class="text-condensedLight">
 				EDITAR-INVENTARIOS
 			</p>
 		</div>
 	</section>
 	<div class="full-width divider-menu-h"></div>
 	<!-- Método para cargar datos en el formulario -->
 	<?php 

        require_once "./Controladores/KsvmInventarioControlador.php";
        $KsvmIniExt = new KsvmInventarioControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniExt->__KsvmEditarInventarioControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();

              $KsvmEstado = "";
				if ($KsvmLlenarForm['IvtEstInv'] == 'N') {
				    $KsvmEstado = "Nuevo";
				} elseif ($KsvmLlenarForm['IvtEstInv'] == 'P') {
					$KsvmEstado = "En Proceso";
				} else {
				    $KsvmEstado = "Terminado";
				}
			  
	    ?>

 	<!-- Formulario para editar un Usuario -->
 	<div class="mdl-tabs" id="KsvmActualizarUsuario">
 		<div class="mdl-grid">
 			<div
 				class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
 				<div class="navBar-options-button">
 					<?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmInventariosCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmInventarios/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
 				</div>
 				<br>
 				<div class="full-width panel mdl-shadow--8dp">
 					<div class="full-width  modal-header-edit text-center ">
 						Editar Inventario
 					</div>
 					<div class="full-width panel-content">
 						<form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmInventarioAjax.php"
 							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
 							id="KsvmFormOcp">
 							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
 							<div class="mdl-grid">
 								<div
 									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
 									<div class="mdl-textfield mdl-js-textfield">
 										<select class="ksvmSelectDin" name="KsvmBdgId" id="KsvmDato1"
 											style="width:100%;">
 											<option value="" selected="">
 												<?php echo $KsvmLlenarForm['BdgDescBod'];?></option>
 											<?php require_once "./Controladores/KsvmBodegaControlador.php";
                                                    $KsvmSelBod = new KsvmBodegaControlador();
                                                    echo $KsvmSelBod->__KsvmSeleccionarBodega();
                                                    ?>
 										</select>
 										<span id="KsvmError1" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
 										id="KsvmHoraInv">
 										<input class="mdl-textfield__input" type="text" name="KsvmHoraInv"
 											value="<?php echo $KsvmLlenarForm['IvtHoraInv'];?>" id="KsvmDato2"
											 pattern="-?[0-9a-z: ]{11,11}">
 										<label class="mdl-textfield__label" for="KsvmDato2">Hora</label>
 										<span class="mdl-textfield__error">Hora Inválido</span>
 										<span id="KsvmError2" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
 										<input class="mdl-textfield__input" type="time" name="KsvmDuracionInv"
 											value="<?php echo $KsvmLlenarForm['IvtDuracionInv'];?>"
 											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato3">
 										<label class="mdl-textfield__label" for="KsvmDato3">Duración</label>
 										<span class="mdl-textfield__error">Duración Inválido</span>
 										<span id="KsvmError3" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 									<div class="mdl-textfield mdl-js-textfield">
 										<select class="ksvmSelectDin" name="KsvmEstInv" id="KsvmDato4"
 											style="width:100%;">
 											<option value="<?php echo $KsvmLlenarForm['IvtEstInv'];?>" s selected="">
 												<?php echo $KsvmEstado;?></option>
 											<option value="N">Nuevo</option>
 											<option value="P">En proceso</option>
 											<option value="T">Terminado</option>
 										</select>
 										<span id="KsvmError4" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 								</div>
 							</div>
 							<p class="text-center">
 								<button type="submit"
 									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
 									id="btnSave">
 									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
 								</button>
 							</p>
 							<div class="mdl-tooltip" for="btnSave">Editar Inventario</div>
 							<div class="RespuestaAjax"></div>
 						</form>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 	<?php } }?>

 </section>