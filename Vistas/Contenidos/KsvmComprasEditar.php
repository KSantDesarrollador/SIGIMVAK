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
 				EDITAR-COMPRAS
 			</p>
 		</div>
 	</section>
 	<div class="full-width divider-menu-h"></div>
 	<!-- Método para cargar datos en el formulario -->
 	<?php 

        require_once "./Controladores/KsvmCompraControlador.php";
        $KsvmIniOcp = new KsvmCompraControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniOcp->__KsvmEditarCompraControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();
              
              $KsvmEstado = "";
				if ($KsvmLlenarForm['CmpEstOcp'] == 'N') {
				    $KsvmEstado = "Nuevo";
				} elseif ($KsvmLlenarForm['CmpEstOcp'] == 'P') {
					$KsvmEstado = "En proceso";
				} elseif ($KsvmLlenarForm['CmpEstOcp'] == 'A') {
					$KsvmEstado = "Aprobado";
				} else {
				    $KsvmEstado = "Negado";
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
                echo '<a href="'.KsvmServUrl.'KsvmComprasCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmCompras/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
 				</div>
 				<br>
 				<div class="full-width panel mdl-shadow--8dp">
 					<div class="full-width  modal-header-edit text-center ">
 						Editar Compra
 					</div>
 					<div class="full-width panel-content">
 						<form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmComprasAjax.php"
 							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
 							id="KsvmFormOcp">
 							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
 							<div class="mdl-grid">
 								<div
 									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
 									<div class="mdl-textfield mdl-js-textfield">
 										<select class="ksvmSelectDin" name="KsvmPvdId" id="KsvmDato1"
 											style="width:98%;">
 											<option value="<?php echo $KsvmLlenarForm['PvdId'];?>" selected="">
 												<?php echo $KsvmLlenarForm['PvdRazSocProv'];?></option>
 											<?php require_once "./Controladores/KsvmProveedorControlador.php";
											   $KsvmSelProv = new KsvmProveedorControlador();
											   echo $KsvmSelProv->__KsvmSeleccionarProveedor();
										     ?>
 										</select>
 										<span id="KsvmError1" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
 										<input class="mdl-textfield__input" type="text" name="KsvmNumFactOcp"
 											value="<?php echo $KsvmLlenarForm['CmpNumFactOcp'];?>"
 											pattern="-?[0-9A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato2">
 										<label class="mdl-textfield__label" for="KsvmDato2">Num. Factura</label>
 										<span class="mdl-textfield__error">Num. Factura Inválida</span>
 										<span id="KsvmError2" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 									<div class="mdl-textfield mdl-js-textfield">
 										<input type="text" class="mdl-textfield__input tcal" id="KsvmDato3"
 											value="<?php echo $KsvmLlenarForm['CmpFchRevOcp'];?>"
 											name="KsvmFchRevOcp">
 										<label class="mdl-textfield__label" for="KsvmDato3"
 											style="text-align:right;">Fecha de
 											Revisión</label>
 										<span id="KsvmError3" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
 										<input class="mdl-textfield__input" type="text" name="KsvmPerAprbOcp"
 											value="<?php echo $KsvmLlenarForm['CmpPerAprbOcp'];?>"
 											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato4">
 										<label class="mdl-textfield__label" for="KsvmDato4">Persona Aprueba</label>
 										<span class="mdl-textfield__error">Nombre Inválido</span>
 										<span id="KsvmError4" class="ValForm"><i
 												class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
 												campo</i></span>
 									</div>
 									<div class="mdl-textfield mdl-js-textfield">
 										<select class="ksvmSelectDin" name="KsvmEstOcp" id="KsvmDato5"
 											style="width:98%;">
 											<option value="<?php echo $KsvmLlenarForm['CmpEstOcp'];?>" selected="">
 												<?php echo $KsvmEstado;?></option>
 											<option value="N">Nuevo</option>
 											<option value="P">En proceso</option>
 											<option value="A">Aprobado</option>
 											<option value="X">Negado</option>
 										</select>
 										<span id="KsvmError5" class="ValForm"><i
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
 							<div class="mdl-tooltip" for="btnSave">Editar Compra</div>
 							<div class="RespuestaAjax"></div>
 						</form>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 	<?php } }?>

 </section>