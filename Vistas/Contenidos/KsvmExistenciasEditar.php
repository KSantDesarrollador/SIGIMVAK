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
			EDITAR-EXISTENCIAS
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

        require_once "./Controladores/KsvmExistenciaControlador.php";
        $KsvmIniExt = new KsvmExistenciaControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniExt->__KsvmEditarExistenciaControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();
              
              $KsvmPresentacion = "";
                if ($KsvmLlenarForm['ExtPresentEx'] == 'gr') {
                    $KsvmPresentacion = "Gramos";
                } elseif ($KsvmLlenarForm['ExtPresentEx'] == 'mg') {
                    $KsvmPresentacion = "Miligramos";
                } elseif ($KsvmLlenarForm['ExtPresentEx'] == 'lt') {
                    $KsvmPresentacion = "Litros";
                } elseif ($KsvmLlenarForm['ExtPresentEx'] == 'ml') {
                    $KsvmPresentacion = "Mililitros";
                } else {
                    $KsvmPresentacion = "Undidades";
                }
                

              $KsvmEstado = "";
				if ($KsvmLlenarForm['ExtEstEx'] == 'C') {
				    $KsvmEstado = "Caducado";
				} elseif ($KsvmLlenarForm['ExtEstEx'] == 'A') {
					$KsvmEstado = "Activo";
				} else {
				    $KsvmEstado = "Agotado";
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
                echo '<a href="'.KsvmServUrl.'KsvmExistenciasCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmExistencias/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
			<br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Existencia
                 </div>
                 <div class="full-width panel-content">
                 <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmExistenciasAjax.php"
							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
							id="KsvmFormOcp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" name="KsvmBdgId">
                                         <option value="<?php echo $KsvmLlenarForm['BdgId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['BdgDescBod'];?></option>
                                             <?php require_once "./Controladores/KsvmBodegaControlador.php";
											   $KsvmSelBod = new KsvmBodegaControlador();
											   echo $KsvmSelBod->__KsvmSeleccionarBodega();
										     ?>
                                     </select>
                                    </div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmLoteEx"
											value="<?php echo $KsvmLlenarForm['ExtLoteEx'];?>"
											 id="KsvmLoteEx">
										<label class="mdl-textfield__label" for="KsvmLoteEx">Lote</label>
										<span class="mdl-textfield__error">Lote Inválido</span>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<select class="mdl-textfield__input" name="KsvmPresentEx">
											<option value="<?php echo $KsvmLlenarForm['ExtPresentEx'];?>"
												selected=""><?php echo $KsvmPresentacion;?></option>
											<option value="gr">Gramos</option>
											<option value="mg">Miligramos</option>
											<option value="lt">Litros</option>
                                            <option value="ml">Mililitros</option>
                                            <option value="ud">Unidades</option>
										</select>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmStockEx"
											value="<?php echo $KsvmLlenarForm['ExbStockEbo'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmStockEx">
										<label class="mdl-textfield__label" for="KsvmStockEx">Stock</label>
										<span class="mdl-textfield__error">Stock Inválido</span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmCodBarEx"
											value="<?php echo $KsvmLlenarForm['ExtCodBarEx'];?>"
                                            id="KsvmCodBarEx">
										<label class="mdl-textfield__label" for="KsvmCodBarEx">Código de barras</label>
										<!-- <span class="mdl-textfield__error">Código de barras Inválido</span> -->
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" name="KsvmMdcId">
                                         <option value="<?php echo $KsvmLlenarForm['MdcId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['MdcDescMed'];?></option>
                                             <?php require_once "./Controladores/KsvmMedicamentoControlador.php";
											   $KsvmSelMedic = new KsvmMedicamentoControlador();
											   echo $KsvmSelMedic->__KsvmSeleccionarMedicamento();										     ?>
                                     </select>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<input type="date" class="mdl-textfield__input" id="KsvmFchCadEx"
											value="<?php echo $KsvmLlenarForm['ExtFchCadEx'];?>" name="KsvmFchCadEx">
										<label class="mdl-textfield__label" for="KsvmFchCadEx"
											style="text-align:right;">Fecha de
											Caducidad</label>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmStockIniEx"
											value="<?php echo $KsvmLlenarForm['ExtStockIniEx'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmStockIniEx">
										<label class="mdl-textfield__label" for="KsvmStockIniEx">Stock Inicial</label>
										<span class="mdl-textfield__error">Stock Inicial Inválido</span>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmStockSegEx"
											value="<?php echo $KsvmLlenarForm['ExbStockSegEbo'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmStockSegEx">
										<label class="mdl-textfield__label" for="KsvmStockSegEx">Stock de Seguridad</label>
										<span class="mdl-textfield__error">Stock de Seguridad Inválido</span>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmBinLocEx"
											value="<?php echo $KsvmLlenarForm['ExtBinLocEx'];?>"
											 id="KsvmBinLocEx">
										<label class="mdl-textfield__label" for="KsvmBinLocEx">Código de Localización</label>
										<span class="mdl-textfield__error">BinLoc Inválido</span>
									</div>
								</div>
							</div>
							<p class="text-center">
								<button type="submit"
									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
									id="btn-NuevoExistencia">
									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
								</button>
							</p>
							<div class="mdl-tooltip" for="btn-NuevoExistencia">Editar Existencia</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>