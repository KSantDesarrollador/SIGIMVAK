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
			EDITAR-PEDIDOS
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

        require_once "./Controladores/KsvmRequisicionControlador.php";
        $KsvmIniReq = new KsvmRequisicionControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniReq->__KsvmEditarRequisicionControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();
              
              $KsvmEstado = "";
				if ($KsvmLlenarForm['RqcEstReq'] == 'N') {
				    $KsvmEstado = "Nuevo";
				} elseif ($KsvmLlenarForm['RqcEstReq'] == 'P') {
					$KsvmEstado = "En proceso";
				} elseif ($KsvmLlenarForm['RqcEstReq'] == 'A') {
					$KsvmEstado = "Aprobado";
				} else {
				    $KsvmEstado = "Negado";
				}
			  
	    ?>

 <!-- Formulario para editar un Usuario -->
 <div class="mdl-tabs" id="KsvmActualizarRequisicion">
     <div class="mdl-grid">
         <div
             class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
             <div class="navBar-options-button">
             <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmRequisicionesCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmRequisiciones/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Pedido
                 </div>
                 <div class="full-width panel-content">
                 <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmRequisicionAjax.php"
							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
							id="KsvmFormOcp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" id="KsvmBdgInv" name="KsvmOrigenReq">
                                         <option value="<?php echo $KsvmLlenarForm['RqcOrigenReq'];?>" selected="">
                                            <?php echo $KsvmLlenarForm['RqcOrigenReq'];?></option>
                                             <?php require_once "./Controladores/KsvmBodegaControlador.php";
													$KsvmSelBod = new KsvmBodegaControlador();
													echo $KsvmSelBod->__KsvmSeleccionarBodega();
													?>
                                     </select>
                                    </div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="KsvmNomMedReq">
										<input class="mdl-textfield__input" type="number" name="KsvmNomMedReq"
											value="<?php echo $KsvmLlenarForm['RqcNomMedReq'];?>">
										<label class="mdl-textfield__label" for="KsvmNomMedReq">Medicamento</label>
										<span class="mdl-textfield__error">Medicamento Inválido</span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="KsvmStockReq">
										<input class="mdl-textfield__input" type="number" name="KsvmStockReq"
											value="<?php echo $KsvmLlenarForm['RqcStockReq'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?">
										<label class="mdl-textfield__label" for="KsvmStockReq">Stock</label>
										<span class="mdl-textfield__error">Stock Inválido</span>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield">
										<input type="date" class="mdl-textfield__input" id="KsvmFchRevReq"
											value="<?php echo $KsvmLlenarForm['RqcFchRevReq'];?>" name="KsvmFchRevReq">
										<label class="mdl-textfield__label" for="KsvmFchRevReq"
											style="text-align:right;">Fecha de
											Revisión</label>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmPerAprbReq"
											value="<?php echo $KsvmLlenarForm['RqcPerAprbReq'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmPerAprbReq">
										<label class="mdl-textfield__label" for="KsvmPerAprbReq">Persona que Aprueba</label>
										<span class="mdl-textfield__error">Nombre Inválido</span>
                                    </div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmObservReq"
											value="<?php echo $KsvmLlenarForm['RqcObservReq'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmObservReq">
										<label class="mdl-textfield__label" for="KsvmObservReq">Observación</label>
										<span class="mdl-textfield__error">Observación Inválida</span>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
                                    <div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" name="KsvmIvtId" id="KsvmIvtId">
                                    <option value="<?php echo $KsvmLlenarForm['IvtId'];?>" selected="">
                                      <?php echo $KsvmLlenarForm['IvtCodInv'];?></option>
                                     </select>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="number" name="KsvmCantReq"
											value="<?php echo $KsvmLlenarForm['RqcCantReq'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmCantReq">
										<label class="mdl-textfield__label" for="KsvmCantReq">Cantidad</label>
										<span class="mdl-textfield__error">Cantidad Inválida</span>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<input type="date" class="mdl-textfield__input" id="KsvmFchElabReq"
											value="<?php echo $KsvmLlenarForm['RqcFchElabReq'];?>" name="KsvmFchElabReq">
										<label class="mdl-textfield__label" for="KsvmFchElabReq"
											style="text-align:right;">Fecha de
											Elaboración</label>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmPerElabReq"
											value="<?php echo $KsvmLlenarForm['RqcPerElabReq'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmPerElabReq">
										<label class="mdl-textfield__label" for="KsvmPerElabReq">Persona que Elabora</label>
										<span class="mdl-textfield__error">Nombre Inválido</span>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield">
										<select class="mdl-textfield__input" name="KsvmEstReq">
											<option value="<?php echo $KsvmLlenarForm['RqcEstReq'];?>"
												selected=""><?php echo $KsvmEstado;?></option>
											<option value="N">Nuevo</option>
											<option value="P">En proceso</option>
											<option value="A">Aprobado</option>
											<option value="X">Negado</option>
										</select>
									</div>
								</div>
							</div>
							<p class="text-center">
								<button type="submit"
									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
									id="btn-EditarRequisicion">
									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
								</button>
							</p>
							<div class="mdl-tooltip" for="btn-EditarRequisicion">Editar Requisicion</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>