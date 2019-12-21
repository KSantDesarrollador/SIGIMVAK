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
 				EDITAR-TRANSACCIONES
 			</p>
 		</div>
 	</section>
 	<div class="full-width divider-menu-h"></div>
 	<!-- Método para cargar datos en el formulario -->
 	<?php 

        require_once "./Controladores/KsvmTransaccionControlador.php";
        $KsvmIniTran = new KsvmTransaccionControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniTran->__KsvmEditarDataTransaccionControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();
              
              $KsvmEstado = "";
				if ($KsvmLlenarForm['TsnEstTran'] == 'N') {
				    $KsvmEstado = "Nuevo";
				} elseif ($KsvmLlenarForm['TsnEstTran'] == 'P') {
					$KsvmEstado = "En proceso";
				} elseif ($KsvmLlenarForm['TsnEstTran'] == 'A') {
					$KsvmEstado = "Aprobado";
				} else {
				    $KsvmEstado = "Negado";
				}
			  
	    ?>

 	<!-- Formulario para editar un Usuario -->
 	<div class="mdl-tabs" id="KsvmActualizarTransaccion">
 		<div class="mdl-grid">
 			<div
 				class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
 				<div class="navBar-options-button">
 					<?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmTransaccionesCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>
                </div>
                <br>
                 <div class="full-width panel mdl-shadow--8dp">
                     <div class="full-width  modal-header-edit text-center ">
                         Editar Transacción
                     </div>';
               } elseif ($KsvmPagina[2] == 1) {
				echo '<a href="'.KsvmServUrl.'KsvmIngresos/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>
                </div>
                <br>
                 <div class="full-width panel mdl-shadow--8dp">
                     <div class="full-width  modal-header-edit text-center ">
                         Editar Ingreso
                     </div>';
			   } else {
                echo '<a href="'.KsvmServUrl.'KsvmEgresos/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>
                </div>
                <br>
                 <div class="full-width panel mdl-shadow--8dp">
                     <div class="full-width  modal-header-edit text-center ">
                         Editar Egreso
                     </div>';
               }
               
             ?>
 					<div class="full-width panel-content">
 						<form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmTransaccionAjax.php"
 							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
 							id="KsvmFormOcp">
 							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
 							<div class="mdl-grid">
 								<div
 									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
 									<div class="mdl-textfield mdl-js-textfield">
 										<select class="mdl-textfield__input" id="KsvmExtId" name="KsvmExtId">
 											<option value="<?php echo $KsvmLlenarForm['ExtId'];?>" selected="">
 												<?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed'];?>
 											</option>
 											<?php require_once "./Controladores/KsvmExistenciaControlador.php";
													$KsvmSelExt = new KsvmExistenciaControlador();
													echo $KsvmSelExt->__KsvmSeleccionExistencia();
													?>
 										</select>
 										<!-- <span id="KsvmError1" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span> -->
 									</div>
 									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
 										<input class="mdl-textfield__input" type="number" name="KsvmCantTran"
 											value="<?php echo $KsvmLlenarForm['DtsCantTran'];?>"
 											pattern="-?[0-9]*[A-Za-záéíóúÁÉÍÓÚ ]?" id="KsvmDato1">
 										<label class="mdl-textfield__label" for="KsvmDato1">Cantidad</label>
 										<span class="mdl-textfield__error">Cantidad Inválida</span>
 										<span id="KsvmError1" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 									<div class="mdl-textfield mdl-js-textfield">
 										<select class="mdl-textfield__input" name="KsvmEstTran" id="KsvmDato2">
 											<option value="<?php echo $KsvmLlenarForm['DtsTipoTran'];?>" selected="">
 												<?php echo $KsvmLlenarForm['DtsTipoTran'];;?></option>
 											<option value="Ingreso">Ingreso</option>
 											<option value="Egreso">Egreso</option>
 										</select>
 										<span id="KsvmError2" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
 										<input class="mdl-textfield__input" type="text" name="KsvmObservTran"
 											value="<?php echo $KsvmLlenarForm['DtsObservTran'];?>"
 											pattern="-?[A-Za-záéíóúÁÉÍÓÚ0-9 ]*(\.[]+)?" id="KsvmObservTran">
 										<label class="mdl-textfield__label" for="KsvmObservTran">Observación</label>
 										<span class="mdl-textfield__error">Observación Inválida</span>
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
 							<div class="mdl-tooltip" for="btnSave">Editar Transaccion</div>
 							<div class="RespuestaAjax"></div>
 						</form>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 	<?php } }?>

 </section>